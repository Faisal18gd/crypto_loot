<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use \Cache;
use Auth;
use DB;
use Carbon\Carbon;

class Members extends Controller
{
    public function membersearch(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $product = $this->validate(request(), [
                'email_search' => 'required',
            ]);
            $users = DB::table('users')
                    ->where('users.email', $req->get('email_search'))
                    ->orWhere('users.refid', $req->get('email_search'))
                    ->join('notification_ids', 'notification_ids.email', '=', 'users.email')
                    ->select('users.name', 'users.email', 'users.balance', 'users.referred_by', 'users.refid', 'users.banned', 'notification_ids.userinfo')
                    ->paginate(10);
            return view('admin/members', compact('users'));
        } else {
            return back()->with('error', 'Access denied!');
        }
    }
        
    public function memberban(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $user = \App\User::where('email', $req->get('userban'))->first();
            if ($user) {
                if ($req->get('clear')) {
                    $user->vpn = '0';
                    $user->save();
                } else {
                    if ($user->banned == null) {
                        $user->banned = 'yes';
                        $user->save();
                    } else {
                        $user->banned = null;
                        $user->save();
                    }
                };
                return back();
            }
        }
    }
    public function action(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $info = DB::table('users')->where('refid', $req->get('user'))->first();
            $uid = $info->refid;
            if (!$info) {
                return redirect('members/users');
            }
            if ($req->get('type') == 'reward') {
                $popup = ['type' => 'r', 'uid' => $uid, 'email'=> $info->email, 'balance' => $info->balance, 'name' => $info->name];
                return view('admin/reward', compact('popup'));
            } elseif ($req->get('type') == 'penalty') {
                $popup = ['type' => 'p', 'uid' => $uid, 'email'=> $info->email, 'balance' => $info->balance, 'name' => $info->name];
                return view('admin/reward', compact('popup'));
            } elseif ($req->get('type') == 'info') {
                $deviceinfo = DB::table('notification_ids')->where('email', $info->email)->first();
                $thistory = DB::table('tokens')->where('userid', $uid)->orderBy('id', 'desc')->paginate(5);
                $phistory = DB::table('points')->where('userid', $uid)->orderBy('id', 'desc')->paginate(5);
                $data = ['info' => $info, 'device' => $deviceinfo ? $deviceinfo : '0', 'phistory' => $phistory, 'thistory' => $thistory];
                return view('admin/memberinfo', compact('data'));
            }
        }
    }
    
    public function reward(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $id = $req->get('uid');
            $amt = $req->get('amount');
            if ($amt < 1 || !is_numeric($amt)) {
                return back()->with('error', 'Invalid amount');
            }
            DB::table('tokens')->insert([
            'userid' => $id,
            'note' => 'reward',
            'amount' => $amt,
            'date' => Carbon::now()->timestamp
            ]);
            $usr = DB::table('users')->where('refid', $id);
            $usr->increment('balance', $amt);
            $usr->increment('available', $amt);
            return back()->with('success', 'Rewards added successfully');
        } else {
            return back()->with('error', 'Access denied');
        }
    }
    public function penalty(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $id = $req->get('uid');
            $amt = $req->get('amount');
            if ($amt < 1 || !is_numeric($amt)) {
                return back()->with('error', 'Invalid amount');
            }
            DB::table('tokens')->insert([
            'userid' => $id,
            'note' => 'penalty',
            'amount' => - $amt,
            'date' => Carbon::now()->timestamp
            ]);
            $usr = DB::table('users')->where('refid', $id);
            $usr->decrement('balance', $amt);
            $usr->decrement('available', $amt);
            return back()->with('Penalty added successfully');
        } else {
            return back()->with('error', 'Access denied');
        }
    }
}
