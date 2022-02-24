<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Cache;
use Auth;
use DB;
use Edujugon\PushNotification\PushNotification;

class Notification extends Controller
{
    public function sendnotif(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $product = $this->validate(request(), [
                'message_title' => 'required',
                'member_email' => 'required|email',
                'message_body' => 'required',
            ]);
            $member = DB::table('notification_ids')->where('email', $req->get('member_email'))->first();
            if (!$member) {
                return back()->with('error', 'No member found! Go to USER MANAGEMENT to verify if anyone registered with this email.');
            }
            $push = new PushNotification('fcm');
            $response = $push->setMessage([
                                'notification' => [
                                    'title'=>$req->get('message_title'),
                                    'body'=>$req->get('message_body'),
                                    'sound' => 'default'
                                    ]
                            ])
                            //->setConfig(['dry_run' => true])
                            ->setApiKey(env('GCM_KEY'))
                            ->setDevicesToken($member->device_token)
                            ->send()
                            ->getFeedback();
            if ($response->success == "1") {
                return back()->with('success', 'Notification sent successfully');
            } else {
                return back()->with('error', $response->results[0]->error);
            }
        } else {
            return back()->with('error', 'Access denied!');
        }
    }
}
