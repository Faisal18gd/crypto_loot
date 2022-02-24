<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use Auth;
use DB;

class Lotto extends Controller
{
    private function getAmt($count)
    {
        if ($count < 4) {
            return ['cash' => 0, 'amount' => env('GAME_LOTTO_MATCH_' . $count)];
        } elseif ($count == 5) {
            return ['cash' => 1, 'amount' => env('GAME_LOTTO_MATCH_' . $count)];
        }
    }

    private function colToSelect($date1, $date2)
    {
        $lastDMY = date("d-m-Y", strtotime('-1 days'));
        if ($lastDMY == $date1) {
            return '2';
        } else {
            return '1';
        }
    }

    public function getReward(Request $req)
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $check = DB::table('game_data')->where('userid', $user->refid);
            $checkData = $check->first();
            $date = date("d-m-Y");
            $data = $req->get('n');
            if (strlen($data) != 10 || !is_numeric($data)) {
                return ['result' => \EncDec::enc(json_encode(['status' => '0', 'message' => 'Enter 5 sets of numbers!']))];
            }
            if ($checkData) {
                $col = $this->colToSelect($checkData->lotto_date_1, $checkData->lotto_date_2);
                $dte = 'lotto_date_'.$col;
                $dta = 'lotto_data_'.$col;
                if ($checkData->$dte == $date) {
                    return ['result' => \EncDec::enc(json_encode(['status' => '0', "message" => 'Already entered into the jackpot!']))];
                } else {
                    $check->update([$dte => $date, $dta => $data]);
                }
            } else {
                DB::table('game_data')->insert(['userid' => $user->refid, 'lotto_data_1' => $data, 'lotto_date_1' => $date]);
            }
            if ($user->progress == 1) {
                $user->increment('progress', 1);
            }
            return ['result' => \EncDec::enc(json_encode(['status' => '1', 'message' => "Your chosen 5 sets of numbers added for the next draw"]))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => '0', 'message' => 'Session expired! First logout then login again.']))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => '0', 'message' => 'Invalid security token!']))];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['result' => \EncDec::enc(json_encode(['status' => '0', 'message' => 'Login to play this game.']))];
        } catch (\Exception $e) {
            return response('Error', 400);
        }
    }

    public function getRewardHistory(Request $req)
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $response = array();
            $table = DB::table('game_data')->where('userid', $user->refid);
            $data =  $table->first();
            $today = date("d-m-Y");
            $yesterday = date("d-m-Y", strtotime('-1 days'));
            $todayHistory = null;
            $canClaim = false;
            $hist = null;
            if ($data) {
                if ($data->lotto_date_1 == $today) {
                    $todayHistory = $data->lotto_data_1;
                } elseif ($data->lotto_date_1 == $yesterday) {
                    $hist = $data->lotto_data_1;
                }
                if ($data->lotto_date_2 == $today) {
                    $todayHistory = $data->lotto_data_2;
                } elseif ($data->lotto_date_2 == $yesterday) {
                    $hist = $data->lotto_data_2;
                }
                if ($hist != null) {
                    $canClaim = $data->lotto_rewarded != $yesterday;
                }
            }
            \AIndex::makeLottoResult();
            if ($canClaim) {
                $claimCash = 0;
                $claimPoints = 0;
                $winner = \AIndex::getmisc('lotto_winner');
                $winnerdigits = str_split($winner, 2);
                $userdigits = str_split($hist, 2);
                $count = 0;
                for ($j = 0; $j < 5; $j++) {
                    if ($winnerdigits[$j] == $userdigits[$j]) {
                        $count +=1;
                    }
                }
                $amt = $this->getAmt($count);
                if ($amt['cash'] == 1) {
                    $claimCash = $amt['amount'];
                } else {
                    $claimPoints = $amt['amount'];
                }
                $table->update(['lotto_rewarded' => $yesterday]);
                $amount = 0;
                if ($claimCash != 0) {
                    $user->increment('c_balance', $claimCash);
                    $user->increment('c_available', $claimCash);
                    DB::table('points')->insert([
                        'userid' => $user->refid,
                        'note' => 'lotto winner',
                        'amount' => $claimCash,
                        'date' => Carbon::now()->timestamp
                    ]);
                    $amount = $claimCash;
                } elseif ($claimPoints != 0) {
                    $user->increment('balance', $claimPoints);
                    $user->increment('available', $claimPoints);
                    DB::table('tokens')->insert([
                        'userid' => $user->refid,
                        'note' => 'lotto',
                        'amount' => $claimPoints,
                        'date' => Carbon::now()->timestamp
                    ]);
                    $amount = $claimPoints;
                    \AIndex::addToLeaderboard($user->refid, $claimPoints);
                }
                return ['result' => \EncDec::enc(json_encode([
                                        'status' => '1',
                                        'istoken' => $claimCash == 0,
                                        'amount' => $amount,
                                        'wdigit' => $winner,
                                        'ydigit' => $hist
                                    ]))];
            } elseif ($todayHistory != null) {
                return ['result' => \EncDec::enc(json_encode(['status' => '2', 'message' => $todayHistory]))];
            } else {
                return ['result' => \EncDec::enc(json_encode([
                    'status' => '3',
                    "1" => env('GAME_LOTTO_MATCH_1'),
                    "2" => env('GAME_LOTTO_MATCH_2'),
                    "3" => env('GAME_LOTTO_MATCH_3'),
                    "4" => env('GAME_LOTTO_MATCH_4'),
                    "5" => env('GAME_LOTTO_MATCH_5')
                ]))];
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['status' => '0', 'message' => 'Session expired! First logout then login again.'];
            return ['result' => \EncDec::enc(json_encode(['status' => '0', 'message' => 'Session expired! First logout then login again.']))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['status' => '0', 'message' => 'Invalid security token!'];
            return ['result' => \EncDec::enc(json_encode(['status' => '0', 'message' => 'Invalid security token!']))];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['status' => '0', 'message' => 'Login to play this game.'];
            return ['result' => \EncDec::enc(json_encode(['status' => '0', 'message' => 'Login to play this game.']))];
        } catch (\Exception $e) {
            return response('Error', 400);
        }
    }

    public function addWinner(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            try {
                $email = $req->get('email');
                $check1 = DB::table('users')->where('email', $email)->first();
                if ($check1) {
                    $check2 = DB::table('game_data')->where('userid', $check1->refid);
                    if ($check2->first()) {
                        $check2->update(['lotto_won' => 1]);
                    } else {
                        DB::table('game_data')->insert(['userid' => $check1->refid, 'lotto_won' => 1]);
                    }
                    return back()->with('success', 'Addedd successfully');
                } else {
                    return back()->with('error', 'User not found with this email.');
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Something wrong happened');
            }
        } else {
            return back()->with('error', 'Access denied!');
        }
    }
    
    public function delWinner(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            try {
                DB::table('game_data')->where('userid', $req->get('d'))->update(['lotto_won' => 0]);
                return back()->with('success', 'Successfully deleted');
            } catch (\Exception $e) {
                return back()->with('error', 'Something wrong happened');
            }
        } else {
            return back()->with('error', 'Access denied!');
        }
    }

    public function showEmail(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            try {
                $uid = $req->get('uid');
                $e = DB::table('users')->where('refid', $uid)->first()->email;
                return back()->with('userinfo', '' . $uid . ' &nbsp;&nbsp;&nbsp; => &nbsp;&nbsp;&nbsp; <b>' . $e . '</b>');
            } catch (\Exception $e) {
                return back()->with('error', 'Email not found or invalid user!');
            }
        } else {
            return back()->with('error', 'Access denied!');
        }
    }
}
