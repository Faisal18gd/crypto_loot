<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Hash;

class Adminprofile extends Controller
{
    public function change(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $adm = User::where('id', env('ADMIN'))->first();
            if (Hash::check($req->get('passc'), $adm->password)) {
                if ($req->get('name') != '' || $req->get('name') != null) {
                    $adm->update(['name'=>$req->get('name')]);
                }
                if ($req->get('email') != '' || $req->get('email') != null) {
                    $adm->update(['email'=>$req->get('email')]);
                }
                if ($req->get('pass') != '' || $req->get('pass') != null) {
                    if ($req->get('pass') == $req->get('pass2')) {
                        if (strlen($req->get('pass'))<6) {
                            return back()->with('error', 'New password must be at least 6 characters long');
                        };
                        $adm->update(['password'=>bcrypt($req->get('pass'))]);
                    } else {
                        return back()->with('error', 'Password does not match!');
                    }
                }
                return back()->with('success', 'Admin profile updated');
            }
            return back()->with('error', 'Provide your current password!');
        } else {
            return back()->with('error', 'Access denied!');
        }
    }
    
    public static function adminID(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            (new Appsettings)->validate(request(), [
                'email' => 'nullable|email|string',
                'passc' => 'required|string'
            ]);
            $adm = User::where('id', env('ADMIN'))->first();
            if (Hash::check($req->get('passc'), $adm->password)) {
                $getid = User::where('email', $req->get('email'))->first();
                if ($getid) {
                    file_put_contents(\App::environmentFilePath(), str_replace(
                    'ADMIN='.env('ADMIN'),
                    'ADMIN='.$getid->id,
                    file_get_contents(\App::environmentFilePath())
                    ));
                    if (file_exists(\App::getCachedConfigPath())) {
                        Artisan::call("config:cache");
                    };
                    return back()->with('success', 'Settings updated');
                } else {
                    return back()->with('error', 'Email doesn not exist in database! First register an account with this email.');
                };
            } else {
                return back()->with('error', 'Wrong password!');
            };
        } else {
            return "Not allowed!";
        };
    }
}
