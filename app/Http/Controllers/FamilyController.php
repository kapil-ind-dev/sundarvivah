<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;
use Validator;
use Redirect;

class FamilyController extends Controller
{
    public function __construct()
    {
        $this->rules = [
            'family_member'   => [ 'required','max:255'],
            'member_name'     => [ 'required','max:255'],
            'profession_status' => [ 'required','max:255'],
            'member_details'   => [ 'required', 'max:255'],
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $member_id = $request->id;
        return view('frontend.member.profile.family_information.create', compact('member_id'));
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
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash(translate('Something went wrong'))->error();
            return Redirect::back();
        }

        $family                = new Family;
        $family->user_id       = $request->user_id;
        $family->family_member = $request->family_member;
        $family->member_name   = $request->member_name;
        $family->profession_status = $request->profession_status;
        $family->member_details    = $request->member_details;

        if($family->save()){
            flash(translate('Family Info has been added successfully'))->success();
            return back();
        }
        else {
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
    public function edit(Request $request)
    {
        $family = Family::findOrFail($request->id);
        return view('frontend.member.profile.family_information.edit', compact('family'));
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
         $this->rules = [
             'family_member'   => [ 'max:255'],
             'member_name'   => [ 'max:255'],
             'profession_status'  => [ 'max:255'],
             'member_details'  => [ 'max:255'],
         ];
         $this->messages = [
             'family_member.max'   => translate('Max 255 characters'),
             'member_name.max'   => translate('Max 255 characters'),
             'profession_status.max'  => translate('Max 255 characters'),
             'member_details.max'  => translate('Max 255 characters'),
         ];

         $rules = $this->rules;
         $messages = $this->messages;
         $validator = Validator::make($request->all(), $rules, $messages);

         if ($validator->fails()) {
             flash(translate('Something went wrong'))->error();
             return Redirect::back()->withErrors($validator);
         }

        $family              = Family::findOrFail($id);
        $family->family_member = $request->family_member;
        $family->member_name   = $request->member_name;
        $family->profession_status = $request->profession_status;
        $family->member_details    = $request->member_details;

        if($family->save()){
            flash(translate('Family Info has been updated successfully'))->success();
            return back();
        }
        else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
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
        if(Family::destroy($id))
        {
            flash(translate('Family info has been deleted successfully'))->success();
            return back();
        }
        else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }
    
    public function update_family_information_status(Request $request)
    {
        $family = Family::findOrFail($request->id);
        $family->status = $request->status;
        if ($family->save()) {
            $msg = $family->status == 1 ? translate('Enabled') : translate('Disabled');
            flash(translate($msg))->success();
            return 1;
        }
        return 0;
    }
}
