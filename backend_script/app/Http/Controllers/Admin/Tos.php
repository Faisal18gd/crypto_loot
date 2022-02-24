<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class Tos extends Controller
{
    public static function tosedit(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $path = resource_path('views')."/terms.blade.php";
            file_put_contents($path, $req->get('tos'));
            return back()->with('success', 'Updated successfully');
        } else {
            return "Not allowed!";
        };
    }

    public function getTos(Request $req)
    {
        try {
            $path = resource_path('views')."/terms.blade.php";
            return response(file_get_contents($path), 200);
        } catch(\Exception $e){
            return response('Cannot load terms of service at this moment...', 200);
        }
    }
}
