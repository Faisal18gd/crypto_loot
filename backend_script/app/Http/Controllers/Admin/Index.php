<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use \Carbon\Carbon;
use \Cache;
use App\User;
use Auth;
use DB;

class Index extends Controller
{
    public function chart()
    {
        if (Auth::id() == env('ADMIN')) {
            $value = Cache::remember('chart', 5, function () {
                $days = Input::get('days', 30);
                $range = Carbon::now()->subDays($days);
                return User::where('created_at', '>=', $range)
                    ->groupBy('date')
                    ->orderBy('date', 'DESC')
                    ->get([
                        DB::raw('Date(created_at) as date'),
                        DB::raw('COUNT(*) as value')
                    ])
                    ->toJSON();
            });
            return $value;
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
            
    public static function newmembers()
    {
        if (Auth::id() == env('ADMIN')) {
            return Cache::remember('userstoday', 5, function () {
                return DB::table('users')->whereDate('created_at', DB::raw('CURDATE()'))->count();
            });
        }
    }
    
    public static function newearnings()
    {
        if (Auth::id() == env('ADMIN')) {
            return Cache::remember('earningstoday', 5, function () {
                $tokens = DB::table('tokens')->where('is_adearn', 1)->whereDate('created_at', DB::raw('CURDATE()'))->sum('amount');
                $cash = $tokens * 100 / env('CASHTOPTS') / env('PAY_PCT');
                return round($cash, 2);
            });
        }
    }
    
    public static function totalearnings()
    {
        if (Auth::id() == env('ADMIN')) {
            return Cache::remember('adminindexearningstotal', 60, function () {
                $tokens = DB::table('tokens')->where('is_adearn', 1)->sum('amount');
                $cash = $tokens * 100 / env('CASHTOPTS') / env('PAY_PCT');
                return round($cash, 2);
            });
        }
    }
    
    public static function totalmembers()
    {
        if (Auth::id() == env('ADMIN')) {
            return Cache::remember('userstotal', 20, function () {
                return DB::table('users')->count();
            });
        }
    }
    
    protected function getuser($req)
    {
        if (Auth::id() == env('ADMIN')) {
            $usr = DB::table('users')->where('refid', $req)->first();
            if (!$usr) {
                return 'Unknown';
            }
            return $usr->name;
        }
    }
    
    public static function latestleads()
    {
        if (Auth::id() == env('ADMIN')) {
            return Cache::remember('latestleads', 10, function () {
                $l = DB::table('tokens')->limit(9)->where('is_adearn', 1)->orderBy('id', 'DESC');
                foreach ($l->get() as $ld) {
                    $res[] = [
                        'payout' => round($ld->amount * 100 / env('CASHTOPTS') / env('PAY_PCT'), 2),
                        'user' => (new Index())->getuser($ld->userid),
                        'times' => Carbon::parse($ld->created_at)->diffForHumans()
                    ];
                }
                if (! $l->first()) {
                    $res[] = ['payout' => '', 'user' => '', 'times' => ''];
                    return ['res'=>$res];
                }
                return ['res'=>$res];
            });
        }
    }
    
    public static function getmisc($req)
    {
        $exist = DB::table('misc')->where('name', $req)->first();
        if ($exist) {
            return $exist->data;
        }
        return '';
    }

    public static function setmisc($object, $value)
    {
        $exist = DB::table('misc')->where('name', $object);
        if ($exist->first()) {
            return $exist->update(['data' => $value]);
        } else {
            DB::table('misc')->insert(['name' => $object, 'data' => $value]);
        }
    }

    public function setEnvInt(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $key = $req->get('key');
            $max = $req->get('max');
            $isnumeric = $req->get('numeric')?$req->get('numeric'):false;
            if ($isnumeric) {
                $this->validate(request(), [
                    'value' => 'required|numeric|between:0.001,'.$max
                ]);
            } else {
                $this->validate(request(), [
                    'value' => 'required|digits_between:1,'.$max
                ]);
            }
            $val = $req->get('value');
            file_put_contents(\App::environmentFilePath(), str_replace(
                $key . '=' . env($key),
                $key . '=' . $val,
                file_get_contents(\App::environmentFilePath())
            ));
            if (file_exists(\App::getCachedConfigPath())) {
                \Artisan::call("config:cache");
            };
            return back()->with('success', 'Successfully updated');
        } else {
            return "Not allowed!";
        };
    }
    
    public static function resetOnline()
    {
        if (Auth::id() == env('ADMIN')) {
            DB::table('online_users')->truncate();
            \Cache::forget('onlineusers');
            return back();
        }
    }
    
    public static function addOnline($country, $ip)
    {
        $db = DB::table('online_users')->where('ip', $ip)->where('country', $country);
        if ($db->first()) {
            $db->update(['date' => time()]);
        } else {
            DB::table('online_users')->insert(['country' => $country, 'ip' => $ip, 'date' => time()]);
        };
    }

    public static function addref($user, $ref)
    {
        if ($user->referred_by == null || $user->referred_by == 'none') {
            $refby = DB::table('users')->where('refid', $ref);
            $refbyCheck = $refby->first();
            if ($refbyCheck && $user->refid != $ref) {
                $amount = (int) env('PAY_TO_ENTER_REF');
                $refAmt = (int) env('REF_FIXED_AMOUNT');
                if ($amount != 0) {
                    DB::table('users')->where('email', $user->email)->update([
                        'referred_by' => $ref,
                        'balance' => $amount,
                        'available' => $amount
                        ]);
                    DB::table('tokens')->insert([
                            'userid' => $user->refid,
                            'note' => 'referral',
                            'amount' => $amount,
                            'date' => Carbon::now()->timestamp
                        ]);
                    $refby->update([
                        'balance' => $refbyCheck->balance + $refAmt,
                        'available' => $refbyCheck->available + $refAmt,
                        'ref_earn' => $refbyCheck->ref_earn + $refAmt
                    ]);
                }
            }
        };
    }
    
    public static function makeLottoResult()
    {
        $dt = date("d-m-Y");
        $sdt = \AIndex::getmisc('lotto_draw_date');
        if ($dt != $sdt) {
            $winner = DB::table('game_data')->where('lotto_won', 1);
            $winnerData = $winner->first();
            $column = 'none';
            if ($winnerData) {
                $yesterday = date("d-m-Y", strtotime('-1 days'));
                if ($winnerData->lotto_date_1 == $yesterday) {
                    $column = 'lotto_data_1';
                } elseif ($winnerData->lotto_date_2 == $yesterday) {
                    $column = 'lotto_data_2';
                }
            }
            if ($winnerData && $column != 'none') {
                $entNum = explode(',', $winnerData->$column);
                if (count($entNum) > 0) {
                    $selected = $entNum[array_rand($entNum)];
                    $winner->update(['lotto_won' =>  0]);
                    \AIndex::setmisc("lotto_winner", $selected);
                }
            } else {
                $data = array();
                $date = date("d-m-Y", strtotime('-1 days'));
                $userNumbers1 = DB::table('game_data')->whereNotNull('lotto_data_1')->where('lotto_date_1', $date)->get();
                foreach ($userNumbers1 as $un1) {
                    $nums1 = explode(',', $un1->lotto_data_1);
                    foreach ($nums1 as $n1) {
                        array_push($data, $n1);
                    }
                }
                $userNumbers2 = DB::table('game_data')->whereNotNull('lotto_data_2')->where('lotto_date_2', $date)->get();
                foreach ($userNumbers2 as $un2) {
                    $nums2 = explode(',', $un2->lotto_data_2);
                    foreach ($nums2 as $n2) {
                        array_push($data, $n2);
                    }
                }
                $prefix = '';
                $suffix = '';
                for ($i = 0; $i < 2; $i++) {
                    $prefix .= mt_rand(11, 60);
                }
                do {
                    for ($i = 0; $i < 3; $i++) {
                        $suffix .= mt_rand(11, 60);
                    }
                } while (in_array($suffix, $data));
                $finalData =  $prefix .= $suffix;
                \AIndex::setmisc('lotto_winner', $finalData);
            }
            \AIndex::setmisc('lotto_draw_date', $dt);
        }
    }

    public static function addFreeCards($uid)
    {
        $check = DB::table('game_scratcher_config')->where('free', 1)->orderBy('id', 'ASC')->get();
        $data = array();
        foreach ($check as $c) {
            array_push($data, ['id' => $c->id, 'quantity' => 1]);
        }
        DB::table('game_scratcher_store')->updateOrInsert(['userid' => $uid, 'store' => serialize($data)]);
    }

    public static function updateStore($uid, $gameId, $quantity)
    {
        $data = DB::table('game_scratcher_store')->where('userid', $uid);
        $check = $data->first();
        $finalVal = (int)$quantity;
        if ($check) {
            $store = unserialize($check->store);
            for ($i = 0; $i < sizeof($store); $i++) {
                if ($store[$i]['id'] == $gameId) {
                    $finalVal = $store[$i]['quantity'] + $quantity;
                    if ($finalVal < 1) {
                        unset($store[$i]);
                        $store = array_values($store);
                    } else {
                        $store[$i]['quantity'] = $finalVal;
                    }
                }
            }
            if ($finalVal == $quantity && $quantity > 0) {
                $item = DB::table('game_scratcher_config')->where('id', $gameId)->first();
                if ($item) {
                    array_push($store, ['id' => $item->id, 'quantity' => $finalVal]);
                    $sort = array();
                    foreach ($store as $key => $row) {
                        $sort[$key] = $row['id'];
                    }
                    array_multisort($sort, SORT_ASC, $store);
                }
            }
            $data->update(['store' => serialize($store)]);
        }
        return $finalVal;
    }

    public static function addToLeaderboard($uid, $amt)
    {
        $dt = date("d-m-Y");
        $db = DB::table('leaderboard')->where('userid', $uid);
        $check = $db->first();
        if ($check) {
            if ($check->date_cur == $dt) {
                $db->increment('amount_cur', $amt);
            } else {
                $db->update([
                    'amount_prv' => $check->amount_cur,
                    'date_prv' => $check->date_cur,
                    'amount_cur' => $amt,
                    'date_cur' => $dt
                ]);
            }
        } else {
            $user = DB::table('users')->where('refid', $uid)->first();
            if ($user) {
                DB::table('leaderboard')->insert([
                    'name' => $user->name,
                    'userid' => $user->refid,
                    'avatar' => $user->avatar,
                    'amount_cur' => $amt,
                    'date_cur' => $dt
                ]);
            }
        }
    }
}
