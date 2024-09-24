<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ProfessionModel;
use App\Models\EmployedInModel;
use Redirect;
use Validator;

class ProfessionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_profession'])->only('index');
        $this->middleware(['permission:edit_profession'])->only('edit');
        $this->middleware(['permission:delete_profession'])->only('destroy');

        $this->rules = [
            'empin_id' => ['required','max:255'],
            'title' => ['required','max:255'],
        ];

        $this->messages = [
            'empin_id.required'  => translate('Please select Employed In'),
            'title.required'  => translate('Title is required'),
            'title.max' => translate('Max 255 characters'),
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
        $employed_in = EmployedInModel::get();
        $professionQuery = ProfessionModel::select('tbl_profession.*', 'tbl_employedin.title as employed_title')
            ->leftJoin('tbl_employedin', 'tbl_profession.empin_id', '=', 'tbl_employedin.id') // Adjust foreign key if needed
            ->latest();
        
        if ($request->has('search')) {
            $sort_search = $request->input('search');
            $professionQuery->where('tbl_profession.title', 'like', '%' . $sort_search . '%');
        }
        
        $professions = $professionQuery->paginate(10);
        // dd($professions);

        return view('admin.member_profile_attributes.profession.index', compact('professions', 'employed_in', 'sort_search'));
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
    public function get_profession(Request $request)
    {
        $validator  = Validator::make($request->all(),['employedin_id'=>'required']);
        return 1;
        $data = ProfessionModel::select('empin_id','id','title')->where('empin_id',$request->employedin_id)->get();
        if($data->isNotEmpty()){
            return response()->json($data);
        }else{
            return response()->json(NULL);
        }
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
        $profession = new ProfessionModel();
        $profession->empin_id = $request->empin_id;
        $profession->title = $request->title;
        // dd($profession);
        if($profession->save()){
            flash(translate('Profession has been added successfully'))->success();
            return redirect()->route('profession.index');
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
        $employed_in = EmployedInModel::get();
        $profession = ProfessionModel::findOrFail(decrypt($id));
        return view('admin.member_profile_attributes.profession.edit',compact('profession','employed_in'));
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

        $profession       = ProfessionModel::findOrFail($id);
        $profession->empin_id = $request->empin_id;
        $profession->title = $request->title;
        if($profession->save()){
            flash(translate('Profession has been updated successfully'))->success();
            return redirect()->route('profession.index');
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
        if (ProfessionModel::destroy($id)) {
            flash(translate('Profession has been deleted successfully'))->success();
            return redirect()->route('profession.index');
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }
}
