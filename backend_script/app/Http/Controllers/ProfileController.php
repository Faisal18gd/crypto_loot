<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use JWTAuth;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function balance()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $lowestpts = DB::table('reward_type')->orderBy('points', 'asc')->first();
            $lowestcash = DB::table('cashout_type')->orderBy('cash', 'asc')->first();
            return ['points' => $user->available, 'towd_p' => $lowestpts ? $lowestpts->points : 0, 'cash' => $user->c_available, 'towd_c' => $lowestcash ? $lowestcash->cash : 0];
        } catch (Exceptions $e) {
            return response('Invalid command', 400);
        }
    }
    
    public function profile()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $cards = array();
            $c = DB::table('game_scratcher_store')->where('userid', $user->refid)->first();
            if ($c) {
                $qty = unserialize($c->store);
                foreach ($qty as $q) {
                    $d = DB::table('game_scratcher_config')->where('id', $q['id'])->first();
                    if ($d) {
                        array_push($cards, ['id' => $q['id'], 'quantity' => $q['quantity'], 'image' => $d->front_image, 'icon' => $d->icon_image, 'url' => $d->link, 'win' => $d->cash_win, 'color' => $d->bgcolor]);
                    }
                }
            }
            $svuser = $user->check_in;
            $svtime = Carbon::now()->timestamp;
            if ($svuser == 0 || $svuser <  $svtime) {
                return ['status' => 1, 'avatar' => $user->avatar, 'name' => $user->name, 'email' => $user->email, 'cash' => $user->c_available, 'tokens' => $user->available, 'cardinfo' => $cards, 'time' => -1];
            } else {
                return ['status' => 1, 'avatar' => $user->avatar, 'name' => $user->name, 'email' => $user->email, 'cash' => $user->c_available,  'tokens' => $user->available, 'cardinfo' => $cards, 'time' => ($svuser - $svtime) * 1000];
            };
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['status' => 0, 'message' => 'Authorization token expired!'];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['status' => 0, 'message' => 'Invalid token!'];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['status' => 0, 'message' => 'Authentication problem'];
        } catch (Exception $e) {
            return ['status' => 0, 'message' => 'Error occured!'];
        }
    }

    public function profileInfo()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return ['result' => \EncDec::enc(json_encode(['uid' => $user->refid, 'name' => $user->name, 'avatar' => $user->avatar, 'email' => $user->email]))];
        } catch (Exceptions $e) {
            return response('Invalid command', 400);
        }
    }
    
    public function refcod()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $refc = DB::table('users')->where('id', $user->id)->first();
        $refby = 0;
        if ($refc->referred_by) {
            $refby = DB::table('users')->where('refid', $refc->referred_by)->first()->name;
        }
        return ['refcode' => $refc->refid, 'refby' => $refby];
    }
    
    public function changesett(Request $req)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if ($req->json('p')) {
                $user->password = bcrypt($req->json('p'));
                $user->save();
                return ['status' => 1, 'message' => 'Password changed successfully'];
            } elseif ($req->json('i')) {
                $user->avatar = $req->json('i');
                $user->save();
                return ['status' => 1, 'message' => 'Avatar updated successfully'];
            } elseif ($req->json('n')) {
                $user->name = $req->json('n');
                $user->save();
                return ['status' => 1, 'message' => 'Name changed successfully'];
            };
            return ['status' => 0, 'message' => 'Nothing to change'];
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['status' => 0, 'message' => 'Authorization token expired!'];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['status' => 0, 'message' => 'Invalid token!'];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['status' => 0, 'message' => 'Authentication problem'];
        } catch (Exception $e) {
            return ['status' => 0, 'message' => 'Error occured!'];
        }
    }

    public function checkin(Request $req)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $svuser = $user->check_in;
            $svtime = Carbon::now()->timestamp;
            $pts = rand(env('CHECK_IN_MIN'), env('CHECK_IN_MAX'));
            if ($svuser == 0 || $svuser <  $svtime) {
                DB::table('users')->where('refid', $user->refid)->update([
                    'check_in' => $svtime + 86400,
                    'balance' => $user->balance + $pts,
                    'available' => $user->available + $pts
                ]);
                DB::table('tokens')->insert([
                    'userid' => $user->refid,
                    'note' => 'checkin',
                    'amount' => $pts,
                    'date' => $svtime
                ]);
                return ['time' => $req->get('apptime')+86400000, 'tokens' => $pts];
            } else {
                return ['time' => ($svuser - $svtime) * 1000];
            };
        } catch (Exceptions $e) {
            return response('Invalid command', 400);
        }
    }
	
	public function addref(Request $req){
		try {
            $user = JWTAuth::parseToken()->authenticate();
			$ref = $req->get('c');
			if ($user->referred_by == null || $user->referred_by == 'none') {
				$refby = DB::table('users')->where('refid', $ref);
				$refbyCheck = $refby->first();
				if ($refbyCheck && $user->refid != $ref) {
					$amount = (int) env('PAY_TO_ENTER_REF');
					$refAmt = (int) env('REF_FIXED_AMOUNT');
					if ($amount != 0) {
						$usr = DB::table('users')->where('email', $user->email);
$curr_b = $usr->first()->balance;
$curr_a = $usr->first()->available;
$usr->update([
         'referred_by' => $ref,
         'balance' => $amount + $curr_b,
         'available' => $amount + $curr_a
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
						return ['status' => '1', 'message' => $refbyCheck->name];
					} else {
						return ['status' => '0', 'message' => 'Referral reward disabled!'];
					}
				} else {
					return ['status' => '0', 'message' => 'Unacceptable referral code!'];
				}
			} else {
				return ['status' => '0', 'message' => 'Already referred by someone!'];
			};
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['status' => '0', 'message' => 'Session expired! First logout then login again.'];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['status' => '0', 'message' => 'Invalid security token!'];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['status' => '0', 'message' => 'Login to play this game.'];
        } catch (\Exception $e) {
            return response('Error', 400);
		}
	}
}
