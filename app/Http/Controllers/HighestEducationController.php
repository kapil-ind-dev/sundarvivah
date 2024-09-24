<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\HighestEducation;
use Redirect;
use Validator;

class HighestEducationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_highesteducation'])->only('index');
        $this->middleware(['permission:edit_highesteducation'])->only('edit');
        $this->middleware(['permission:delete_highesteducation'])->only('destroy');

        $this->rules = [
            'title' => ['required','max:255'],
        ];

        $this->messages = [
            'title.required'             => translate('Title is required'),
            'title.max'                  => translate('Max 255 characters'),
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $educationQuery = HighestEducation::latest();
        if ($request->has('search')) {
            $sort_search = $request->input('search');
            $educationQuery->where('title', 'like', '%' . $sort_search . '%');
        }
        
        $educations = $educationQuery->paginate(10);
        // dd($educations);

        return view('admin.member_profile_attributes.education.index', compact('educations', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules      = $this->rules;
        $messages   = $this->messages;
        $validator  = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $educations       = new HighestEducation();
        $educations->title = $request->title;
        // dd($educations);
        if($educations->save()){
            flash(translate('New Highest Education has been added successfully'))->success();
            return redirect()->route('highest-education.index');
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $education = HighestEducation::findOrFail(decrypt($id));
        return view('admin.member_profile_attributes.education.edit',compact('education'));
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
        $rules      = $this->rules;
        $messages   = $this->messages;
        $validator  = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $education       = HighestEducation::findOrFail($id);
        $education->title = $request->title;
        if($education->save()){
            flash(translate('Highest Education has been updated successfully'))->success();
            return redirect()->route('highest-education.index');
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }

    public function religion_bulk_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $id) {
                $this->destroy($id);
            }
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (HighestEducation::destroy($id)) {
            flash(translate('Highest Education has been deleted successfully'))->success();
            return redirect()->route('highest-education.index');
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }
}
