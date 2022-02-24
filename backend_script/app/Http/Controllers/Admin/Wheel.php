<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use Auth;
use DB;

class Wheel extends Controller
{
    public function gameData(Request $req)
    {
        $blankData = array(0,0,0,0,0,0,0,0,0,0,0,0);
        
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $data = array();
            $dta = DB::table('game_wheel')->get();
           
            $type = (int) env('GAME_WHEEL_PAYTYPE');
            foreach ($dta as $a) {
                array_push($data, round($a->amount, 0));
            }
            //$remain = env('GAME_WHEEL_MAX_FREE');
            $max_free = (int) env('GAME_WHEEL_MAX_FREE');
            $timeDelay = (int) env('GAME_WHEEL_MINS');
            $cost = (int) env('GAME_WHEEL_COST');
            $t = time();
           
            
            $q = DB::table('game_data')->where('userid', $user->refid);
           
            $check = $q->first();
            
            $isMax = 0;
           
            if ($check) {
                
                $currFree = $check->wheel_chances_free;
               
                $purchased = $check->wheel_chances;
                 
                $countDown = ($check->wheel_giveaway_time + ($timeDelay * 60)) - $t;
               
                if ($currFree < $max_free && $countDown < 0) {
                    $currFree = round(($t - $check->wheel_giveaway_time) / ($timeDelay * 60), 0, PHP_ROUND_HALF_DOWN) + $currFree;
                    if ($max_free < $currFree) {
                        $currFree = $max_free;
                    }
                    $q->update(['wheel_chances_free' => $currFree, 'wheel_giveaway_time' => $t]);
                    $countDown = $timeDelay * 60;
                }
              
                return ['result' => \EncDec::enc(json_encode([
                        'type' => $type, 
                        'data' => $data, 
                        'tokens' => $user->available, 
                        'spin_cost' => $cost, 
                        'free_chances' => $currFree, 
                        'max_free' => $max_free, 
                        'purchased_chances' => $purchased, 
                        'countdown' => $countDown
                    ]))];
            } else {
               
                DB::table('game_data')->insert(['userid' => $user->refid, 'wheel_chances_free' => 1, 'wheel_giveaway_time' => $t]);
                return ['result' => \EncDec::enc(json_encode([
                        'type' => $type, 
                        'data' => $data, 
                        'tokens' => $user->available, 
                        'spin_cost' => $cost, 
                        'free_chances' => 1, 
                        'max_free' => $max_free, 
                        'purchased_chances' => 0, 
                        'countdown' => $timeDelay * 60
                    ]))];
            }
            //if ($check && $check->wheel_date == date("d-m-Y")) {
            //  $remain -= $check->wheel_chances;
            //}
            //return ['result' => \EncDec::enc(json_encode(['type' => $type, 'data' => $data, 'remain' => $remain]))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['result' => \EncDec::enc(json_encode(['message' => 'Token expired!']))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['result' => \EncDec::enc(json_encode(['message' => 'Token invalid!']))];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['result' => \EncDec::enc(json_encode(['message' => 'Login exception occured']))];
        } catch (\Exception $e) {
           
            return ['result' => \EncDec::enc(json_encode(['message' => 'You need to login first!']))];
        }
    }

    public function getFreeChance(Request $req)
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $uid = $user->refid;
            $q = DB::table('game_data')->where('userid', $uid);
            $dta = $q->first();
            $t = time();
            $max_free = (int) env('GAME_WHEEL_MAX_FREE');
            $ftm = (int) env('GAME_WHEEL_MINS');
            $spin_cost = (int) env('GAME_WHEEL_COST');
            if ($dta) {
                $chances = $dta->wheel_chances_free ;
                if ($max_free > $chances && $dta->wheel_giveaway_time + ($ftm * 60) < $t) {
                    $q->update(['wheel_chances_free' => $chances + 1, 'wheel_giveaway_time' => $t]);
                    $countDown = $chances + 1 >= $max_free ? -1 : $ftm * 60;
                    //$countDown = $ftm * 60;
                    return ['result' => \EncDec::enc(json_encode([
                        'status' => 1,
                        'tokens' => $user->available,
                        'spin_cost' => $spin_cost,
                        'chances' => $chances + 1 + $dta->wheel_chances,
                        'free_chances' => $chances + 1,
                        'countdown' => $countDown
                    ]))];
                } elseif ($max_free <= $chances) {
                    return ['result' => \EncDec::enc(json_encode([
                        'status' => 1,
                        'tokens' => $user->available,
                        'spin_cost' => $spin_cost,
                        'chances' => $chances + $dta->wheel_chances,
                        'free_chances' => $chances,
                        'countdown' => -1
                    ]))];
                }
            };
            return ['result' => \EncDec::enc(json_encode(["status" => 2]))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'Token expired!']))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'Token invalid!']))];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'Login exception occured']))];
        } catch (\Exception $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'You need to login first!']))];
        }
    }

    public function purchaseChance(Request $req)
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $qty = $req->get('qty');
            if ($qty < 1) {
                return ['result' => \EncDec::enc(json_encode(["status" => 0, 'message' => 'Did not meet minimum purchase quantity.']))];
            }
            $spin_cost = (int) env('GAME_WHEEL_COST') * $qty;
            if ($user->available < $spin_cost) {
                return ['result' => \EncDec::enc(json_encode(["status" => 0, 'message' => 'Insufficient token balance!']))];
            }
            $uid = $user->refid;
            $q = DB::table('game_data')->where('userid', $uid);
            $dta = $q->first();
            $t = time();
            if ($dta) {
                $user->decrement('balance', $spin_cost);
                $user->decrement('available', $spin_cost);
                $chances = $dta->wheel_chances + $qty;
                $q->update(['wheel_chances' => $chances]);
                return ['result' => \EncDec::enc(json_encode(["status" => 1, 'chances' => $chances, 'tokens' => $user->available]))];
            }
            return ['result' => \EncDec::enc(json_encode(["status" => 2]))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'Token expired!']))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'Token invalid!']))];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'Login exception occured']))];
        } catch (\Exception $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'You need to login first!']))];
        }
    }

    public function getReward(Request $req)
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $uid = $user->refid;
			$premium = $req->get('p');
            $check = DB::table('game_data')->where('userid', $uid);
            $checkData = $check->first();
            if ($checkData) {
                $p_chance = $checkData->wheel_chances;
                $f_chance = $checkData->wheel_chances_free;
                if ($premium == 1) {
					if ($p_chance < 1) {
						return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'No chance available, purchase rotation chance.']))];
					}
                    $check->update(['wheel_chances' => $p_chance -1]);
                } else if ($premium == 0){
					if ($f_chance < 1) {
						return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'No chance available, purchase rotation chance.']))];
					}
                    $check->update(['wheel_chances_free' => $f_chance -1]);
                } else {
					return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'Invalid spin type selected']))];
				}
            } else {
                return ['result' => \EncDec::enc(json_encode(['status' => '0', "message" => 'Unknown error occurred!']))];
            }
            $arr = DB::table('game_wheel')->get();
            $keys = array();
            for ($i = 0; $i < count($arr); $i++) {
                for ($u = 0; $u < $arr[$i]->easiness; $u++) {
                    $keys[] = $i;
                };
            }
            $data = round($arr[$keys[rand(0, count($keys) - 1)]]->amount);
            if (env('GAME_WHEEL_PAYTYPE') == 1) {
                $user->increment('c_balance', $data);
                $user->increment('c_available', $data);
                DB::table('points')->insert([
                    'userid' => $uid,
                    'note' => 'wheel',
                    'amount' => $data,
                    'date' => Carbon::now()->timestamp
                ]);
            } else {
                $user->increment('balance', $data);
                $user->increment('available', $data);
                DB::table('tokens')->insert([
                    'userid' => $uid,
                    'note' => 'wheel',
                    'amount' => $data,
                    'date' => Carbon::now()->timestamp
                ]);
                \AIndex::addToLeaderboard($uid, $data);
            }
            return ['result' => \EncDec::enc(json_encode(['status' => '1', "message" => $data]))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'Token expired!']))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'Token invalid!']))];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'Login exception occured']))];
        } catch (\Exception $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'You need to login first!']))];
        }
    }
    
    public function setRewardType(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $key = 'GAME_WHEEL_PAYTYPE';
            $this->validate(request(), [
                't' => 'required|max:2'
            ]);
            $val = $req->get('t');
            file_put_contents(\App::environmentFilePath(), str_replace(
                $key . '=' . env($key),
                $key . '=' . $val,
                file_get_contents(\App::environmentFilePath())
            ));
            if (file_exists(\App::getCachedConfigPath())) {
                \Artisan::call("config:cache");
            };
            return back()->with('success', 'Updated successfully');
        } else {
            return "Not allowed!";
        };
    }

    public function setMaxSpin(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $this->validate(request(), [
                'max' => 'required|digits_between:1,3'
            ]);
            $key = 'GAME_WHEEL_MAX_FREE';
            $val = $req->get('max');
            file_put_contents(\App::environmentFilePath(), str_replace(
                $key . '=' . env($key),
                $key . '=' . $val,
                file_get_contents(\App::environmentFilePath())
            ));
            if (file_exists(\App::getCachedConfigPath())) {
                \Artisan::call("config:cache");
            };
            return back()->with('success', 'Updated successfully');
        } else {
            return "Not allowed!";
        };
    }

    public function setGameData(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $this->validate(request(), [
                'amount' => 'required|digits_between:1,7',
                'easiness' => 'required|integer|between:0,5'
            ]);
            $hard = $req->get('easiness');
            DB::table('game_wheel')->insert(['amount' => $req->get('amount'), 'easiness' => $hard]);
            return back()->with('success', 'Updated successfully');
        } else {
            return "Not allowed!";
        };
    }
    
    public function delGameData(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            DB::table('game_wheel')->where('id', $req->get("d"))->delete();
            return back()->with('success', 'Successfully deleted');
        } else {
            return "Not allowed!";
        };
    }
}
