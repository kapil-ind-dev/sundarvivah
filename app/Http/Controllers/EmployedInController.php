<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\EmployedInModel;
use Redirect;
use Validator;

class EmployedInController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_employedin'])->only('index');
        $this->middleware(['permission:edit_employedin'])->only('edit');
        $this->middleware(['permission:delete_employedin'])->only('destroy');

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
        $employedinQuery = EmployedInModel::latest();
        if ($request->has('search')) {
            $sort_search = $request->input('search');
            $employedinQuery->where('title', 'like', '%' . $sort_search . '%');
        }
        
        $employedin = $employedinQuery->paginate(10);
        // dd($employedin);

        return view('admin.member_profile_attributes.employedin.index', compact('employedin', 'sort_search'));
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

        $employedin       = new EmployedInModel;
        $employedin->title = $request->title;
        if($employedin->save()){
            flash(translate('New Employed In has been added successfully'))->success();
            return redirect()->route('employed-in.index');
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
        $employedin = EmployedInModel::findOrFail(decrypt($id));
        return view('admin.member_profile_attributes.employedin.edit',compact('employedin'));
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

        $employedin       = EmployedInModel::findOrFail($id);
        $employedin->title = $request->title;
        if($employedin->save()){
            flash(translate('Employed In has been updated successfully'))->success();
            return redirect()->route('employed-in.index');
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
        if (EmployedInModel::destroy($id)) {
            flash(translate('Employed In has been deleted successfully'))->success();
            return redirect()->route('employed-in.index');
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }
}
