<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\notification_id;
use JWTAuth;
use Auth;
use DB;

class Frauds extends Controller
{
    public function doCheck(Request $req)
    {
        $key = \EncDec::encKey();
        $time = mktime(24, 0, 0);
        $ip = \Request::ip();
		//$ip = "127.0.0.1";
        $lotto = env('GAME_LOTTO_MATCH_5');
        $referrer = env('REF_FIXED_AMOUNT');
        $referred = env('PAY_TO_ENTER_REF');
        try {
            \AIndex::addOnline(strtoupper($req->json('cc')), $ip);
            $info = $req->json('info');
            $root = env('ROOT_BLOCK');
            $vpn = env('VPN_BLOCK');
            $silent = env('SILENT_DETECT');
            $match = DB::table('misc')->where('name', 'antifraud')->first();
            $sdk = \AIndex::getmisc('hide_offerwalls');
            if ($match && str_contains($info, explode(',', $match->data))) {
                $returnData = ['result' => '2', 'r' => $root, 'v' => $vpn, 's' => $silent, 'd' => $sdk, 'lotto' => $lotto, 'time' => $time, 'referrer' => $referrer, 'referred' => $referred];
                return ['size' => $key, 'data' => \EncDec::enc(json_encode($returnData))];
            }
            $user = JWTAuth::parseToken()->authenticate();
            if ($user && $user->banned != 'yes') {
                $uinfo = str_replace(["}","{",", "], ["","","<br>"], $info);
                $infos = notification_id::where('email', $user->email)->first();
                if ($infos) {
                    $infos->update(['userinfo' => $uinfo]);
                } else {
                    notification_id::create(['email' => $user->email, 'userinfo' => $uinfo]);
                }
				$rb = $user->referred_by;
				if($rb == null || $rb == 'none'){
					$returnData = ['result' => '1', 'r' => $root, 'v' => $vpn, 's' => $silent, 'd' => $sdk, 'lotto' => $lotto, 'time' => $time, 'progress' => $user->progress, 'referrer' => $referrer, 'referred' => $referred];
				} else {
					$rf = DB::table('users')->where('refid', $rb)->first();
					if($rf){
						$returnData = ['result' => '1', 'r' => $root, 'v' => $vpn, 's' => $silent, 'd' => $sdk, 'lotto' => $lotto, 'time' => $time, 'progress' => $user->progress, 'referrer' => $referrer, 'referred' => $referred, 'refby' => $rf->name];
					} else {
						$returnData = ['result' => '1', 'r' => $root, 'v' => $vpn, 's' => $silent, 'd' => $sdk, 'lotto' => $lotto, 'time' => $time, 'progress' => $user->progress, 'referrer' => $referrer, 'referred' => $referred];
					}
					
				}
                return ['size' => $key, 'data' => \EncDec::enc(json_encode($returnData))];
            } else {
                $returnData =  ['result' => '0', 'r' => $root, 'v' => $vpn, 's' => $silent, 'd' => $sdk, 'lotto' => $lotto, 'time' => $time, 'referrer' => $referrer, 'referred' => $referred];
                return ['size' => $key, 'data' => \EncDec::enc(json_encode($returnData))];
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $returnData =  ['result' => '0', 'r' => $root, 'v' => $vpn, 's' => $silent, 'd' => $sdk, 'lotto' => $lotto, 'time' => $time, 'referrer' => $referrer, 'referred' => $referred];
            return ['size' => $key, 'data' => \EncDec::enc(json_encode($returnData))];
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $returnData =  ['result' => '0', 'r' => $root, 'v' => $vpn, 's' => $silent, 'd' => $sdk, 'lotto' => $lotto, 'time' => $time, 'referrer' => $referrer, 'referred' => $referred];
            return ['size' => $key, 'data' => \EncDec::enc(json_encode($returnData))];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $returnData =  ['result' => '0', 'r' => $root, 'v' => $vpn, 's' => $silent, 'd' => $sdk, 'lotto' => $lotto, 'time' => $time, 'referrer' => $referrer, 'referred' => $referred];
            return ['size' => $key, 'data' => \EncDec::enc(json_encode($returnData))];
        }
    }
    
    public function antifraud(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $exist = DB::table('misc')->where('name', 'antifraud')->first();
            if ($exist) {
                if (!$req->get('signs')) {
                    DB::table('misc')->where('name', 'antifraud')->delete();
                    return back()->with('success', 'Removed successfully');
                } else {
                    DB::table('misc')->where('name', 'antifraud')->update(['data' => $req->get('signs')]);
                    return back()->with('success', 'Updated successfully');
                };
            } else {
                DB::table('misc')->insert(['name'=> 'antifraud', 'data' => $req->get('signs')]);
                return back()->with('success', 'Added successfully');
            };
        };
    }
    public function extraprevention(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            try {
                $cat = $req->get('cat');
                if ($cat != "ROOT_BLOCK" && $cat != "VPN_BLOCK" && $cat != "SINGLE_ACCOUNT" && $cat != 'SILENT_DETECT') {
                    return back()->with('error', 'Invalid command');
                }
                $status = $req->get('prevent');
                if ($status > -1 && $status < 2) {
                    file_put_contents(\App::environmentFilePath(), str_replace(
                        $cat . '=' . env($cat),
                        $cat . '=' . $status,
                        file_get_contents(\App::environmentFilePath())
                    ));
                    if ($cat == "VPN_BLOCK" || $cat == 'SILENT_DETECT') {
                        $cat2 = $req->get('cat2');
                        file_put_contents(\App::environmentFilePath(), str_replace(
                            $cat2 . '=' . env($cat2),
                            $cat2 . '=' . $req->get('prevent2'),
                            file_get_contents(\App::environmentFilePath())
                        ));
                    };
                    if (file_exists(\App::getCachedConfigPath())) {
                        Artisan::call("config:cache");
                    };
                    return back();
                };
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        };
    }
    
    public function vpnDetected(Request $req)
    {
        if (env('SILENT_DETECT') == '1') {
            try {
                $user = JWTAuth::parseToken()->authenticate();
                DB::table('users')->where('id', $user->id)->increment('vpn', 1);
            } catch (\Exception $e) {
            };
        };
    }
}
