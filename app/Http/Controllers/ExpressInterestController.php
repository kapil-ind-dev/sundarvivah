<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChatThread;
use App\Models\ExpressInterest;
use App\Models\User;
use App\Notifications\DbStoreNotification;
use App\Services\FirbaseNotification;
use App\Utility\EmailUtility;
use App\Utility\SmsUtility;
use Auth;
use DB;
use Illuminate\Http\Request;
use Kutia\Larafirebase\Facades\Larafirebase;
use Notification;

class ExpressInterestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interests = User::with(['physical_attributes', 'member', 'spiritual_backgrounds', 'addresses'])
            ->join('express_interests', 'express_interests.user_id', '=', 'users.id')
            ->where('users.user_type', 'member')
            ->where('express_interests.interested_by', Auth::user()->id)
            ->select('users.*','express_interests.id as interest_id','express_interests.status as interest_status')
            ->paginate(10);
        return view('frontend.member.my_interests', compact('interests'));
    }

    public function interest_requests()
    {
        $interests = ExpressInterest::where('user_id', Auth::user()->id)->latest()->paginate(10);
        return view('frontend.member.interest_requests', compact('interests'));
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
        $interested_by_user = Auth::user();
        $interested_by_member = $interested_by_user->member;
        if ($interested_by_member->remaining_interest > 0) {
            // Store express interest data
            $express_interest                 = new ExpressInterest;
            // Check interest does not shown on self
            if ($request->id != $interested_by_user->id) {
                $express_interest->user_id        = $request->id;
                $express_interest->interested_by  = $interested_by_user->id;
                if ($express_interest->save()) {
                    // Deduct interested by user's remaining express interest value
                    $interested_by_member->remaining_interest -= 1;
                    $interested_by_member->save();

                    $notify_user = User::where('id', $request->id)->first();

                    // Express Interest Store Notification for member
                    try {
                        $notify_type = 'express_interest';
                        $id = unique_notify_id();
                        $notify_by = $interested_by_user->id;
                        $info_id = $express_interest->id;
                        $message = $interested_by_user->first_name . ' ' . $interested_by_user->last_name . ' ' . translate(' has Expressed Interest On You.');
                        $route = route('interest_requests');

                        // fcm 
                        if (get_setting('firebase_push_notification') == 1) {
                            $fcmTokens = User::where('id', $request->id)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
                            self::sendFirebaseNotification($fcmTokens, $notify_user, $notify_type, $message, $notify_by);
                        }
                        // end of fcm

                        Notification::send($notify_user, new DbStoreNotification($notify_type, $id, $notify_by, $info_id, $message, $route));
                    } catch (\Exception $e) {
                        // dd($e);
                    }

                    // Express Interest email send to member
                    if ($notify_user->email != null && get_email_template('email_on_express_interest', 'status')) {
                        EmailUtility::email_on_request($notify_user, 'email_on_express_interest');
                    }

                    // Express Interest Send SMS to member
                    if ($notify_user->phone != null && addon_activation('otp_system') && (get_sms_template('express_interest', 'status') == 1)) {
                        SmsUtility::sms_on_request($notify_user, 'express_interest');
                    }

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function accept_interest(Request $request)
    {
        $interest = ExpressInterest::findOrFail($request->interest_id);
        $interest->status = 1;
        if ($interest->save()) {
            // $existing_chat_thread = ChatThread::where('sender_user_id', $interest->interested_by)->where('receiver_user_id', $interest->user_id)->first();

            $existing_chat_thread = ChatThread::where(function ($query) use ($interest) {
                $query->where('sender_user_id', $interest->interested_by)->where('receiver_user_id', $interest->user_id);
            })->orWhere(function ($query) use ($interest) {
                $query->where('receiver_user_id', $interest->interested_by)->where('sender_user_id', $interest->user_id);
            })->first();

            if ($existing_chat_thread == null) {
                $chat_thread                    = new ChatThread;
                $chat_thread->thread_code       = $interest->interested_by . date('Ymd') . $interest->user_id;
                $chat_thread->sender_user_id    = $interest->interested_by;
                $chat_thread->receiver_user_id  = $interest->user_id;
                $chat_thread->save();
            }

            $notify_user = User::where('id', $interest->interested_by)->first();

            // Express Interest Store Notification for member
            try {
                $notify_type = 'accept_interest';
                $id = unique_notify_id();
                $notify_by = Auth::user()->id;
                $info_id = $interest->id;
                $message = Auth::user()->first_name . ' ' . Auth::user()->last_name . ' ' . translate(' has accepted your interest.');
                $route = route('my_interests.index');

                // fcm 
                if (get_setting('firebase_push_notification') == 1) {
                    $fcmTokens = User::where('id', $interest->interested_by)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
                    self::sendFirebaseNotification($fcmTokens, $notify_user, $notify_type, $message, $notify_by);
                }
                // end of fcm

                Notification::send($notify_user, new DbStoreNotification($notify_type, $id, $notify_by, $info_id, $message, $route));
            } catch (\Exception $e) {
                // dd($e);
            }

            // Express Interest email send to member
            if ($notify_user->email != null && get_email_template('email_on_accepting_interest', 'status')) {
                EmailUtility::email_on_accept_request($notify_user, 'email_on_accepting_interest');
            }

            // Express Interest Send SMS to member
            if ($notify_user->phone != null && addon_activation('otp_system') && (get_sms_template('accept_interest', 'status') == 1)) {
                SmsUtility::sms_on_accept_request($notify_user, 'accept_interest');
            }
            flash(translate('Interest has been accepted successfully.'))->success();
            return redirect()->route('interest_requests');
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }

    public function reject_interest(Request $request)
    {
        $interest = ExpressInterest::findOrFail($request->interest_id);

        if (ExpressInterest::destroy($request->interest_id)) {

            $notify_user = User::where('id', $interest->interested_by)->first();
            try {
                $notify_type = 'reject_interest';
                $id = unique_notify_id();
                $notify_by = Auth::user()->id;
                $info_id = $interest->id;
                $message = Auth::user()->first_name . ' ' . Auth::user()->last_name . ' ' . translate(' has rejected your interest.');
                $route = route('my_interests.index');

                // fcm 
                if (get_setting('firebase_push_notification') == 1) {
                    $fcmTokens = User::where('id', $interest->interested_by)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
                    self::sendFirebaseNotification($fcmTokens, $notify_user, $notify_type, $message, $notify_by);
                }
                // end of fcm

                Notification::send($notify_user, new DbStoreNotification($notify_type, $id, $notify_by, $info_id, $message, $route));
            } catch (\Exception $e) {
                // dd($e);
            }

            flash(translate('Interest has been rejected successfully.'))->success();
            return redirect()->route('interest_requests');
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

    public static function sendFirebaseNotification($fcmTokens = null, $notify_user, $notify_type, $message, $notify_by = null)
    {
        // send firebase notification for mobile app
        if ($notify_user->fcm_token != null) {
            $data = (object)[];
            $data->fcm_token = $notify_user->fcm_token;
            $data->title = $notify_type;
            $data->text = $message;
            $data->notify_by = $notify_by;
            FirbaseNotification::send($data);
        }
        // end of  firebase notification

        Larafirebase::withTitle(str_replace("_", " ", $notify_type))
            ->withBody($message)
            ->sendMessage($fcmTokens);
    }
}
