<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Cache;
use \Carbon\Carbon;
use JWTAuth;
use Auth;
use DB;

class Leaderboard extends Controller
{
    public function getLeaderboard(Request $req)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (Cache::has('leaderboard')) {
                return Cache::get('leaderboard');
            } else {
                $td = date("d-m-Y");
                $self = DB::table('leaderboard')
                    ->where('userid', $user->refid)
                    ->where('date_cur', $td)
                    ->first();
                $selfAmount = 0;
                $selfRank = 0;
                if ($self) {
                    $selfAmount = $self->amount_cur;
                    $selfRank = DB::table('leaderboard')
                        ->where('date_cur', $td)
                        ->where('amount_cur', '>=', $selfAmount)
                        ->count();
                }
                $otherRanks = DB::table('leaderboard')
                    ->where('date_cur', $td)
                    ->orderBy('amount_cur', 'desc')
                    ->limit(10)
                    ->get(['name', 'avatar', 'amount_cur']);
                $data = [
                    'status' => 1,
                    'max_win' => env('LWR_1'),
                    'self_name' => $user->name,
                    'self_avatar' => $user->avatar,
                    'self_amount' => $selfAmount,
                    'self_rank' => $selfRank,
                    'others' => $otherRanks
                ];
                
                Cache::put('leaderboard', $data, 60);
                if (!Cache::has('reset_time')) {
                    $timeNow = Carbon::now()->timestamp;
                    $mins = round((Carbon::tomorrow()->timestamp - $timeNow) / 60);
                    Cache::put('reset_time', "1", $mins);
                    $label = 'Leaderboard: '. $td;
                    $check = DB::table('points')->where('note', $label)->first();
                    if (!$check) {
                        $yd = date("d-m-Y", strtotime('-1 days'));
                        $yRanks = DB::table('leaderboard')
                            ->where('date_prv', $yd)
                            ->orderBy('amount_prv', 'desc')
                            ->limit(10)
                            ->get(['userid']);
                        for ($i = 0; $i < count($yRanks); $i++) {
                            $uid = $yRanks[$i]->userid;
                            $amt = (int) env('LWR_'.($i+1));
                            $usr = DB::table('users')->where('refid', $uid);
                            $usr->increment('c_balance', $amt);
                            $usr->increment('c_available', $amt);
                            DB::table('points')->insert([
                                'userid' => $uid,
                                'note' => $label,
                                'amount' => $amt,
                                'date' => $timeNow
                            ]);
                        }
                    }
                }
                return $data;
            }
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
    public function getwinnerleaderboard(Request $req){
        $t = DB::table('leaderboard')
            ->where('date_cur', date("d-m-Y"))
            ->orderBy('amount_cur', 'desc')
            ->limit(10)
            ->get();
        $data[] = $t;
        // print_r($data);
        // // echo $data[1];
        $wordCount = $t->count();
        
        for($i = 1;$i<=10;$i++)
        {
           $seats = env('LWR_'.$i);
           $seat[]=$seats;
        }
        for($i = 0;$i<$wordCount;$i++)
        {
         $user_id= $t[$i]->userid;
         $env_point=$seat[$i];
         $type = DB::table('users')->where('refid', $user_id)->first();
        //  $user = User::where('email', $email)->first();
         $credit = $type->balance;
         $available = $type->available;
         $c_available=$type->c_available;
         DB::table('users')-> where('refid', $user_id)-> update([
            'balance' => ($credit+$env_point),
            'available' => ($available+$env_point),
            'c_available' => ($c_available+$env_point),
        ]);
        }
        
        
    
        
    }
    public function adminView()
    {
        if (Auth::id() == env('ADMIN')) {
            $t = DB::table('leaderboard')
                ->where('date_cur', date("d-m-Y"))
                ->orderBy('amount_cur', 'desc')
                ->limit(10)
                ->get();
            $y = DB::table('leaderboard')
                ->where('date_prv', date("d-m-Y", strtotime('-1 days')))
                ->orderBy('amount_prv', 'desc')
                ->limit(10)
                ->get();
            $data = ['today' => $t, 'yesterday' => $y];
            return view('admin/leaderboard', compact('data'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
}
