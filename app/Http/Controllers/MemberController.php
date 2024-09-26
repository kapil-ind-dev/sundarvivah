<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Astrology;
use App\Models\Attitude;
use App\Models\Career;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Package;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Religion;
use App\Models\Caste;
use App\Models\ChatThread;
use App\Models\Education;
use App\Models\ExpressInterest;
use App\Models\Family;
use App\Models\SubCaste;
use App\Models\MemberLanguage;
use App\Models\FamilyValue;
use App\Models\GalleryImage;
use App\Models\HappyStory;
use App\Models\Hobby;
use App\Models\IgnoredUser;
use App\Models\Lifestyle;
use App\Models\MaritalStatus;
use App\Models\OnBehalf;
use App\Models\PackagePayment;
use App\Models\PartnerExpectation;
use App\Models\PhysicalAttribute;
use App\Models\ProfileMatch;
use App\Models\Recidency;
use App\Models\ReportedUser;
use App\Models\Setting;
use App\Models\Shortlist;
use App\Models\SpiritualBackground;
use App\Models\Staff;
use App\Models\Upload;
use App\Models\Wallet;
use App\Models\User;
use App\Models\HighestEducation;
use App\Models\ProfessionModel;
use App\Models\EmployedInModel;
use Hash;
use Validator;
use Redirect;
use Auth;
use App\Utility\EmailUtility;
use App\Utility\SmsUtility;
use MehediIitdu\CoreComponentRepository\CoreComponentRepository;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_members'])->only('index');
        $this->middleware(['permission:create_member'])->only('create');
        $this->middleware(['permission:edit_member'])->only('edit');
        $this->middleware(['permission:delete_member'])->only('destroy');
        $this->middleware(['permission:view_member_profile'])->only('show');
        $this->middleware(['permission:block_member'])->only('block');
        $this->middleware(['permission:update_member_package'])->only('package_info');
        $this->middleware(['permission:login_as_member'])->only('login');
        $this->middleware(['permission:deleted_member_show'])->only('deleted_members');
        $this->middleware(['permission:show_unapproved_profile_picrures'])->only('unapproved_profile_pictures');
        $this->middleware(['permission:approve_profile_picrures'])->only('approve_profile_image');
        $this->middleware(['permission:approve_member'])->only('show_verification_info');
        

        $this->rules = [
            'first_name'        => ['required', 'max:255'],
            'last_name'         => ['required', 'max:255'],
            'email'             => ['max:255', 'unique:users,email'],
            'gender'            => ['required'],
            'date_of_birth'     => ['required'],
            'on_behalf'         => ['required'],
            'package'           => ['required'],
            'password'          => ['min:8', 'required_with:confirm_password', 'same:confirm_password'],
            'confirm_password'  => ['min:8'],

        ];

        $this->messages = [
            'first_name.required'       => translate('First name is required'),
            'first_name.max'            => translate('Max 255 characters'),
            'last_name.required'        => translate('First name is required'),
            'last_name.max'             => translate('Max 255 characters'),
            'email.max'                 => translate('Max 255 characters'),
            'email.unique'              => translate('Email Should be unique'),
            'gender.required'           => translate('Gender is required'),
            'date_of_birth.required'    => translate('Gender is required'),
            'on_behalf.required'        => translate('On behalf is required'),
            'package.required'          => translate('Package is required'),
            'password.min'              => translate('Minimum 8 characters'),
            'password.required_with'    => translate('Password and Confirm password are required'),
            'password.same'             => translate('Password and Confirmed password did not matched'),
            'confirm_password.min'      => translate('Minimum 8 characters'),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $sort_search = null;
        // echo $id; die;
        // Start building the query
        $members = User::latest()
            ->where('user_type', 'member')
            ->where('blocked', 0)
            ->where('membership', $id)
            ->where(function ($query) {
                $query->where('deactivated', 0);
            });
    
        // Check if there is a search term
        if ($request->has('search')) {
            $sort_search = $request->search;
            $members->where(function ($query) use ($sort_search) {
                $query->where('code', $sort_search)
                    ->orWhere('first_name', 'like', '%' . $sort_search . '%')
                    ->orWhere('last_name', 'like', '%' . $sort_search . '%');
            });
        }
    
        // Paginate the results
        $members = $members->paginate(10);
    
        // Return the view with the results and search term
        return view('admin.members.index', compact('members', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        if ($request->email == null && $request->phone == null) {
            flash(translate('Email and Phone both can not be null.'))->error();
            return back();
        }

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if (User::where('email', $request->email)->first() != null) {
                flash(translate('Email or Phone already exists.'))->error();
                return back();
            }
        } elseif (User::where('phone', '+' . $request->country_code . $request->phone)->first() != null) {
            flash(translate('Phone already exists.'))->error();
            return back();
        }
        // Upload Member pic
        if(!empty($request->photo)){
            $photo = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('uploads/all'), $photo);
            $photo_name = 'uploads/all/'.$photo;
            
        }else{
            $photo_name = $request->input('old_photo');
        }
        $user               = new user;
        $user->user_type    = 'member';
        $user->code         = unique_code();
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->password     = Hash::make($request->password);
        $user->photo        = $photo_name;
        $user->email        = $request->email;
        if ($request->phone != null) {
            $user->phone        = '+' . $request->country_code . $request->phone;
        }
        if ($request->member_verification == 1) {
            $user->email_verified_at     = date('Y-m-d h:m:s');
        }
        if ($user->save()) {
            $member                             = new Member;
            $member->user_id                    = $user->id;
            $member->gender                     = $request->gender;
            $member->on_behalves_id             = $request->on_behalf;
            $member->birthday                   = date('Y-m-d', strtotime($request->date_of_birth));

            $package                                = Package::where('id', $request->package)->first();
            $member->current_package_id             = $package->id;
            $member->remaining_interest             = $package->express_interest;
            $member->remaining_photo_gallery        = $package->photo_gallery;
            $member->remaining_contact_view         = $package->contact;
            $member->remaining_profile_image_view    = $package->profile_image_view;
            $member->remaining_gallery_image_view   = $package->gallery_image_view;
            $member->auto_profile_match             = $package->auto_profile_match;
            $member->package_validity               = Date('Y-m-d', strtotime($package->validity . " days"));
            $membership                             = $package->id == 1 ? 1 : 2;
            $member->save();

            $user_update                = User::findOrFail($user->id);
            $user_update->membership    = $membership;
            $user_update->save();

            // Account opening email to member
            if ($user->email != null  && env('MAIL_USERNAME') != null && (get_email_template('account_oppening_email', 'status') == 1)) {
                EmailUtility::account_oppening_email($user->id, $request->password);
            }

            // Account Opening SMS to member
            if ($user->phone != null && addon_activation('otp_system') && (get_sms_template('account_opening_by_admin', 'status') == 1)) {
                SmsUtility::account_opening_by_admin($user, $request->password);
            }

            flash('New member has been added successfully')->success();
            return redirect()->route('members.index', $membership);
        }

        flash('Sorry! Something went wrong.')->error();
        return back();
    }

    public function verification_form ()
    {   
        $user = auth()->user();
        if ($user->verification_info == null) {
            return view('frontend.member.member_verifiction_form', compact('user'));
        } else {
            flash(translate('Sorry! You have sent verification request already.'))->error();
            return back();
        }
    }

    public function verification_info_store(Request $request) {
        $data = array();
        $i = 0;
        foreach (json_decode(Setting::where('type', 'verification_form')->first()->value) as $key => $element) {
            $item = array();
            if ($element->type == 'text') {
                $item['type'] = 'text';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i];
            } elseif ($element->type == 'select' || $element->type == 'radio') {
                $item['type'] = 'select';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i];
            } elseif ($element->type == 'multi_select') {
                $item['type'] = 'multi_select';
                $item['label'] = $element->label;
                $item['value'] = json_encode($request['element_' . $i]);
            } elseif ($element->type == 'file') {
                $item['type'] = 'file';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i]->store('uploads/verification_form');
            }
            array_push($data, $item);
            $i++;
        }
        $user = auth()->user();
        $user->verification_info = json_encode($data);
        if ($user->save()) {
            flash(translate('Your verification request has been submitted successfully!'))->success();
            return redirect()->route('dashboard');
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // echo Auth::user()->id; die;
        $user_id = decrypt($id);
        // echo $user_id; die;
       $shortlists = User::with(['physical_attributes', 'member', 'spiritual_backgrounds', 'addresses'])
            ->join('shortlists', 'shortlists.user_id', '=', 'users.id')
            ->where('users.user_type', 'member')
            ->where('shortlists.shortlisted_by', $user_id)
            ->whereNotIn('users.id', function ($query) use ($user_id) {
                $query->select('user_id')
                    ->from('ignored_users')
                    ->where('ignored_by', $user_id)
                    ->orWhere('user_id', $user_id);
            })
            ->whereNotIn('users.id', function ($query) use ($user_id) {
                $query->select('ignored_by')
                    ->from('ignored_users')
                    ->where('ignored_by', $user_id)
                    ->orWhere('user_id', $user_id);
            })
            ->select('users.*')

            ->paginate(10);
            // dd($shortlists);
        $member = User::findOrFail(decrypt($id));
        return view('admin.members.view', compact('member','shortlists'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member             = User::findOrFail(decrypt($id));
        $countries          = Country::where('status', 1)->get();
        $states             = State::all();
        $cities             = City::all();
        $religions          = Religion::all();
        $castes             = Caste::all();
        $sub_castes         = SubCaste::all();
        $family_values      = FamilyValue::all();
        $marital_statuses   = MaritalStatus::all();
        $on_behalves        = OnBehalf::all();
        $languages          = MemberLanguage::all();

        return view('admin.members.edit.index', compact('member', 'countries', 'states', 'cities', 'religions', 'castes', 'sub_castes', 'family_values', 'marital_statuses', 'on_behalves', 'languages'));
    }


    public function introduction_edit(Request $request)
    {
        $member = User::findOrFail($request->id);
        return view('admin.members.edit_profile_attributes.introduction', compact('member'));
    }

    public function introduction_update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->introduction = $request->introduction;
        if ($member->save()) {
            flash('Member introduction info has been updated successfully')->success();
            return back();
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }
    
    public function heighest_eduction_update(Request $request, $id)
    {
        $member = Member::where('user_id', $id)->first();
        $member->heighest_education = $request->heighest_education;
        $member->education_details = $request->education_details;
        if ($member->save()) {
            
            flash('Member education info has been updated successfully')->success();
            return back();
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }
    
    public function emplyeed_profession_update(Request $request, $id)
    {
        $member = Member::where('user_id', $id)->first();
        $member->employed_in = $request->employed_in;
        $member->profession = $request->profession;
        if ($member->save()) {
            
            flash('Member career info has been updated successfully')->success();
            return back();
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }

    public function basic_info_update(Request $request, $id)
    {
        
        $this->rules = [
            'first_name'    => ['required', 'max:255'],
            'last_name'     => ['required', 'max:255'],
            'gender'        => ['required'],
            'date_of_birth' => ['required'],
            'on_behalf'     => ['required'],
            'marital_status' => ['required'],
        ];
        $this->messages = [
            'first_name.required'             => translate('First Name is required'),
            'first_name.max'                  => translate('Max 255 characters'),
            'last_name.required'              => translate('First Name is required'),
            'last_name.max'                   => translate('Max 255 characters'),
            'gender.required'                 => translate('Gender is required'),
            'date_of_birth.required'          => translate('Date Of Birth is required'),
            'on_behalf.required'              => translate('On Behalf is required'),
            'marital_status.required'         => translate('Marital Status is required'),


        ];
        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);
        if(!empty($request->photo)){
            $photo = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('uploads/all'), $photo);
            $photo_name = 'uploads/all/'.$photo;
            
        }else{
            $photo_name = $request->input('old_photo');
        }
        
    // dd($request->all());
        if ($validator->fails()) {
            flash(translate('Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }
        if ($request->email == null && $request->phone == null) {
            flash(translate('Email and Phone number both can not be null. '))->error();
            return back();
        }

        $user               = User::findOrFail($request->id);
        $user->member_id   = $request->member_id;
        $user->blue_tick    = $request->blue_tick;
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        // if (get_setting('profile_picture_approval_by_admin') && $photo_name != $user->photo && auth()->user()->user_type == 'member') {
        if ($photo_name != $user->photo && auth()->user()->user_type == 'member') {
            $user->photo_approved = 0;
        }
        $user->photo        = $photo_name;
        $user->phone        = $request->phone;
        $user->whatsapp_number = $request->whatsapp_number;
        $user->other_number = $request->other_number;
        $user->save();
        $member                     = Member::where('user_id', $request->id)->first();
        $member->gender             = $request->gender;
        $member->on_behalves_id     = $request->on_behalf;
        $member->birthday           = date('Y-m-d', strtotime($request->date_of_birth));
        $member->marital_status_id  = $request->marital_status;
        $member->children           = $request->children;
        $member->special_case           = $request->special_case;
        $member->manglik_status           = $request->manglik_status;

        if ($member->save()) {
            flash('Member basic info  has been updated successfully')->success();
            return back();
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }

    public function language_info_update(Request $request, $id)
    {
        $member                     = Member::where('user_id', $request->id)->first();
        $member->mothere_tongue     = $request->mothere_tongue;
        $member->known_languages    = $request->known_languages;

        if ($member->save()) {
            flash('Member language info has been updated successfully')->success();
            return back();
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }

    public function show_verification_info ($id)
    {
        $user = User::findOrFail(decrypt($id));
        return view('admin.members.verification_info', compact('user'));
    }

    public function approve_verification($id)
    {
        $user             = User::findOrFail($id);
        $user->approved   = 1;
        if ($user->save()) {

            $status = 'Approved';
            
            // Member verification email send to members
            if ($user->email != null && get_email_template('member_verification_email', 'status')) {
                EmailUtility::member_verification_email($user, $status);
            }

            flash('Member Verified Successfully')->success();
            return redirect()->route('members.index', $user->membership);
        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }
    
    public function reject_verification($id)
    {
        $user             = User::findOrFail($id);
        $user->verification_info   = null;
        if ($user->save()) {
            $status = 'Rejected';
            
            // Member verification email send to members
            if ($user->email != null && get_email_template('member_verification_email', 'status')) {
                EmailUtility::member_verification_email($user, $status);
            }

            flash('Member Verification Rejected.')->success();
            return redirect()->route('members.index', $user->membership);

        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }

    public function deleted_members(Request $request)
    {
        $sort_search        = null;
        $deleted_members    = User::onlyTrashed();
       
        if ($request->has('search')) {
            $sort_search  = $request->search;
            $deleted_members  = $deleted_members->where(function ($query) use ($sort_search){
                $query->where('code', $sort_search)
                    ->orwhere('first_name', 'like', '%' . $sort_search . '%')->orWhere('last_name', 'like', '%' . $sort_search . '%');
            });
        }
        $deleted_members = $deleted_members->paginate(10);
        return view('admin.members.deleted_members', compact('deleted_members', 'sort_search'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $user = User::findOrFail($id);

        $user->member()->delete();
        $user->addresses()->delete();
        $user->education()->delete();
        $user->career()->delete();
        $user->physical_attributes()->delete();
        $user->hobbies()->delete();
        $user->attitude()->delete();
        $user->recidency()->delete();
        $user->lifestyles()->delete();
        $user->astrologies()->delete();
        $user->families()->delete();
        $user->partner_expectations()->delete();
        $user->spiritual_backgrounds()->delete();
        $user->happy_story()->delete();
        $user->uploads()->delete();
        
        $chatThreads = ChatThread::where('sender_user_id', $user->id)->orWhere('receiver_user_id', $user->id)->get();
        foreach($chatThreads as $chatThread){
            $chatThread->chats()->delete(); 
        }
        foreach($chatThreads as $chatThread){
            $chatThread->delete(); 
        }

        if (User::destroy($id)) {
            flash('Member has been added to the deleted member list')->success();
        } else {
            flash('Sorry! Something went wrong.')->error();
        }
        return back();
    }

    public function restore_deleted_member($id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        $user->member()->withTrashed()->restore();
        $user->addresses()->withTrashed()->restore();
        $user->education()->withTrashed()->restore();
        $user->career()->withTrashed()->restore();
        $user->physical_attributes()->withTrashed()->restore();
        $user->hobbies()->withTrashed()->restore();
        $user->attitude()->withTrashed()->restore();
        $user->recidency()->withTrashed()->restore();
        $user->lifestyles()->withTrashed()->restore();
        $user->astrologies()->withTrashed()->restore();
        $user->families()->withTrashed()->restore();
        $user->partner_expectations()->withTrashed()->restore();
        $user->spiritual_backgrounds()->withTrashed()->restore();
        $user->happy_story()->withTrashed()->restore();
        $user->uploads()->withTrashed()->restore();
        
        $chatThreads = ChatThread::withTrashed()->where('sender_user_id', $user->id)->orWhere('receiver_user_id', $user->id)->get();
        foreach($chatThreads as $chatThread){
            $chatThread->chats()->withTrashed()->restore(); 
        }
        foreach($chatThreads as $chatThread){
            $chatThread->restore(); 
        }

        if (User::withTrashed()->where('id', $id)->restore()) {
            flash('Member has been restored successfully')->success();
        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
        return back();
    }
    public function member_permanemtly_delete($id)
    {
        $user = User::withTrashed()->where('id', $id)->first();

        $uploads = $user->uploads;
        if ($uploads) {
            foreach ($uploads as $upload) {
                if (file_exists(public_path() . '/' . $upload->file_name)) {
                    unlink(public_path() . '/' . $upload->file_name);
                    $upload->withTrashed()->forcedelete();
                }
            }
        }

        $user->addresses()->withTrashed()->forcedelete();
        $user->education()->withTrashed()->forcedelete();
        $user->career()->withTrashed()->forcedelete();
        $user->physical_attributes()->withTrashed()->forcedelete();
        $user->hobbies()->withTrashed()->forcedelete();
        $user->attitude()->withTrashed()->forcedelete();
        $user->recidency()->withTrashed()->forcedelete();
        $user->lifestyles()->withTrashed()->forcedelete();
        $user->astrologies()->withTrashed()->forcedelete();
        $user->families()->withTrashed()->forcedelete();
        $user->partner_expectations()->withTrashed()->forcedelete();
        $user->spiritual_backgrounds()->withTrashed()->forcedelete();
        $user->happy_story()->withTrashed()->forcedelete();
        $user->uploads()->withTrashed()->forcedelete();

        $user->gallery_images()->delete();
        Shortlist::where('user_id', $user->id)->orWhere('shortlisted_by',$user->id)->delete();
        IgnoredUser::where('user_id', $user->id)->orWhere('ignored_by',$user->id)->delete();
        ReportedUser::where('user_id', $user->id)->orWhere('reported_by',$user->id)->delete();
        ExpressInterest::where('user_id', $user->id)->orWhere('interested_by',$user->id)->delete();
        ProfileMatch::where('user_id', $user->id)->orWhere('match_id',$user->id)->delete();
        
        $chatThreads = ChatThread::withTrashed()->where('sender_user_id', $user->id)->orWhere('receiver_user_id', $user->id)->get();
        foreach($chatThreads as $chatThread){
            $chatThread->chats()->withTrashed()->forcedelete(); 
        }

        foreach($chatThreads as $chatThread){
            $chatThread->forcedelete(); 
        }
        
        $user->member()->withTrashed()->forcedelete();
        $user->forcedelete();

        flash(translate('Member permanently deleted successfully'))->success();
        return back();
    }

    public function package_info(Request $request)
    {
        $member = Member::where('user_id', $request->id)->first();
        return view('admin.members.package_modal', compact('member'));
    }

    public function get_package(Request $request)
    {
        $member_id = $request->id;
        $packages  = Package::where('active', 1)->get();
        return view('admin.members.get_package', compact('member_id', 'packages'));
    }

    public function package_do_update(Request $request, $id)
    {

        $member                                 = Member::where('id', $id)->first();
        $package                                = Package::where('id', $request->package_id)->first();
        $member->current_package_id             = $package->id;
        $member->remaining_interest             = $member->remaining_interest + $package->express_interest;
        $member->remaining_photo_gallery        = $member->remaining_photo_gallery + $package->photo_gallery;
        $member->remaining_contact_view         = $member->remaining_contact_view + $package->contact;
        $member->remaining_profile_image_view   = $member->remaining_profile_image_view + $package->profile_image_view;
        $member->remaining_gallery_image_view   = $member->remaining_gallery_image_view + $package->gallery_image_view;

        $member->auto_profile_match         = $package->auto_profile_match;
        $member->package_validity           = date('Y-m-d', strtotime($member->package_validity . ' +' . $package->validity . 'days'));
        $membership_no = $package->id;
        if($package->id == 1){
            $membership_no = 1;
        }elseif($package->id == 8){
            $membership_no = 2;
        }elseif($package->id == 11){
            $membership_no = 3;
        }elseif($package->id == 12){
            $membership_no = 4;
        }else{
            $membership_no = 1;
        }
        $membership                         = $membership_no;

        if ($member->save()) {
            $user                = User::where('id', $member->user_id)->first();
            $user->membership    = $membership;
            if ($user->save()) {
                flash(translate('Member package has been updated successfully'))->success();
                return redirect()->route('members.index', $membership);
            }
        }
        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function member_wallet_balance_update(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        $wallet                   = new Wallet;
        $wallet->user_id          = $user->id;
        $wallet->amount           = $request->wallet_amount;
        $wallet->payment_method   = $request->payment_option;
        $wallet->payment_details  = '';
        $wallet->save();

        if ($request->payment_option == 'added_by_admin') {
            $user->balance = $user->balance + $request->wallet_amount;
        } elseif ($request->payment_option == 'deducted_by_admin') {
            $user->balance = $user->balance - $request->wallet_amount;
        }

        if ($user->save()) {
            flash(translate('Wallet Balance Updated Successfully'))->success();
            return back();
        } else {
            flash(translate('Something Went Wrong!'))->error();
            return back();
        }
    }

    public function block(Request $request)
    {
        $user           = User::findOrFail($request->member_id);
        $user->blocked  = $request->block_status;
        if ($user->save()) {
            $member                 = Member::where('user_id', $user->id)->first();
            $member->blocked_reason = !empty($request->blocking_reason) ? $request->blocking_reason : "";
            if ($member->save()) {

                flash($user->blocked == 1 ? translate('Member Blocked !') : translate('Member Unblocked !'))->success();
                return back();
            }
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }

    public function blocking_reason(Request $request)
    {
        $blocked_reason = Member::where('user_id', $request->id)->first()->blocked_reason;
        return $blocked_reason;
    }

    // Login by admin as a Member
    public function login($id)
    {
        $user = User::findOrFail(decrypt($id));
        auth()->login($user, true);

        return redirect()->route('dashboard');
    }

    // Member Profile settings Frontend
    public function profile_settings()
    {
        $highest_education  = HighestEducation::get();
        $employed_in        = EmployedInModel::get();
        $profession         = ProfessionModel::get();
        // dd($highest_education);
        $member             = User::findOrFail(Auth::user()->id);
        $countries          = Country::where('status', 1)->get();
        $religions          = Religion::all();
        $castes             = Caste::all();
        $family_values      = FamilyValue::all();
        $marital_statuses   = MaritalStatus::all();
        $on_behalves        = OnBehalf::all();
        $languages          = MemberLanguage::all();
        // dd('hello'); 

        return view('frontend.member.profile.index', compact('member','highest_education','employed_in','profession', 'countries', 'religions', 'castes', 'family_values', 'marital_statuses', 'on_behalves', 'languages'));
    }

    public function unapproved_profile_pictures()
    {
        $users = User::where('user_type', 'member')->where('photo_approved', 0)->latest()->paginate(10);
        return view('admin.members.unapproved_member_profile_pictures', compact('users'));
    }

    public function approve_profile_image(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->photo_approved = 1;
        if ($user->save()) {
            flash(translate('Profile Picture Approved Successfully'))->success();
            return 1;
        }
        return 0;
    }

    // Change Password
    public function change_password()
    {
        return view('frontend.member.password_change');
    }

    public function password_update(Request $request, $id)
    {
        $rules = [
            'old_password'      => ['required'],
            'password'          => ['min:8', 'required_with:confirm_password', 'same:confirm_password'],
            'confirm_password'  => ['min:8'],
        ];

        $messages = [
            'old_password.required'     => translate('Old Password is required'),
            'password.required_with'    => translate('Password and Confirm password are required'),
            'password.same'             => translate('Password and Confirmed password did not matched'),
            'confirm_password.min'      => translate('Max 8 characters'),
        ];

        $validator  = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $user = User::findOrFail($id);

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            flash(translate('Passwoed Updated successfully.'))->success();
            return redirect()->route('member.change_password');
        } else {
            flash(translate('Old password do not matched.'))->error();
            return back();
        }
    }

    public function update_account_deactivation_status(Request $request)
    {
        $user = Auth::user();
        $user->deactivated = $request->deacticvation_status;
        $deacticvation_msg = $request->deacticvation_status == 1 ? translate('deactivated') : translate('reactivated');
        if ($user->save()) {
            flash(translate('Your account ') . $deacticvation_msg . translate(' successfully!'))->success();
            return redirect()->route('dashboard');
        }
        flash(translate('Something Went Wrong!'))->error();
        return back();
    }
    public function account_delete(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $user->member ?  $user->member->delete() : '';
            Address::where('user_id', $user->id)->delete();
            Education::where('user_id', $user->id)->delete();
            Career::where('user_id', $user->id)->delete();
            PhysicalAttribute::where('user_id', $user->id)->delete();
            Hobby::where('user_id', $user->id)->delete();
            Attitude::where('user_id', $user->id)->delete();
            Recidency::where('user_id', $user->id)->delete();
            Lifestyle::where('user_id', $user->id)->delete();
            Astrology::where('user_id', $user->id)->delete();
            Family::where('user_id', $user->id)->delete();
            PartnerExpectation::where('user_id', $user->id)->delete();
            SpiritualBackground::where('user_id', $user->id)->delete();
            PackagePayment::where('user_id', $user->id)->delete();
            HappyStory::where('user_id', $user->id)->delete();
            Staff::where('user_id', $user->id)->delete();
            ChatThread::where('sender_user_id', auth()->user()->id)->orWhere('receiver_user_id', auth()->user()->id)->delete();
            Upload::where('user_id', $user->id)->delete();
            User::destroy(auth()->user()->id);
            flash(translate('Your account has deleted successfully!'))->success();
            auth()->guard()->logout();
        }
        flash(translate('Something Went Wrong!'))->error();
        return back();
    }
    
    public function total_members(Request $request)
    {
        $sort_search = null;
    
        // Start building the query
        $members = User::select(
            'users.id', // Selecting necessary columns
            'users.*',
            'marital_statuses.name as marital_status',
            // 'addresses.id as address_id',
            // 'states.name as state_name',
            // 'cities.name as city_name',
            'members.birthday',
            'on_behalves.name as on_behalves_name',
            'physical_attributes.height as member_height',
            'tbl_highest_education.title as h_education',
            'tbl_profession.title as member_profession'
        )
        ->leftJoin('members', 'members.user_id', '=', 'users.id')
        ->leftJoin('on_behalves', 'on_behalves.id', '=', 'members.on_behalves_id')
        ->leftJoin('physical_attributes', 'physical_attributes.user_id', '=', 'users.id')
        ->leftJoin('tbl_highest_education', 'tbl_highest_education.id', '=', 'members.heighest_education')
        ->leftJoin('tbl_profession', 'tbl_profession.id', '=', 'members.profession')
        ->leftJoin('marital_statuses', 'marital_statuses.id', '=', 'members.marital_status_id')
        // ->leftJoin('addresses', 'addresses.user_id', '=', 'users.id')
        // ->leftJoin('states', 'states.id', '=', 'addresses.state_id')
        // ->leftJoin('cities', 'cities.id', '=', 'addresses.city_id')
        ->where('users.user_type', 'member')
        ->where('users.blocked', 0)
        ->where(function ($query) {
            $query->where('users.deactivated', 0);
        });
    
        // Apply search filter
        if ($request->has('search')) {
            $sort_search = $request->search;
            $members->where(function ($query) use ($sort_search) {
                $query->where('users.code', $sort_search)
                      ->orWhere('users.first_name', 'like', '%' . $sort_search . '%')
                      ->orWhere('users.last_name', 'like', '%' . $sort_search . '%');
            });
        }
    
        // Apply ordering and pagination
        $members = $members->orderBy('users.id', 'desc')->distinct()->paginate(10);
        
        // Return the view with members and search term
        return view('admin.members.total-members', compact('members', 'sort_search'));
    }


    public function verified_members(Request $request){
        $sort_search  = null;
        $members      = User::latest()->where(['user_type'=> 'member','blocked'=>0,'membership'=>2])->orWhere('deactivated',0);
        // dd($members);
        if ($request->has('search')) {
            $sort_search  = $request->search;
            $members  = $members->where('code', $sort_search)->orwhere('first_name', 'like', '%' . $sort_search . '%')->orWhere('last_name', 'like', '%' . $sort_search . '%');
        }

        $members = $members->paginate(10);
        return view('admin.members.verified-members', compact('members', 'sort_search'));
    }
    public function vip_members(Request $request){
        $sort_search  = null;
        $members      = User::latest()->where(['user_type'=> 'member','blocked'=>0,'membership'=>2])->orWhere('deactivated',0);
        // dd($members);
        if ($request->has('search')) {
            $sort_search  = $request->search;
            $members  = $members->where('code', $sort_search)->orwhere('first_name', 'like', '%' . $sort_search . '%')->orWhere('last_name', 'like', '%' . $sort_search . '%');
        }

        $members = $members->paginate(10);
        return view('admin.members.vip-members', compact('members', 'sort_search'));
    }
    public function blocked_members(Request $request){
        $sort_search  = null;
        $members      = User::select('users.*','members.blocked_reason')->latest()->where('users.user_type', 'member')->where('users.blocked', 1)->orWhere('users.deactivated',1);
        $members = $members->leftjoin('members','members.user_id','=','users.id');
        // dd($members);
        if ($request->has('search')) {
            $sort_search  = $request->search;
            $members  = $members->where('users.code', $sort_search)->orwhere('users.first_name', 'like', '%' . $sort_search . '%')->orWhere('users.last_name', 'like', '%' . $sort_search . '%');
        }

        $members = $members->paginate(10);
        return view('admin.members.blocked-members', compact('members', 'sort_search'));
    }
    public function get_professions(Request $request)
    {
        $validator  = Validator::make($request->all(),['employedin_id'=>'required']);
        $data = ProfessionModel::select('empin_id','id','title')->where('empin_id',$request->employedin_id)->get();
        if($data->isNotEmpty()){
            return response()->json($data);
        }else{
            return response()->json(NULL);
        }
    }
}
