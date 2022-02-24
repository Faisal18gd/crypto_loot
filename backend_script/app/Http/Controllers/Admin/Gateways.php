<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Cache;
use Auth;
use DB;

class Gateways extends Controller
{
    public function createGC(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $this->validate(request(), [
                'name' => 'string|required',
                'descr' => 'string|required',
                'points' => 'required|numeric',
                'image' => 'required|mimes:jpeg,jpg,png|max:1000',
                'country' => 'nullable|max:2'
            ]);
            $ctry = strtolower($req->get('country')) ?: 'all';
            $filename = time().'.'.$req->file('image')->getClientOriginalExtension();
            $req->file('image')->move(public_path('uploads'), $filename);
            DB::table('reward_type')->insert([
                'name' => $req->get('name'), 
                'image_link' => env('APP_URL').'/uploads/'.$filename, 
                'points' => $req->get('points'), 
                'descr' => $req->get('descr'), 
                'country' => $ctry,
                'is_coin' => 0
                ]);
            return back()->with('success', 'Added successfully');
        } else {
            return back()->with('error', 'Access denied!');
        }
    }
    
    public function deletesGC(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            DB::table('reward_type')->where('id', $req->query('id'))->delete();
            $gatew = DB::table('reward_type')->get();
            return back()->with('success', 'Successfully deleted');
        } else {
            return back()->with('error', 'Access denied!');
        }
    }
        
    public function createCash(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $this->validate(request(), [
                'name' => 'string|required',
                'descr' => 'string|required',
                'points' => 'required|numeric',
                'image' => 'required|mimes:jpeg,jpg,png|max:1000',
                'country' => 'nullable|max:2'
            ]);
            $ctry = strtolower($req->get('country')) ?: 'all';
            $filename = time().'.'.$req->file('image')->getClientOriginalExtension();
            $req->file('image')->move(public_path('uploads'), $filename);
            DB::table('reward_type')->insert([
                'name' => $req->get('name'), 
                'image_link' => env('APP_URL').'/uploads/'.$filename, 
                'points' => $req->get('points'), 
                'descr' => $req->get('descr'), 
                'country' => $ctry,
                'is_coin' => 1
                ]);
            return back()->with('success', 'Added successfully');
        } else {
            return back()->with('error', 'Access denied!');
        }
    }
    
    public function deletesCash(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            DB::table('cashout_type')->where('id', $req->query('id'))->delete();
            $gatew = DB::table('cashout_type')->get();
            return back()->with('success', 'Successfully deleted');
        } else {
            return back()->with('error', 'Access denied!');
        }
    }
}
