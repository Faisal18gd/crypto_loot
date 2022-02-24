<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Edujugon\PushNotification\PushNotification;

class VideoCallbackController extends Controller
{
    protected function Callback($request)
    {
        $payout = round($request->payout);
        if ($request->tok != $request->savedtok) {
            return response('invalid request', 403);
        }
        if (!$payout || $payout == '' || !is_numeric($payout)) {
            return response('undefined payout', 403);
        }
        if (!$request->userid || $request->userid == '') {
            return response('0');
        }
        if ($request->userid == 'visitor' || $request->userid == 'guest') {
            return response('1');
        }
        try {
            $vid = DB::table('points')->where('userid', $request->userid)->where('note', 'video');
            $vidCheck = $vid->first();
            if ($vidCheck) {
                $vid->update(['amount' => $vidCheck->amount + $payout]);
            } else {
                DB::table('points')->insert([
                    'userid'=> $request->userid,
                    'note' => 'video',
                    'amount' => $payout,
                    'date' => Carbon::now()->timestamp
                ]);
            }
            $usr = DB::table('users')->where('refid', $request->userid);
            $u = $usr->first();
            if ($u) {
                $usr->increment('balance', $payout);
                $usr->increment('available', $payout);
                \AIndex::addToLeaderboard($u->refid, $payout);
            }
            return response('1');
        } catch (\Exception $e) {
            return response('1');
        }
    }
    
    public function adcolony(Request $req)
    {
        $send =  new \stdClass();
        $send->tok = $req->query('tok');
        $send->savedtok = \AIndex::getmisc('adColony_secret');
        $send->payout = $req->query('amount');
        $send->userid = $req->query('userid');
        return $this->Callback($send);
    }
}
