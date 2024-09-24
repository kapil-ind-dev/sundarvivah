<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\PhysicalAttribute;
use App\Models\HighestEducation;
use App\Models\SpiritualBackground;
use App\Models\ProfessionModel;
use App\Models\EmployedInModel;
use App\Models\Address;
use App\Models\Shortlist;

class ProfileFilterController extends Controller
{
    //
    public function index(Request $request){
        $users = User::select('users.id', 
        'users.code', 
        'users.membership', 
        'users.photo', 
        'users.first_name', 
        'users.last_name',
        'users.live_city',
        'cities.name as city_name',
        'states.name as states_name',
        'countries.name as country_name',
        'addresses.full_address as full_address',
        'addresses.city_id as city_id',
        'member_languages.name as member_language',
        'physical_attributes.mothere_tongue as mothere_tongue',
        'partner_expectations.preferred_country_id',
        'partner_expectations.preferred_state_id',
        'partner_expectations.prefer_city as prefer_city_name',
        'partner_expectations.general as general_requirement',
        'p_state.name as prefer_states_name',
        'p_countries.name as prefer_country_name',
        'members.manglik_status as m_status'
        )
            ->leftjoin('members','members.user_id','=','users.id')
            ->leftjoin('member_languages','member_languages.id','=','members.mothere_tongue')
            ->leftJoin('partner_expectations', 'partner_expectations.user_id', '=', 'users.id')
            ->leftJoin('physical_attributes', 'physical_attributes.user_id', '=', 'users.id')
            ->leftJoin('addresses', 'addresses.user_id', '=', 'users.id')
            ->leftJoin('cities', 'cities.id', '=', 'addresses.city_id')
            ->leftJoin('states', 'states.id', '=', 'addresses.state_id')
            ->leftJoin('countries', 'countries.id', '=', 'addresses.country_id')
            ->leftJoin('states as p_state', 'p_state.id', '=', 'partner_expectations.preferred_state_id')
            ->leftJoin('countries as p_countries', 'p_countries.id', '=', 'partner_expectations.preferred_country_id')
            ->orderBy('users.created_at', 'desc')
            ->where('users.user_type', 'member')
            ->where('users.blocked', 0)
            ->where('users.deactivated', 0);
            // dd($users);
        $user_details = array();
        $highest_education = HighestEducation::select('id','title')->get();
        $employedin_data = EmployedInModel::select('id','title')->orderBy('title')->get();
        
        $members = User::where(['user_type'=>'member','blocked'=>0])->select('id','code','first_name','last_name')->get();
        // dd($members);
        $user_id = ($request->member_id != null) ? $request->member_id : null;
        // dd($user_id);
        $user = User::select('users.*','members.gender')->leftJoin('members', 'members.user_id', '=', 'users.id')->where('users.id',$user_id)->first();
        // dd($user);
        $age_from       = ($request->age_from != null) ? $request->age_from : null;
        $age_to         = ($request->age_to != null) ? $request->age_to : null;
        $member_code    = ($request->member_code != null) ? $request->member_code : null;
        $matital_status = ($request->marital_status != null) ? $request->marital_status : null;
        $religion_id    = ($request->religion_id != null) ? $request->religion_id : null;
        $caste_id       = ($request->caste_id != null) ? $request->caste_id : null;
        $sub_caste_id   = ($request->sub_caste_id != null) ? $request->sub_caste_id : null;
        $mother_tongue  = ($request->mother_tongue != null) ? $request->mother_tongue : null;
        $profession     = ($request->profession != null) ? $request->profession : null;
        $country_id     = ($request->country_id != null) ? $request->country_id : null;
        $state_id       = ($request->state_id != null) ? $request->state_id : null;
        $city_id        = ($request->city_id != null) ? $request->city_id : null;
        $member_type    = ($request->member_type != null) ? $request->member_type : 0;
        $employedin_id    = ($request->employedin_id != null) ? $request->employedin_id : 0;
        $profession_id    = ($request->profession_id != null) ? $request->profession_id : 0;
        $manglik_status  = ($request->manglik_status != null) ? $request->manglik_status : null;
        $highest_edu  = ($request->highest_edu != null) ? $request->highest_edu : null;
        
        // dd($member_type);

        
        if(!is_null($user)){
            $user_details = $user;
            $users = User::select('users.id', 
            'users.code', 
            'users.membership', 
            'users.photo', 
            'users.first_name', 
            'users.last_name',
            'users.live_city',
            'cities.name as city_name',
            'states.name as states_name',
            'countries.name as country_name',
            'member_languages.name as member_language',
            'physical_attributes.mothere_tongue as mothere_tongue',
            'partner_expectations.general as general_requirement',
            'partner_expectations.prefer_city as prefer_city_name',
            'p_state.name as prefer_states_name',
            'p_countries.name as prefer_country_name',
            'members.manglik_status as m_status'
            )
            ->leftjoin('members','members.user_id','=','users.id')
            ->leftjoin('member_languages','member_languages.id','=','members.mothere_tongue')
            ->leftJoin('partner_expectations', 'partner_expectations.user_id', '=', 'users.id')
            ->leftJoin('physical_attributes', 'physical_attributes.user_id', '=', 'users.id')
            ->leftJoin('addresses', 'addresses.user_id', '=', 'users.id')
            ->leftJoin('cities', 'cities.id', '=', 'addresses.city_id')
            ->leftJoin('states', 'states.id', '=', 'addresses.state_id')
            ->leftJoin('countries', 'countries.id', '=', 'addresses.country_id')
            ->leftJoin('states as p_state', 'p_state.id', '=', 'partner_expectations.preferred_state_id')
            ->leftJoin('countries as p_countries', 'p_countries.id', '=', 'partner_expectations.preferred_country_id')
            ->orderBy('users.created_at', 'desc')
            ->where('users.user_type', 'member')
            ->where('users.id', '!=', $user_id)
            ->where('users.blocked', 0)
            ->where('users.deactivated', 0);
            // Gender Check
            
        // dd($user->gender);
            $user_ids = Member::where('gender', '!=', $user->gender)->pluck('user_id')->toArray();
            // dd($user_ids);
            $users = $users->WhereIn('users.id', $user_ids);
            // dd($users->get());
            // Ignored member and ignored by member check
           
            $users = $users->whereNotIn("users.id", function ($query) use ($user_id) {
                $query->select('user_id')
                    ->from('ignored_users')
                    ->where(function ($query) use ($user_id) {
                        $query->where('ignored_by', $user_id)
                              ->orWhere('user_id', $user_id);
                    });
            })->whereNotIn("users.id", function ($query) use ($user_id) {
                $query->select('ignored_by')
                    ->from('ignored_users')
                    ->where(function ($query) use ($user_id) {
                        $query->where('ignored_by', $user_id)
                              ->orWhere('user_id', $user_id);
                    });
            });

        }
        // Membership Check
        if ($member_type == 1 || $member_type == 2 || $member_type == 3 || $member_type == 4) {
            $users = $users->where('users.membership', $member_type);
        }

        // Member verification Check
        if (get_setting('member_verification') == 1) {
            $users = $users->where('users.approved', 1);
        }

        // Sort By age
        if (!empty($age_from)) {
            $age = $age_from + 1;
            $start = date('Y-m-d', strtotime("- $age years"));
            $user_ids = Member::where('birthday', '<=', $start)->pluck('user_id')->toArray();
            if (count($user_ids) > 0) {
                $users = $users->WhereIn('users.id', $user_ids);
            }
        }
        if (!empty($age_to)) {
            $age = $age_to + 1;
            $end = date('Y-m-d', strtotime("- $age years +1 day"));
            $user_ids = Member::where('birthday', '>=', $end)->pluck('user_id')->toArray();
            if (count($user_ids) > 0) {
                $users = $users->WhereIn('users.id', $user_ids);
            }
        }

        // Search by Member Code
        if (!empty($member_code)) {
            $users = $users->where('users.code', $member_code);
        }

        // Sort by Matital Status
        if ($matital_status != null) {
            $user_ids = Member::where('marital_status_id', $matital_status)->pluck('user_id')->toArray();
            if (count($user_ids) > 0) {
                $users = $users->WhereIn('users.id', $user_ids);
            }
        }

        // Sort By religion
        if (!empty($sub_caste_id)) {
            $user_ids = SpiritualBackground::where('sub_caste_id', $sub_caste_id)->pluck('user_id')->toArray();
            $users = $users->WhereIn('users.id', $user_ids);
        } elseif (!empty($caste_id)) {
            $user_ids = SpiritualBackground::where('caste_id', $caste_id)->pluck('user_id')->toArray();
            $users = $users->WhereIn('users.id', $user_ids);
        } elseif (!empty($religion_id)) {
            
            $rel_ids = SpiritualBackground::where('religion_id', $religion_id)->pluck('user_id')->toArray();
            //  dd($rel_ids);
            $users = $users->WhereIn('users.id', $rel_ids);
        }
        // Profession
        elseif (!empty($profession)) {
            $user_ids = Career::where('designation', 'like', '%' . $profession . '%')->pluck('user_id')->toArray();
            $users = $users->WhereIn('users.id', $user_ids);
        }
        
        // Sort By location
        if (!empty($city_id)) {
            $user_ids = Address::where('city_id', $city_id)->pluck('user_id')->toArray();
            $users = $users->WhereIn('users.id', $user_ids);
        } elseif (!empty($state_id)) {
            $user_ids = Address::where('state_id', $state_id)->pluck('user_id')->toArray();
            $users = $users->WhereIn('users.id', $user_ids);
        } elseif (!empty($country_id)) {
            $user_ids = Address::where('country_id', $country_id)->pluck('user_id')->toArray();
            $users = $users->WhereIn('users.id', $user_ids);
        }

        // Sort By Mother Tongue
        if ($mother_tongue != null) {
            $user_ids = PhysicalAttribute::where('mothere_tongue', $mother_tongue)->pluck('user_id')->toArray();
            // dd($user_ids);
            if (count($user_ids) > 0) {
                $users = $users->WhereIn('users.id', $user_ids);
            }
            // else if($mother_tongue != null){
            //     $users = $users->WhereIn('users.id', $user_ids);
            // }
        }
        if ($manglik_status != null) {
            // echo $manglik_status; die;
            $users = $users->where('members.manglik_status', $manglik_status);
        }
        if ($employedin_id != null) {
            $users = $users->where('members.employed_in', $employedin_id);
        }
        if ($profession_id != null) {
            $users = $users->where('members.profession', $profession_id);
        }
        // dd($highest_edu);
        if ($highest_edu != null) {
            // echo $highest_edu; die;
            $users = $users->where('members.heighest_education', $highest_edu);
        }
        
         $users = $users->paginate(50);
        // dd($users);
        
        return view('admin.members.filter-profile', compact('profession_id', 'employedin_id','highest_education', 'highest_edu', 'user_id','members','user_details','users', 'age_from', 'age_to', 'member_code', 'matital_status', 'religion_id', 'caste_id', 'sub_caste_id', 'mother_tongue', 'profession', 'country_id', 'state_id', 'city_id',  'member_type', 'manglik_status'));
    }
    function get_profession(Request $request){
        $profession = ProfessionModel::where('empin_id', $request->employedin_id)->get();
        return $profession;
        
    }
    function get_member_profile(Request $request)
    {
        $request->validate(['member_id' => 'required']);
        $user = User::select(
                'members.gender',
                'members.employed_in',
                'members.profession as profession_id',
                'members.birthday as dob',
                'users.first_name',
                'users.last_name',
                'marital_statuses.name as marital_status',
                'cities.name as city_name',
                'states.name as states_name',
                'countries.name as country_name',
                'addresses.full_address as full_address',
                'addresses.city_id as city_id',
                'tbl_highest_education.title as highest_education',
                'tbl_employedin.title as employedin',
                'tbl_profession.title as profession',
                'careers.income as income',
                'partner_expectations.preferred_country_id',
                'partner_expectations.preferred_state_id',
                'partner_expectations.prefer_city as prefer_city_name',
                'partner_expectations.general as general_requirement',
                'p_state.name as prefer_states_name',
                'p_countries.name as prefer_country_name',
                'users.id'
            )
            ->leftJoin('members', 'members.user_id', '=', 'users.id')
            ->leftJoin('member_languages', 'member_languages.id', '=', 'members.mothere_tongue')
            ->leftJoin('marital_statuses', 'marital_statuses.id', '=', 'members.marital_status_id')
            ->leftJoin('addresses', 'addresses.user_id', '=', 'users.id')
            ->leftJoin('cities', 'cities.id', '=', 'addresses.city_id')
            ->leftJoin('states', 'states.id', '=', 'addresses.state_id')
            ->leftJoin('countries', 'countries.id', '=', 'addresses.country_id')
            ->leftJoin('tbl_highest_education', 'tbl_highest_education.id', '=', 'members.heighest_education')
            ->leftJoin('tbl_employedin', 'tbl_employedin.id', '=', 'members.employed_in')
            ->leftJoin('tbl_profession', 'tbl_profession.id', '=', 'members.profession')
            ->leftJoin('careers', 'careers.user_id', '=', 'users.id')
            ->leftJoin('partner_expectations', 'partner_expectations.user_id', '=', 'users.id')
            ->leftJoin('states as p_state', 'p_state.id', '=', 'partner_expectations.preferred_state_id')
            ->leftJoin('countries as p_countries', 'p_countries.id', '=', 'partner_expectations.preferred_country_id')
            ->where('users.id', $request->member_id)
            ->where('users.user_type', 'member')
            ->where('users.blocked', 0)
            ->where('users.deactivated', 0)
            ->first();
    
        if ($user) {
            $user->age = $user->dob ? \Carbon\Carbon::parse($user->dob)->age : null;
        }
        return $user;
    }
    public function add_to_shortlist(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'shortlisted_by' => 'required'
        ]);

        // $shortlist = Shortlist::firstOrNew(
        //     ['user_id' => $request->user_id],
        //     ['shortlisted_by' => $request->shortlisted_by]
        // );
        $shortlist = Shortlist::where([
            'user_id' => $request->user_id,
            'shortlisted_by' => $request->shortlisted_by
        ])->exists();
        if ($shortlist == true) {
            return 0;
        }
        $shortlist = new Shortlist();
        $shortlist->user_id        = $request->user_id;
        $shortlist->shortlisted_by = $request->shortlisted_by;
        if ($shortlist->save()) {
            return 1;
        } else {
            return 0;
        }
    }
    public function remove_from_shortlist(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'shortlisted_by' => 'required'
        ]);
        // return $request->all();
        $shortlist = Shortlist::where('user_id', $request->user_id)->where('shortlisted_by', $request->shortlisted_by)->first()->id;
        if (Shortlist::destroy($shortlist)) {
            return 1;
        } else {
            return 0;
        }
    }

}
