<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Edujugon\PushNotification\PushNotification;

class CpaCallbackController extends Controller
{
    protected function Callback($request)
    {
        $payout = round($request->payout * env('CASHTOPTS') * env('PAY_PCT') / 100);    // remove round if necessary
        if ($request->tok != $request->savedtok) {
            return response('0');
        }
        if (!$payout || $payout == '' || !is_numeric($payout) || $payout < 3) {
            return response('0');
        }
        if (!$request->userid || $request->userid == '' || $request->userid == 'guest') {
            return response('0');
        }
        if ($request->userid == 'visitor') {
            return response('1');
        }
        try {
            $usr = DB::table('users')->where('refid', $request->userid);
            $usr->increment('balance', $payout);
            $usr->increment('available', $payout);
			if(strlen($request->offer_id) > 20){
				$note = '...' . substr ($request->offer_id, -10);
			} else {
				$note = $request->offer_id;
			}
            DB::table('tokens')->insert([
                'userid' => $request->userid,
                'is_adearn' => 1,
                'network'=> $request->network,
                'note'=> $note,
                'ip_address' => $request->ip,
                'amount' => $payout,
                'date' => Carbon::now()->timestamp
            ]);
            $u = $usr->first();
            \AIndex::addToLeaderboard($u->refid, $payout);
            if (env('GCM_KEY') && env('EARNING_NOTIFICATION') == 'yes') {
                $token = DB::table('notification_ids')->where('email', $u->email)->first();
                if ($token) {
                    $push = new PushNotification('fcm');
                    if ($request->network == "fyber") {
                        $notification = [
                            'notification' => [
                                'title'=> 'You Got Tokens!',
                                'body'=> 'Congratulations You Got ' .$payout . ' Tokens on Completing Fyber offer',
                                'sound' => 'default',

                                ]
                            ];
                    } else {
                        $notification = [
                            'notification' => [
                                'title'=> 'You Got Tokens!',
                                'body'=> 'Congratulations You Got ' .$payout . ' Tokens',
                                'sound' => 'default'
                                ]
                            ];
                    }
                    $push->setMessage($notification)
                            ->setApiKey(env('GCM_KEY'))
                            ->setDevicesToken($token->device_token)
                            ->send();
                };
            };
			return response('1');
        } catch (\Exception $e) {
			return response('1');
        }
    }

	public function fyber(Request $req){
		$send =  new \stdClass();
		$send->tok = $req->query('tok');
		$send->savedtok = \AIndex::getmisc('fyber_secret');
		$send->payout = $req->query('amount');
		$send->userid = $req->query('uid');
		$send->offer_id = 'blank';
		$send->ip = 'blank';
		$send->network = 'fyber';
		return $this->Callback($send);
	}

	public function pollfish(Request $req)
    {
		$stat = $req->query('status');
		if($stat != null && $stat == 'eligible'){
			$send =  new \stdClass();
			$send->tok = $req->query('tok');
			$send->savedtok = \AIndex::getmisc('pollfish_secret');
			$send->payout = $req->query('amount');
			$send->userid = $req->query('userid');
			$send->offer_id = $req->query('event');
			$send->ip = 'blank';
			$send->network = 'pollfish';
			return $this->Callback($send);
		} else {
			return 'not eligible';
		}
    }
}
