<?php

namespace App\Http\Controllers;

use \Cache;
use Auth;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function regs()
    {
        return redirect('/members/index');
    }
    public function index()
    {
        if (Auth::id() == env('ADMIN')) {
            $wreq = \App\Withdrawreq::where('completed', '0')->count();
            $online = \Cache::remember('onlineusers', 5, function () {
                DB::table('online_users')->where('date', '<', time() - 86400)->delete();
                $lava = new \Khill\Lavacharts\Lavacharts;
                $popularity = $lava->DataTable();
                $users = DB::table('online_users')->select('country', DB::raw('count(*) as counter'))->groupBy('country')->get();
                $popularity->addStringColumn('Country')->addNumberColumn('Count');
                foreach ($users as $d) {
                    $popularity->addRow(['0' => $d->country, '1' => $d->counter]);
                };
                $options = ['backgroundColor' => '#cad2d3'];
                $lava->GeoChart('Popularity', $popularity, $options);
                return $lava;
            });
            $data = ['wreq' => $wreq, 'online' => $online];
            return view('admin/index', compact('data'));
        } else {
            return view('home');
        }
    }
    
    public function notif()
    {
        if (Auth::id() == env('ADMIN')) {
            $sett = [
                'GCM_KEY' => env('GCM_KEY'),
                'ADMIN' => env('ADMIN'),
                'EARNING_NOTIFICATION' => env('EARNING_NOTIFICATION')
            ];
            return view('admin/notification', compact('sett'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    
    public function users()
    {
        if (Auth::id() == env('ADMIN')) {
            $users = DB::table('users')
                    ->join('notification_ids', 'notification_ids.email', '=', 'users.email')
                    ->select('users.name', 'users.email', 'users.balance', 'users.referred_by', 'users.refid', 'users.banned', 'notification_ids.userinfo')
                    ->orderBy('users.id', 'desc')
                    ->paginate(10);
            return view('admin/members', compact('users'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    public function withd()
    {
        if (Auth::id() == env('ADMIN')) {
            $wrequests = \App\Withdrawreq::where('completed', '0')->orderBy('date', 'asc')->paginate(10);
            return view('admin/withdraw', compact('wrequests'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    public function cashreward()
    {
        if (Auth::id() == env('ADMIN')) {
            $gateways = DB::table('reward_type')->where('is_coin', 1)->get();
            return view('admin/cashreward', compact('gateways'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    public function gcreward()
    {
        if (Auth::id() == env('ADMIN')) {
            $gateways = DB::table('reward_type')->where('is_coin', 0)->get();
            return view('admin/gcreward', compact('gateways'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    public function psett()
    {
        if (Auth::id() == env('ADMIN')) {
            $payset = [
                'CASHTOPTS' => env('CASHTOPTS'),
                'VCASHTOPTS' => env('VCASHTOPTS'),
                'CHECK_IN_MIN' => env('CHECK_IN_MIN'),
                'CHECK_IN_MAX' => env('CHECK_IN_MAX'),
                'PAY_TO_ENTER_REF' => env('PAY_TO_ENTER_REF'),
                'REF_FIXED_AMOUNT' => env('REF_FIXED_AMOUNT'),
                'PAY_PCT' => env('PAY_PCT'),
            ];
            return view('admin/payment', compact('payset'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    
    public function appsett()
    {
        if (Auth::id() == env('ADMIN')) {
            $siteset = [
                'APP_NAME' => env('APP_NAME'),
                'APP_URL' => env('APP_URL'),
                'TIMEZONE' => env('TIMEZONE'),
                'DB_DATABASE' => env('DB_DATABASE'),
                'DB_HOST' => env('DB_HOST'),
                'DB_PORT' => env('DB_PORT'),
                'JWT_SECRET' => env('JWT_SECRET')
                ];
            $mailset = [
                'MAIL_DRIVER' => env('MAIL_DRIVER'),
                'MAIL_HOST' => env('MAIL_HOST'),
                'MAIL_PORT' => env('MAIL_PORT'),
                'MAIL_USERNAME' => env('MAIL_USERNAME'),
                'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
                'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION')
            ];
            $configs = ['sites' => $siteset, 'mails' =>$mailset];
            return view('admin/appsettings', compact('configs'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    
    public function adminprof()
    {
        if (Auth::id() == env('ADMIN')) {
            $admin = DB::table('users')->where('id', Auth::id())->first();
            return view('admin/adminprofile', compact('admin'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    
    public function wdhist()
    {
        if (Auth::id() == env('ADMIN')) {
            $whists =  DB::table('withdrawreqs')->where('completed', '1')->orderBy('id', 'desc')->paginate(10);
            return view('admin/histw', compact('whists'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    
    public function erhist()
    {
        if (Auth::id() == env('ADMIN')) {
            $ehists = DB::table('points')->orderBy('id', 'desc')->paginate(10);
            return view('admin/histe', compact('ehists'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    
    public function faq()
    {
        if (Auth::id() == env('ADMIN')) {
            $faqs = DB::table('faqs')->get();
            return view('admin/faq', compact('faqs'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    
    public function frauds()
    {
        if (Auth::id() == env('ADMIN')) {
            $db = DB::table('misc')->where('name', 'antifraud')->first();
            if ($db) {
                $f = $db->data;
            } else {
                $f = '';
            }
            $vpn = DB::table('users')->where('vpn', '>', '0')->whereNull('banned')->orderBy('id', 'desc')->paginate(10);
            $fraud = ['fr' => $f, 'vpns' => $vpn];
            return view('admin/fraud', compact('fraud'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    
    public function terms()
    {
        if (Auth::id() == env('ADMIN')) {
            $terms = file_get_contents(resource_path('views')."/terms.blade.php");
            return view('admin/tos', compact('terms'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    
    public function gameWheel()
    {
        if (Auth::id() == env('ADMIN')) {
            $data = DB::table('game_wheel')->orderBy('id', 'asc')->get();
            return view('admin/game-wheel', compact('data'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }

    public function gameScratcher()
    {
        if (Auth::id() == env('ADMIN')) {
            $wn = DB::table('game_data')->where('scratch_won', 1)->get();
            $d = array();
            foreach ($wn as $w) {
                $user = DB::table("users")->where("refid", $w->userid)->first();
                array_push($d, ['uid' => $w->userid, 'email' => $user->email]);
            }
            $gameData = DB::table('game_scratcher_config')->orderBy('id', 'asc')->get();
            $data = ['game' => $gameData, 'winner' => $d];
            return view('admin/game-scratcher', compact('data'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    
    public function gameTripler()
    {
        if (Auth::id() == env('ADMIN')) {
            return view('admin/game-tripler');
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
    
    public function gameLotto()
    {
        if (Auth::id() == env('ADMIN')) {
            $wn = DB::table('game_data')->where('lotto_won', 1)->get();
            $winners = array();
            foreach ($wn as $w) {
                $user = DB::table("users")->where("refid", $w->userid)->first();
                array_push($winners, ['uid' => $w->userid, 'email' => $user->email]);
            }
            $td = date("d-m-Y");
            $lottoUsers = array();
            $first = DB::table('game_data')->where('lotto_date_1', $td)->get(['userid','lotto_data_1']);
            foreach ($first as $f) {
                array_push($lottoUsers, ['id' => $f->userid, 'number' => $f->lotto_data_1]);
            }
            $second = DB::table('game_data')->where('lotto_date_2', $td)->get(['userid','lotto_data_2']);
            foreach ($second as $s) {
                array_push($lottoUsers, ['id' => $s->userid, 'number' => $s->lotto_data_2]);
            }
            $data = ['winners' => $winners, 'played' => $lottoUsers];
            return view('admin/game-lotto', compact('data'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
}
