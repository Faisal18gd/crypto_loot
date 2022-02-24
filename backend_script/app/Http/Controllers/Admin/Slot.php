<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class Slot extends Controller
{
    public function gameSlot()
    {
        if (Auth::id() == env('ADMIN')) {
            return view('admin/game-slot');
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }

    public function gameData(Request $req)
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $uid = $user->refid;
            $q = DB::table('game_data')->where('userid', $uid);
            $qry = $q->first();
            $t = time();
            $ftm = (int) env('FREE_SPIN_MINS');
            $max_free = (int) env('MAX_FREE_SPIN');
            if ($qry) {
                $ot = $qry->slot_giveaway_time;
                $nt = $ot + ($ftm * 60);
                $free_chance = $qry->slot_free_chances;
                if ($t > $nt && $max_free > $free_chance) {
                    $nt = $t + ($ftm * 60);
                    $free_chance = round(($t - $ot) / ($ftm * 60), 0, PHP_ROUND_HALF_DOWN) + $free_chance;
                    if ($max_free < $free_chance) {
                        $free_chance = $max_free;
                    }
                    $q->update([
                        'slot_free_chances' => $free_chance,
                        'slot_giveaway_time' => $t,
                    ]);
                };
                $chances = $qry->slot_chances;
                $countDown = $nt - $t;
                if ($max_free <= $free_chance) {
                    $countDown = -1;
                }
                $spin_cost = (int) env('SPIN_COST');
                $userData = [
                    'sp_start' => (int) env('SPEED_START'),
                    'sp_normal' => (int) env('SPEED_NORMAL'),
                    'sp_delay' => (int) env('SPEED_DELAY'),
                    'm_3' => (int) env('MATCH_3'),
                    'm_4' => (int) env('MATCH_4'),
                    'm_5' => (int) env('MATCH_5'),
                    'iv_1' => (int) env('ITEM_VALUE_1'),
                    'iv_2' => (int) env('ITEM_VALUE_2'),
                    'iv_3' => (int) env('ITEM_VALUE_3'),
                    'iv_4' => (int) env('ITEM_VALUE_4'),
                    'iv_5' => (int) env('ITEM_VALUE_5'),
                    'iv_6' => (int) env('ITEM_VALUE_6'),
                    'iv_7' => (int) env('ITEM_VALUE_7'),
                    'iv_8' => (int) env('ITEM_VALUE_8'),
                    'iv_9' => (int) env('ITEM_VALUE_9')
                ];
            } else {
                DB::table('game_data')->insert([
                    'userid' => $uid,
                    'slot_free_chances' => 1,
                    'slot_giveaway_time' => $t
                ]);
                $chances = 0;
                $free_chance = 1;
                $countDown = $ftm * 60;
                $spin_cost = (int) env('SPIN_COST');
                $userData = [
                    'sp_start' => (int) env('SPEED_START'),
                    'sp_normal' => (int) env('SPEED_NORMAL'),
                    'sp_delay' => (int) env('SPEED_DELAY'),
                    'm_3' => (int) env('MATCH_3'),
                    'm_4' => (int) env('MATCH_4'),
                    'm_5' => (int) env('MATCH_5'),
                    'iv_1' => (int) env('ITEM_VALUE_1'),
                    'iv_2' => (int) env('ITEM_VALUE_2'),
                    'iv_3' => (int) env('ITEM_VALUE_3'),
                    'iv_4' => (int) env('ITEM_VALUE_4'),
                    'iv_5' => (int) env('ITEM_VALUE_5'),
                    'iv_6' => (int) env('ITEM_VALUE_6'),
                    'iv_7' => (int) env('ITEM_VALUE_7'),
                    'iv_8' => (int) env('ITEM_VALUE_8'),
                    'iv_9' => (int) env('ITEM_VALUE_9')
                ];
            };
            return ['result' => \EncDec::enc(json_encode([
                    "status" => 1,
                    "tokens" => $user->available,
                    "chances" => $chances,
                    "free_chances" => $free_chance,
                    "max_giveaway" => $max_free,
                    "countdown" => $countDown,
                    "spin_cost" => $spin_cost,
                    "data" => $userData,
                ]))];
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
    
    public function getFreeChance(Request $req)
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $uid = $user->refid;
            $q = DB::table('game_data')->where('userid', $uid);
            $dta = $q->first();
            $t = time();
            $max_free = (int) env('MAX_FREE_SPIN');
            $ftm = (int) env('FREE_SPIN_MINS');
            if ($dta) {
                $chances = $dta->slot_free_chances;
                if ($max_free > $chances && $dta->slot_giveaway_time + ($ftm * 60) < $t) {
                    $q->update(['slot_free_chances' => $chances + 1, 'slot_giveaway_time' => $t]);
                    $countDown = $chances + 1 >= $max_free ? -1 : $ftm * 60;
                    return ['result' => \EncDec::enc(json_encode(["status" => 1, 'chances' => $dta->slot_chances, 'free_chances' => $chances + 1, 'countdown' => $countDown]))];
                } elseif ($max_free <= $chances) {
                    return ['result' => \EncDec::enc(json_encode(["status" => 1, 'chances' => $dta->slot_chances, 'free_chances' => $chances, 'countdown' => -1]))];
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
            $spin_cost = (int) env('SPIN_COST') * $qty;
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
                $chances = $dta->slot_chances;
                $q->update(['slot_chances' => $chances + $qty]);
                return ['result' => \EncDec::enc(json_encode(["status" => 1, 'chances' => $chances + $qty, 'tokens' => $user->available]))];
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
			$premium = $req->get('p');
            $uid = $user->refid;
            $q = DB::table('game_data')->where('userid', $uid);
            $g_data = $q->first();
            $p_chance = $g_data->slot_chances;
            $f_chance = $g_data->slot_free_chances;
            if ($premium == 1) {
				if ($p_chance < 1) {
					return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'No chance available, purchase rotation chance.']))];
				}
				$q->update(['slot_chances' => $p_chance -1]);
            } else if ($premium == 0){
				if ($f_chance < 1) {
					return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'No chance available, purchase rotation chance.']))];
				}
                $q->update(['slot_free_chances' => $f_chance -1]);
            } else {
				return ['result' => \EncDec::enc(json_encode(['status' => 0, 'message' => 'Invalid spin type selected']))];
			}
            $vi = [];
            $numbers = array(1,2,3,4,5,6,7,8,9);
            for ($i = 0; $i < 5; $i++) {
                shuffle($numbers);
                array_push($vi, array_slice($numbers, 0, 3));
            }
            $dta = $this->checkematch($uid, $vi);
            $matched = $dta['mhd'];
            $vi = $dta['n_ar'];

            //test start
            /*
            $tes = [];
            array_push($tes, ['line' => 1, 'item' => 6, 'matched' => 3]);
            array_push($tes, ['line' => 8, 'item' => 3, 'matched' => 5]);
            return ['status' => 1, 'items' => $vi, 'lines' => $matched, 'won' => 0, 'tokens' => $user->available];
            */
            //test end

            $won = 0;
            $matchSize = sizeof($matched);
            if ($matchSize != 0) {
                for ($j = 0; $j < $matchSize; $j++) {
                    $won += (int) env('MATCH_' . $matched[$j]['matched']) * (int) env('ITEM_VALUE_' . $matched[$j]['item']);
                }
                if ($won > 0) {
                    $user->increment('balance', $won);
                    $user->increment('available', $won);
                    DB::table('tokens')->insert([
                    'userid' => $uid,
                    'note' => 'slot',
                    'amount' => $won,
                    'date' => time()
                ]);
                    \AIndex::addToLeaderboard($uid, $won);
                }
            }
            if ($premium == 1) {
				return ['result' => \EncDec::enc(json_encode(['status' => 1, 'items' => $vi, 'lines' => $matched, 'won' => $won, 'tokens' => $user->available, 'chances' => $p_chance - 1, 'free' => $f_chance]))];
			} else {
				return ['result' => \EncDec::enc(json_encode(['status' => 1, 'items' => $vi, 'lines' => $matched, 'won' => $won, 'tokens' => $user->available, 'chances' => $p_chance, 'free' => $f_chance - 1]))];
			}
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

    private function checkematch($uid, $vis)
    {
        $vi = $vis;
        $wL = rand(0, 19);
        $f_mch = rand(3, 5);
        $wItem = rand(1, 9);
        if ($wL == 0) {
            if ($f_mch > 2) {
                $vi[0][1] = $wItem;
                $vi[1][1] = $wItem;
                $vi[2][1] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][1] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][1] = $wItem;
            }
        } elseif ($wL == 1) {
            if ($f_mch > 3) {
                $vi[0][0] = $wItem;
                $vi[1][0] = $wItem;
                $vi[2][0] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][0] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][0] = $wItem;
            }
        } elseif ($wL == 2) {
            if ($f_mch > 3) {
                $vi[0][2] = $wItem;
                $vi[1][2] = $wItem;
                $vi[2][2] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][2] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][2] = $wItem;
            }
        } elseif ($wL > 3) {
            if ($f_mch > 3) {
                $vi[0][0] = $wItem;
                $vi[1][1] = $wItem;
                $vi[2][2] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][1] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][0] = $wItem;
            }
        } elseif ($wL == 4) {
            if ($f_mch > 3) {
                $vi[0][2] = $wItem;
                $vi[1][1] = $wItem;
                $vi[2][0] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][1] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][2] = $wItem;
            }
        } elseif ($wL == 5) {
            if ($f_mch > 3) {
                $vi[0][1] = $wItem;
                $vi[1][0] = $wItem;
                $vi[2][0] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][0] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][1] = $wItem;
            }
        } elseif ($wL == 6) {
            if ($f_mch > 3) {
                $vi[0][1] = $wItem;
                $vi[1][2] = $wItem;
                $vi[2][2] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][2] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][1] = $wItem;
            }
        } elseif ($wL == 7) {
            if ($f_mch > 3) {
                $vi[0][0] = $wItem;
                $vi[1][0] = $wItem;
                $vi[2][1] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][2] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][2] = $wItem;
            }
        } elseif ($wL == 8) {
            if ($f_mch > 3) {
                $vi[0][2] = $wItem;
                $vi[1][2] = $wItem;
                $vi[2][1] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][0] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][0] = $wItem;
            }
        } elseif ($wL == 9) {
            if ($f_mch > 3) {
                $vi[0][1] = $wItem;
                $vi[1][2] = $wItem;
                $vi[2][1] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][0] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][1] = $wItem;
            }
        } elseif ($wL == 10) {
            if ($f_mch > 3) {
                $vi[0][1] = $wItem;
                $vi[1][0] = $wItem;
                $vi[2][1] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][2] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][1] = $wItem;
            }
        } elseif ($wL == 11) {
            if ($f_mch > 3) {
                $vi[0][0] = $wItem;
                $vi[1][1] = $wItem;
                $vi[2][1] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][1] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][0] = $wItem;
            }
        } elseif ($wL == 12) {
            if ($f_mch > 3) {
                $vi[0][2] = $wItem;
                $vi[1][1] = $wItem;
                $vi[2][1] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][1] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][2] = $wItem;
            }
        } elseif ($wL == 13) {
            if ($f_mch > 3) {
                $vi[0][0] = $wItem;
                $vi[1][1] = $wItem;
                $vi[2][0] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][1] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][0] = $wItem;
            }
        } elseif ($wL == 14) {
            if ($f_mch > 3) {
                $vi[0][2] = $wItem;
                $vi[1][1] = $wItem;
                $vi[2][2] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][1] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][2] = $wItem;
            }
        } elseif ($wL == 15) {
            if ($f_mch > 3) {
                $vi[0][1] = $wItem;
                $vi[1][1] = $wItem;
                $vi[2][0] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][1] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][1] = $wItem;
            }
        } elseif ($wL == 16) {
            if ($f_mch > 3) {
                $vi[0][1] = $wItem;
                $vi[1][1] = $wItem;
                $vi[2][2] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][1] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][1] = $wItem;
            }
        } elseif ($wL == 17) {
            if ($f_mch > 3) {
                $vi[0][0] = $wItem;
                $vi[1][0] = $wItem;
                $vi[2][2] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][0] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][0] = $wItem;
            }
        } elseif ($wL == 18) {
            if ($f_mch > 3) {
                $vi[0][2] = $wItem;
                $vi[1][2] = $wItem;
                $vi[2][0] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][2] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][2] = $wItem;
            }
        } elseif ($wL == 19) {
            if ($f_mch > 3) {
                $vi[0][0] = $wItem;
                $vi[1][2] = $wItem;
                $vi[2][2] = $wItem;
            }
            if ($f_mch > 3) {
                $vi[3][2] = $wItem;
            }
            if ($f_mch > 4) {
                $vi[4][0] = $wItem;
            }
        }
        $mch = array();
        array_push($mch, [$vi[0][1], $vi[1][1], $vi[2][1], $vi[3][1], $vi[4][1]]);
        array_push($mch, [$vi[0][0], $vi[1][0], $vi[2][0], $vi[3][0], $vi[4][0]]);
        array_push($mch, [$vi[0][2], $vi[1][2], $vi[2][2], $vi[3][2], $vi[4][2]]);
        array_push($mch, [$vi[0][0], $vi[1][1], $vi[2][2], $vi[3][1], $vi[4][0]]);
        array_push($mch, [$vi[0][2], $vi[1][1], $vi[2][0], $vi[3][1], $vi[4][2]]);
        array_push($mch, [$vi[0][1], $vi[1][0], $vi[2][0], $vi[3][0], $vi[4][1]]);
        array_push($mch, [$vi[0][1], $vi[1][2], $vi[2][2], $vi[3][2], $vi[4][1]]);
        array_push($mch, [$vi[0][0], $vi[1][0], $vi[2][1], $vi[3][2], $vi[4][2]]);
        array_push($mch, [$vi[0][2], $vi[1][2], $vi[2][1], $vi[3][0], $vi[4][0]]);
        array_push($mch, [$vi[0][1], $vi[1][2], $vi[2][1], $vi[3][0], $vi[4][1]]);
        array_push($mch, [$vi[0][1], $vi[1][0], $vi[2][1], $vi[3][2], $vi[4][1]]);
        array_push($mch, [$vi[0][0], $vi[1][1], $vi[2][1], $vi[3][1], $vi[4][0]]);
        array_push($mch, [$vi[0][2], $vi[1][1], $vi[2][1], $vi[3][1], $vi[4][2]]);
        array_push($mch, [$vi[0][0], $vi[1][1], $vi[2][0], $vi[3][1], $vi[4][0]]);
        array_push($mch, [$vi[0][2], $vi[1][1], $vi[2][2], $vi[3][1], $vi[4][2]]);
        array_push($mch, [$vi[0][1], $vi[1][1], $vi[2][0], $vi[3][1], $vi[4][1]]);
        array_push($mch, [$vi[0][1], $vi[1][1], $vi[2][2], $vi[3][1], $vi[4][1]]);
        array_push($mch, [$vi[0][0], $vi[1][0], $vi[2][2], $vi[3][0], $vi[4][0]]);
        array_push($mch, [$vi[0][2], $vi[1][2], $vi[2][0], $vi[3][2], $vi[4][2]]);
        array_push($mch, [$vi[0][0], $vi[1][2], $vi[2][2], $vi[3][2], $vi[4][0]]);
        
        $totalMatch = [];
        for ($i = 0; $i < sizeof($mch); $i++) {
            $a = $mch[$i][0];
            $b = $mch[$i][1];
            $c = $mch[$i][2];
            $d = $mch[$i][3];
            $e = $mch[$i][4];
            if ($a == $b && $a == $c && $a == $d && $a == $e) {
                array_push($totalMatch, ['line' => $i + 1, 'item' => $a, 'matched' => 5]);
            } elseif ($a == $b && $a == $c && $a == $d) {
                array_push($totalMatch, ['line' => $i + 1, 'item' => $a, 'matched' => 4]);
            } elseif ($a == $b && $a == $c) {
                array_push($totalMatch, ['line' => $i + 1, 'item' => $a, 'matched' => 3]);
            }
        }
        return ['mhd' => $totalMatch, "n_ar" => $vi];
    }
}
