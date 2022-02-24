<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use JWTAuth;
use DB;
use App\Withdrawreq;
use Carbon\Carbon;

class WithdrawController extends Controller
{
    public function client(Request $req)
    {
        try {

            $user_id = $req->input('user_id');
            $currency = $req->input('currency');
            $network = $req->input('network');
            $address = $req->input('address');
            $points = $req->input('points');
            $user = JWTAuth::parseToken()->authenticate();
            $gate = $req->query('gate');
            if ($user->banned == 'yes') {
                return ['status' => 0, 'message' => 'Account suspended. Contact support service.'];
            }
            $type = DB::table('users')->where('refid', $user_id)->first();
            if (!$type) {
                return ['status' => 0, 'message' => 'User not found'];
            }
            $credit = $type->balance;
            if ($points < $credit) {

                Withdrawreq::create([
                    'user' => $user_id,
                    'currency' => $currency,
                    'network' => $network,
                    'address' => $address,
                    'points' => $points,
                    'is_cash' => 1,
                    'completed' => 0,
                    'ip_address' => \Request::ip(),
                    'date' => Carbon::now()->timestamp
                ]);
                DB::table('users')-> where('refid', $user_id)-> update([
                    'balance' => ($credit-$points),
                    'available' => ($credit-$points),
                    'c_available' => ($credit-$points),
                ]);

                return ['status' => 1, 'message' => 'Withdraw Request Sended Successfully'];
            }
            else{
                return ['status' => 1, 'message' => 'Withdraw Problem'];
            }

            return ['status' => 0, 'message' => 'You Have NOt Enough Balance'];
            die();
        }
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['status' => 0, 'message' => 'Token expired!'];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['status' => 0, 'message' => 'Token invalid!'];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['status' => 0, 'message' => 'Login exception occured'];
        }
        catch (\Exception $e) {
            return ['status' => 0, 'message' => 'You need to login first!'];
        }
    }

    public function typeGC(Request $req)
    {
        $c = $req->get('country');
        $rwd = DB::table('reward_type')
            ->where('is_coin', 0)
            ->where(function ($q) use ($c) {
                $q->where('country', $c);
                $q->orWhere('country', 'all');
            })
            ->get();
        return ['type' => $rwd];
    }

    public function typeCash(Request $req)
    {
        $c = $req->get('country');
        $rwd = DB::table('reward_type')
            ->where('is_coin', 1)
            ->where(function ($q) use ($c) {
                $q->where('country', $c);
                $q->orWhere('country', 'all');
            })
            ->get();
        return ['type' => $rwd];
    }
}
