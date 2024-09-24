<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IgnoredUser;
use App\Models\User;
use Auth;

class IgnoredUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ignored_members = User::with(['physical_attributes', 'member', 'spiritual_backgrounds', 'addresses','ignored_users'])
            ->join('ignored_users', 'ignored_users.user_id', '=', 'users.id')
            ->where('users.user_type', 'member')
            ->where('ignored_users.ignored_by', Auth::user()->id)
            ->select('users.*','ignored_users.user_id as ignored_user_id')
            ->paginate(10);
        
        return view('frontend.member.my_ignored_members', compact('ignored_members'));
    }

    public function add_to_ignore_list(Request $request)
    {
        $ignore             = new IgnoredUser;
        $ignore->user_id    = $request->id;
        $ignore->ignored_by = Auth::user()->id;
        if($ignore->save()){
            return 1;
        }
        else {
            return 0;
        }
    }
    public function remove_from_ignored_list(Request $request)
    {
      // echo 'check'; die();
        $ignored_user = IgnoredUser::where('user_id', $request->id)->where('ignored_by', Auth::user()->id)->first()->id;
        if(IgnoredUser::destroy($ignored_user)){
            return 1;
        }
        else {
            return 0;
        }
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
        //
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
        //
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
        //
    }
}
