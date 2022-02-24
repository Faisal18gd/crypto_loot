<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use Auth;
use DB;

class Scratcher extends Controller
{
    public function Cards(Request $req)
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $cards = DB::table("game_scratcher_config")->get(['id', 'front_image', 'cost', 'min_win', 'max_win', 'cash_win']);
            return ['result' => \EncDec::enc(json_encode(['cards' => $cards]))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['result' => \EncDec::enc(json_encode(['error' => 'Token expired!', 'balance' => 0]))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['result' => \EncDec::enc(json_encode(['error' => 'Token invalid!', 'balance' => 0]))];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['result' => \EncDec::enc(json_encode(['error' => 'Login exception occured', 'balance' => 0]))];
        } catch (\Exception $e) {
            return ['result' => \EncDec::enc(json_encode(['error' => 'You need to login first!', 'balance' => 0]))];
        }
    }

    public function purchaseCard(Request $req)
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $id = (int) $req->get("c");
            $quantity = (int) $req->get("q");
            $bal = $user->balance;
            $cardInfo = DB::table("game_scratcher_config")->where('id', $id)->first();
            $require = $cardInfo->cost * $quantity;
            if ($cardInfo && $bal >= $require) {
                $user->decrement('balance', $require);
                $user->decrement('available', $require);
                \AIndex::updateStore($user->refid, $id, $quantity);
                return ['result' => \EncDec::enc(json_encode(['balance' => $bal - $require]))];
            } else {
                return ['result' => \EncDec::enc(json_encode(['error' => 'Insufficient token balance!', 'balance' => $bal]))];
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['result' => \EncDec::enc(json_encode(['error' => 'Token expired!', 'balance' => 0]))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['result' => \EncDec::enc(json_encode(['error' => 'Token invalid!', 'balance' => 0]))];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['result' => \EncDec::enc(json_encode(['error' => 'Login exception occured', 'balance' => 0]))];
        } catch (\Exception $e) {
            return ['result' => \EncDec::enc(json_encode(['error' => 'You need to login first!', 'balance' => 0]))];
        }
    }

    public function getReward(Request $req)
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $gameId = (int) $req->get("id");
            $uid = $user->refid;
            $check = DB::table('game_data')->where('userid', $uid);
            $check1 = $check->first();
            if ($check1 && $check1->scratch_won == 1) {
                $isWinner = true;
            } else {
                $isWinner = false;
            }
            $gameData = DB::table('game_scratcher_config')->where('id', $gameId)->first();
            if (!$gameData) {
                $gameData = DB::table('game_scratcher_config')->orderBy('id', 'ASC')->first();
                if (!$gameData) {
                    return ['result' => \EncDec::enc(json_encode(['status' => '0', 'message' => 'Item unavailable']))];
                }
            }
            $isPlayed = 1;
            $c = DB::table('game_scratcher_store')->where('userid', $user->refid)->first();
            if ($c) {
                $qty = unserialize($c->store);
                foreach ($qty as $q) {
                    if ($q['id'] == $gameId && $q['quantity'] > 0) {
                        $isPlayed = 0;
                    }
                }
            }
            if ($isPlayed == 1) {
                return ['result' => \EncDec::enc(json_encode(['status' => '0', 'message' => 'This card is not available for you, try to purchase it.']))];
            }
            $ease = 100 - $gameData->difficulty;
            $max = $gameData->max_win;
            $min = $gameData->min_win;
            $startRange = ($max - $min) * $ease / 200 + $min;
            $endRange = ($max - $min) * $ease / 100 + $min;
            $cacheReturn = $totalReturn = (int) rand($startRange, $endRange);

            $keys = array();
            $groups = 7;
            for ($i = 0; $i < 9; $i++) {
                if ($i < 6) {
                    $val = rand(1, (int) $cacheReturn / ($groups-$i));
                    $cacheReturn -= $val;
                    $keys[] = $val;
                } elseif ($i < 8) {
                    if ($isWinner) {
                        $keys[] = -999;
                    } else {
                        if (rand(0, 1) == 1) {
                            $more = rand(1, $cacheReturn);
                            $cacheReturn -= $more;
                            $keys[] = $more;
                        } else {
                            $keys[] = -999;
                        }
                    };
                } else {
                    if ($isWinner) {
                        $keys[] = -999;
                        $totalReturn -= $cacheReturn;
                    } else {
                        $keys[] = $cacheReturn;
                    }
                }
            }
            shuffle($keys);
            $wnr = 0;
            if ($isWinner) {
                $check->update(['scratch_won' => 0]);
                $cash = $gameData->cash_win;
                $user->increment('c_balance', $cash);
                $user->increment('c_available', $cash);
                $wnr = 1;
                DB::table('points')->insert([
                    'userid' => $uid,
                    'note' => 'scratcher winner',
                    'amount' => $cash,
                    'date' => Carbon::now()->timestamp
                ]);
            }
            if ($gameId == 1) {
                $user->increment('progress', 1);
            }
            $user->increment('balance', $totalReturn);
            $user->increment('available', $totalReturn);
            DB::table('tokens')->insert([
                'userid' => $uid,
                'note' => 'scratcher',
                'amount' => $totalReturn,
                'date' => Carbon::now()->timestamp
            ]);
            \AIndex::updateStore($uid, $gameId, -1);
            \AIndex::addToLeaderboard($uid, $totalReturn);
            return ['result' => \EncDec::enc(json_encode(['status' => '1', 'reward' => $totalReturn, 'winner' => $wnr, 'data' => $keys]))];
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

    public function addWinner(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            try {
                $email = $req->get('email');
                $check1 = DB::table('users')->where('email', $email)->first();
                if ($check1) {
                    $check2 = DB::table('game_data')->where('userid', $check1->refid);
                    if ($check2->first()) {
                        $check2->update(['scratch_won' => 1]);
                    } else {
                        DB::table('game_data')->insert(['userid' => $check1->refid, 'scratch_won' => 1]);
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
                DB::table('game_data')->where('userid', $req->get('d'))->update(['scratch_won' => 0]);
                return back()->with('success', 'Successfully deleted');
            } catch (\Exception $e) {
                return back()->with('error', 'Something wrong happened');
            }
        } else {
            return back()->with('error', 'Access denied!');
        }
    }

    public function addCard(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $this->validate(request(), [
                    'front_image' => 'required|mimes:jpeg,jpg,png|max:150',
                    'icon_image' => 'required|mimes:jpeg,jpg,png|max:50',
                    'cost' => 'required|numeric',
                    'free' => 'required|numeric',
                    'min_reward' => 'required|numeric',
                    'max_reward' => 'required|numeric',
                    'cash_reward' => 'required|numeric',
                    'difficulty' => 'required|numeric',
                    'link' => 'nullable|url',
                    'bgcolor' => ['nullable','regex:/^#([A-Fa-f0-9]{6})$/']
                ]);
            $filename = time().'_front.'.$req->file('front_image')->getClientOriginalExtension();
            $req->file('front_image')->move(public_path('uploads'), $filename);
            $imageUrl = env('APP_URL').'/uploads/'.$filename;
            $filename_i = time().'_icon.'.$req->file('icon_image')->getClientOriginalExtension();
            $req->file('icon_image')->move(public_path('uploads'), $filename_i);
            $imageUrl_i = env('APP_URL').'/uploads/'.$filename_i;
            $free = $req->get('free');
            $bgColor = $req->get('bgcolor');
			$link = $req->get('link');
			if($link == null) {
				$link = '';
			}
            $id = DB::table('game_scratcher_config')->insertGetId([
                    'front_image' => $imageUrl,
                    'icon_image' => $imageUrl_i,
                    'cost' => $req->get('cost'),
                    'free' => $free,
                    'min_win' => $req->get('min_reward'),
                    'max_win' => $req->get('max_reward'),
                    'cash_win' => $req->get('cash_reward'),
                    'difficulty' => $req->get('difficulty'),
                    'link' => $link,
                    'bgcolor' => $bgColor == null ? '#000000' : $bgColor
                ]);
            if ($id == 1 && $free == 0) {
                DB::table('game_scratcher_config')->where('id', 1)->update(['free' => 1]);
                return back()->with('success', 'Added, but this card was set to free on first try');
            }
            return back()->with('success', 'Scratch card adding was successful');
        } else {
            return back()->with('error', 'Access denied!');
        }
    }

    public function editCard(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $data = DB::table('game_scratcher_config')->where('id', $req->get('id'))->first();
            if ($data) {
                return view('admin/game-scratcher-popup', compact('data'));
            } else {
                return back()->with('error', 'Item not found');
            }
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }

    public function updateCard(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $this->validate(request(), [
                'id' => 'required|numeric',
                'front_image' => 'nullable|mimes:jpeg,jpg,png|max:150',
                'icon_image' => 'nullable|mimes:jpeg,jpg,png|max:50',
                'cost' => 'nullable|numeric',
                'free' => 'nullable|numeric',
                'min_reward' => 'nullable|numeric',
                'max_reward' => 'nullable|numeric',
                'cash_reward' => 'nullable|numeric',
                'difficulty' => 'nullable|numeric',
                'link' => 'nullable|url',
                'bgcolor' => ['nullable','regex:/^#([A-Fa-f0-9]{6})$/']
            ]);
            $id = $req->get('id');
            $free = $req->get('free');
            if ($id == 1 && $free == 0) {
                return back()->with('error', 'First card cannot be set to purchase only.');
            }
            $dataTable = DB::table('game_scratcher_config')->where('id', $id);
            $data = $dataTable->first();
            $imageUrl = null;
            $imageUrl_i = null;
            if ($req->file('front_image') != null) {
                $f = basename($data->front_image);
                $path = public_path('uploads').'\\'. $f;
                if (file_exists($path) && $f != '') {
                    unlink($path);
                }
                $filename = time().'_front.'.$req->file('front_image')->getClientOriginalExtension();
                $req->file('front_image')->move(public_path('uploads'), $filename);
                $imageUrl = env('APP_URL').'/uploads/'.$filename;
            };
            if ($req->file('icon_image') != null) {
                $i = basename($data->icon_image);
                $path_i = public_path('uploads').'\\'. $i;
                if (file_exists($path_i) && $i != '') {
                    unlink($path_i);
                }
                $filename_i = time().'_icon.'.$req->file('icon_image')->getClientOriginalExtension();
                $req->file('icon_image')->move(public_path('uploads'), $filename_i);
                $imageUrl_i = env('APP_URL').'/uploads/'.$filename_i;
            };
            $cost = $req->get('cost');
            $min = $req->get('min_reward');
            $max = $req->get('max_reward');
            $cash = $req->get('cash_reward');
            $diff = $req->get('difficulty');
            $col = $req->get('bgcolor');
            $url = $req->get('link');
            if ($imageUrl != null) {
                $dataTable->update(['front_image' => $imageUrl]);
            }
            if ($imageUrl_i != null) {
                $dataTable->update(['icon_image' => $imageUrl_i]);
            }
            if ($free != null) {
                $dataTable->update(['free' => $free]);
            }
            if ($cost != null) {
                $dataTable->update(['cost' => $cost]);
            }
            if ($min != null) {
                $dataTable->update(['min_win' => $min]);
            }
            if ($max != null) {
                $dataTable->update(['max_win' => $max]);
            }
            if ($cash != null) {
                $dataTable->update(['cash_win' => $cash]);
            }
            if ($col != null) {
                $dataTable->update(['bgcolor' => $col]);
            }
            if ($diff != null) {
                $dataTable->update(['difficulty' => $diff]);
            }
            if ($url != null) {
                $dataTable->update(['link' => $url]);
            }
            return redirect('members/scratcher')->with('success', 'Scratch card update was successful');
        } else {
            return back()->with('error', 'Access denied!');
        }
    }

    public function delCard(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            try {
                $id = $req->get('id');
                if ($id == 1) {
                    return back()->with('error', 'Cannot delete this main item, instead you can edit this card.');
                }
                $fetch = DB::table('game_scratcher_config')->where('id', $id);
                $data = $fetch->first();
                if ($data) {
                    $f = basename($data->front_image);
                    $path = public_path('uploads').'\\'. $f;
                    if (file_exists($path) && $f != '') {
                        unlink($path);
                    }
                    $i = basename($data->icon_image);
                    $path_i = public_path('uploads').'\\'. $i;
                    if (file_exists($path_i) && $i != '') {
                        unlink($path_i);
                    }
                }
                $fetch->delete();
                return redirect('members/scratcher')->with('success', 'Card item ' . $id . ' successfully deleted');
            } catch (\Exception $e) {
                return back()->with('error', 'Something wrong happened');
            }
        }
    }
}
