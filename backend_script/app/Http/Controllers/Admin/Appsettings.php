<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use Auth;
use DB;
use Artisan;

class Appsettings extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public static function clearcache()
    {
        if (Auth::id() == env('ADMIN')) {
            Artisan::call('cache:clear');
            return back()->with('success', 'Cache cleared');
        };
    }
    
    public static function change(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            try {
                $rq = $req->except('_token');
                foreach ($rq as $key => $val) {
                    if ($val != null) {
                        file_put_contents(\App::environmentFilePath(), str_replace(
                            $key . '=' . env($key),
                            $key . '=' . $val,
                            file_get_contents(\App::environmentFilePath())
                        ));
                    };
                };
                if (file_exists(\App::getCachedConfigPath())) {
                    Artisan::call("config:cache");
                };
                return back()->with('success', 'Settings updated');
            } catch (Exception $e) {
                return back()->with('error', 'Something wrong happened!');
            };
        } elseif (Auth::id() == '2') {
            return back()->with('error', 'Restricted for demo account!');
        } else {
            return "Not allowed!";
        };
    }
    
    public static function payoutsett(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            (new Appsettings)->validate(request(), [
                'ADC' => 'nullable|numeric|max:99',
                'PAY_PCT' => 'nullable|numeric|digits_between:1,2',
                'CHECK_IN_MIN' => 'nullable|numeric|digits_between:1,5',
                'CHECK_IN_MAX' => 'nullable|numeric|digits_between:1,5',
            ]);
            try {
                $rq = $req->except('_token');
                foreach ($rq as $key => $val) {
                    if ($val != null) {
                        file_put_contents(\App::environmentFilePath(), str_replace(
                            $key . '=' . env($key),
                            $key . '=' . $val,
                            file_get_contents(\App::environmentFilePath())
                        ));
                    };
                };
                if (file_exists(\App::getCachedConfigPath())) {
                    Artisan::call("config:cache");
                };
                return back()->with('success', 'Settings updated');
            } catch (Exception $e) {
                return back()->with('error', 'Something wrong happened!');
            };
        } else {
            return "Not allowed!";
        };
    }
    
    public static function referralsett(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            (new Appsettings)->validate(request(), [
                'PAY_TO_ENTER_REF' => 'nullable|numeric|max:100000',
                'REF_FIXED_AMOUNT' => 'nullable|numeric|max:100000'
            ]);
            try {
                $rq = $req->except('_token');
                foreach ($rq as $key => $val) {
                    if ($val != null) {
                        file_put_contents(\App::environmentFilePath(), str_replace(
                            $key . '=' . env($key),
                            $key . '=' . $val,
                            file_get_contents(\App::environmentFilePath())
                        ));
                    };
                };
                if (file_exists(\App::getCachedConfigPath())) {
                    Artisan::call("config:cache");
                };
                return back()->with('success', 'Settings updated');
            } catch (Exception $e) {
                return back()->with('error', 'Something wrong happened!');
            };
        } else {
            return "Not allowed!";
        };
    }

    public static function setmisc(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $exist = DB::table('misc')->where('name', $req->get('name'));
            $data = $req->get('data');
            if ($exist->first()) {
                if (!$data && $data != '0') {
                    $exist->delete();
                }
                $exist->update(['data' => $req->get('data')]);
                return back()->with('success', 'Updated');
            } elseif ($data || $data == '0') {
                DB::table('misc')->insert(['name' => $req->get('name'), 'data' => $req->get('data')]);
                return back()->with('success', 'Added');
            };
            return back();
        } else {
            return back()->with('error', 'Access denied!');
        }
    }

    public function setPositiveIntEnv(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $key = $req->get('key');
            $this->validate(request(), [
                'value' => 'required|numeric|min:0'
            ]);
            $val = $req->get('value');
            file_put_contents(\App::environmentFilePath(), str_replace(
                $key . '=' . env($key),
                $key . '=' . $val,
                file_get_contents(\App::environmentFilePath())
            ));
            if (file_exists(\App::getCachedConfigPath())) {
                \Artisan::call("config:cache");
            };
            return back()->with('success', 'Successfully updated');
        } else {
            return back()->with('error', 'Access denied!');
        };
    }
    
}
