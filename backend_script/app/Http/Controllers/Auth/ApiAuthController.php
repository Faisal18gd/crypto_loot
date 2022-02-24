<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use JWTAuth;
use Auth;
use JWTAuthException;
use App\User;
use App\notification_id;

class ApiAuthController extends Controller
{
    public function fblogin(Request $request)
    {
        try {
            $tok = $request->json('fbtoken');
            $fburl = 'https://graph.facebook.com/v2.12/me?fields=id,name,email,picture&access_token='.$tok;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $fburl);
            $result = curl_exec($ch);
            curl_close($ch);
            $infos = json_decode($result);  //id, name, email, picture->url
            $avatar = $infos->picture->data->url;
            if (!$infos) {
                return response('Error', 400);
            }
            $refidf = 'F'.substr($infos->id, -12);
            $getuser = User::where('refid', $refidf)->first();
            if ($getuser === null) {
                if (env('SINGLE_ACCOUNT') == '1') {
                    $schk = $request->json('aid');
                    if ($schk == null || $schk == '') {
                        return response('Security check failed', 400);
                    }
                    \DB::table('aid')->insert(['user' => $refid, 'aid' => $schk]);
                };
				if(isset($infos->email)){
					$e = $infos->email;
				} else {
					$e = $refidf.'@nullemail.tld';
				};
                $users = User::create([
                    'name' => $infos->name,
                    'email' => $e,
                    'password' => bcrypt('facebookdoesnotneedanypassword123'),
                    'avatar' => $avatar,
                    'referred_by' => 'none',
                    'refid' => $refidf,
                    'country' => $request->json('cc')
                ]);
                \AIndex::addref($users, $request->json('ref'));
                \AIndex::addFreeCards($refidf);
                notification_id::create([
                    'email' => $infos->email,
                    'device_token' => $request->json('did'),
                ]);
                $jtoken = JWTAuth::fromUser($users);
                return ['data' => \EncDec::enc(json_encode([
                    'response' => 'success',
                    'user' => $users->refid,
                    'progress' => 0,
                    'result' => ['token' => $jtoken]
                ]))];
            } else {
                $jwt = JWTAuth::fromUser($getuser);
                if ($getuser->banned == 'yes') {
                    return response('banned');
                }
                if ($getuser->email != $infos->email) {
                    $getuser->update(['email' => $infos->email]);
                }
                if ($request->exists('did')) {
                    $usr = notification_id::where('email', $infos->email)->first();
                    if ($usr) {
                        $usr->update(['device_token' => $request->json('did')]);
                    } else {
                        notification_id::create(['email' => $infos->email, 'device_token' => $request->json('did')]);
                    };
                }
                return ['data' => \EncDec::enc(json_encode(['user' => $getuser->refid, 'progress' => $getuser->progress, 'result' => ['token' => $jwt]]))];
            }
        } catch (Excaption $e) {
            return response('Cannot login', 400);
        }
    }
    
    public function glogin(Request $request)
    {
        try {
            $gotok = $request->json('gtoken');
            $gourl = 'https://www.googleapis.com/oauth2/v3/tokeninfo?id_token='.$gotok;
            $goch = curl_init();
            curl_setopt($goch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($goch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($goch, CURLOPT_URL, $gourl);
            $goresult = curl_exec($goch);
            curl_close($goch);
            $goinfos = json_decode($goresult);  //id, name, email, picture->url
            if (!$goinfos) {
                return response('Error', 400);
            }
            
            $gorefid = 'G'.substr($goinfos->sub, -12);
            $gouser = User::where('refid', $gorefid)->first();
            if ($gouser === null) {
                if (env('SINGLE_ACCOUNT') == '1') {
                    $schk = $request->json('aid');
                    if ($schk == null || $schk == '') {
                        return response('Security check failed', 400);
                    }
                    \DB::table('aid')->insert(['user' => $refid, 'aid' => $schk]);
                };
                $guser = User::create([
                    'name' => $goinfos->given_name.' '.$goinfos->family_name,
                    'email' => $goinfos->email,
                    'password' => bcrypt('googdoesnotneedanypassword123'),
                    'avatar' => $goinfos->picture,
                    'referred_by' => 'none',
                    'refid' => $gorefid,
                    'country' => $request->json('cc')
                ]);
                \AIndex::addref($guser, $request->json('ref'));
                \AIndex::addFreeCards($gorefid);
                notification_id::create([
                    'email' => $goinfos->email,
                    'device_token' => $request->json('did'),
                ]);
                $gtoken = JWTAuth::fromUser($guser);
                return ['data' => \EncDec::enc(json_encode([
                    'response' => 'success',
                    'user' => $guser->refid,
                    'progress' => 0,
                    'result' => ['token' => $gtoken]
                ]))];
            } else {
                $gjwt = JWTAuth::fromUser($gouser);
                if ($gouser->banned == 'yes') {
                    return response('banned');
                }
                if ($gouser->email != $goinfos->email) {
                    $gouser->update(['email' => $goinfos->email]);
                }
                if ($request->exists('did')) {
                    $gusr = notification_id::where('email', $goinfos->email)->first();
                    if ($gusr) {
                        $gusr->update(['device_token' => $request->json('did')]);
                    } else {
                        notification_id::create(['email' => $goinfos->email, 'device_token' => $request->json('did')]);
                    };
                }
                return ['data' => \EncDec::enc(json_encode(['user' => $gouser->refid, 'progress' => $gouser->progress,'result' => ['token' => $gjwt]]))];
            }
        } catch (Excaption $ge) {
            return response('Cannot login', 400);
        }
    }
    
    public function __construct()
    {
        $this->user = new User;
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $jwt = '';

        try {
            if (!$jwt = JWTAuth::attempt($credentials)) {
                return ['data' => \EncDec::enc(json_encode(['error' => 'invalid credentials']))];
            }
        } catch (JWTAuthException $e) {
            return ['data' => \EncDec::enc(json_encode(['error' => 'failed to create token']))];
        }
        
        if (Auth::user()->banned) {
            return response('banned');
        }
        
        if ($request->exists('did')) {
            $nusr = notification_id::where('email', Auth::user()->email)->first();
            if ($nusr) {
                $nusr->update(['device_token' => $request->json('did')]);
            } else {
                notification_id::create(['email' => Auth::user()->email, 'device_token' => $request->json('did')]);
            };
        }
        return ['data' => \EncDec::enc(json_encode(['user' => Auth::user()->refid, 'progress' => Auth::user()->progress, 'result' => ['token' => $jwt]]))];
    }

    public function getAuthUser(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        return ['data' => \EncDec::enc(json_encode(['result' => $user]))];
    }
}