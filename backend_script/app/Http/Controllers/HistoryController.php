<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use DB;

class HistoryController extends Controller
{
    public function getHistory(Request $req)
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $uid = $user->refid;
            $tab = (int) $req->get('t');
            if ($tab == 1) {
                $history = DB::table('tokens')->where('userid', $uid)->orderBy('created_at', 'DESC')->limit(20)->get(['note', 'amount']);
                $data = array();
                foreach ($history as $h) {
                    array_push($data, ['type' => $h->note, 'amount' => $h->amount]);
                }
                return ['status' => 1, "message" => $data];
            } elseif ($tab == 2) {
                $history = DB::table('points')->where('userid', $uid)->orderBy('created_at', 'desc')->limit(20)->get(['note', 'amount']);
                $data = array();
                foreach ($history as $h) {
                    array_push($data, ['type' => $h->note, 'amount' => $h->amount]);
                }
                return ['status' => 1, "message" => $data];
            } elseif ($tab == 3) {
                $history = DB::table('users')->where('referred_by', $user->refid)->orderBy('created_at', 'DESC')->limit(20)->get(['name']);
                $data = array();
                $amt = env('REF_FIXED_AMOUNT');
                foreach ($history as $h) {
                    array_push($data, ['type' => $h->name, 'amount' => $amt]);
                }
                return ['status' => 1, "message" => $data];
            } elseif ($tab == 4) {
                $history = DB::table('withdrawreqs')->where('user', $user->refid)->orderBy('id', 'desc')->limit(20)->get(['gateway','points']);
                $data = array();
                foreach ($history as $h) {
                    array_push($data, ['type' => $h->gateway, 'amount' => $h->points]);
                }
                return ['status' => 1, "message" => $data];
            }
            return ['status' => 0, "message" => "No history to show"];
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ['status' => 0, "message" => 'Token expired'];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ['status' => 0, "message" => 'Invalid token'];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['status' => 0, "message" => 'Authentication problem'];
        } catch (\Exception $e) {
            return ['status' => 0, "message" => 'Error occured!'];
        }
    }
}
