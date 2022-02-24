<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class Withdraw extends Controller
{
    public function wdprocessed(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
           $user = \App\User::where('refid', $req->get('userid'))->first();
           
           $uid = \App\Withdrawreq::where('id', $req->get('id'))->first();
           
            $amt = $req->get('amount');
            $points = (float)$amt;
            if ($user && $uid) {
                if ($user->banned == null) {
                    if ($uid->is_cash == 1) {
                        if ($user->available < $amt) {
                            return back()->with('info', 'Insufficient coin balance');
                        } else {
                            $user->decrement('c_balance', $points);
                            $user->decrement('c_pending', $points);
                            $uid->update(['completed' => 0]);
                            // return back()->with('info', 'Points withdrawal marked as processed');
                            return view('admin/url', compact('uid'));
                        }
                    } elseif ($uid->is_cash == 0) {
                        if ($user->available < $amt) {
                            return back()->with('info', 'Insufficient token balance');
                        } else {
                            $user->decrement('balance', $points);
                            $user->decrement('pending', $points);
                            $uid->update(['completed' => 1]);
                            return back()->with('info', 'Token withdrawal marked as processed');
                        }
                    }
                    return back()->with('info', 'Unknown gateway selected by the user');
                } else {
                    return back()->with('info', 'Suspended member');
                }
            } else {
                return back()->with('info', 'User not found in database!');
            }
        } else {
            return back()->with('info', 'Access denied!');
        }
    }
        
    public function mailcheck(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $user = \App\User::where('refid', $req->get('userid'))->first();
            if ($user) {
                if ($user->banned == null) {
                    return back()->with('info', 'User ID: '.$req->get('userid').' &nbsp;&nbsp;&nbsp; => &nbsp;&nbsp;&nbsp; Email: '.$user->email);
                } else {
                    return back()->with('info', 'Suspended member');
                }
            } else {
                return back()->with('into', 'User not found in database!');
            }
        }
    }
    public function url(Request $req)
    {
       $id = $req->input('get_id');
       $url = $req->input('url');
       if($url==''){
           $url='';
       }
       DB::table('withdrawreqs')-> where('id', $id)-> update([
        'completed' => 1,
        'url' => $url,
        ]);
        $whists =  DB::table('withdrawreqs')->where('completed', '1')->orderBy('id', 'desc')->paginate(10);
        return view('admin/histw', compact('whists'));
        // return view('admin/histw')->with('info', 'Points withdrawal marked as processed');
    }
}
