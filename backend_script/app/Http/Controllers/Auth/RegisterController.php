<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\notification_id;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use JWTAuth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'avatar' => 'none',
            'referred_by' => 'none',
        ]);
    }
    
    
    
    protected function apicreate(Request $req)
    {
        $vdata = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        if ($vdata->fails()) {
            foreach ($vdata->errors()->all() as $message) {
                return response($message, 400);
            }
        } else {
            $did = $req->json('did') ? $req->json('did') : 'none';
            try {
                $email = $req->json('email');
                $uinfo = str_replace(["}","{",", "], ["","","<br>"], $req->json('data'));
                $infos = notification_id::where('email', $email)->first();
                if ($infos) {
                    $infos->update(['device_token' => $did, 'userinfo' => $uinfo]);
                } else {
                    notification_id::create(['email' => $email, 'device_token' => $did, 'userinfo' => $uinfo]);
                };
                $refid = strtoupper(uniqid());
                if (env('SINGLE_ACCOUNT') == '1') {
                    $schk = $req->json('aid');
                    if ($schk == null || $schk == '') {
                        return response('Security check failed', 400);
                    }
                    \DB::table('aid')->insert(['user' => $refid, 'aid' => $schk]);
                };
                $user = User::create([
                        'name' => $req->json('name'),
                        'ip' => \Request::ip(),
						//'ip' => "127.0.0.1",
                        'email' => $email,
                        'password' => bcrypt($req->json('password')),
                        'avatar' => 'none',
                        'referred_by' => 'none',
                        'refid' => $refid,
                        'country' => $req->json('cc')
                    ]);
                //\AIndex::addref($user, $req->json('ref'));
                \AIndex::addFreeCards($user->refid);
                $token = JWTAuth::fromUser($user);
                return ['data' => \EncDec::enc(json_encode([
                        'response' => 'success',
                        'progress' => 0,
                        'user' => $user->refid,
                        'result' => ['token' => $token]
                    ]))];
            } catch (\Exception $e) {
                return response('Registration failed! This could be due to one of several reasons. Such as attempting to create multiple accounts or you are using outdated version of this app', 400);
            }
        };
    }
}
