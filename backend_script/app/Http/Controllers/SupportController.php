<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use DB;
use Auth;

class SupportController extends Controller
{
    public function viewFaq()
    {
        $faq = DB::table('faqs')->get(['question','answer']);
        return ['faq' => $faq];
    }
    public function addFaq(Request $req)
    {
        $this->validate(request(), [
                'question' => 'required',
                'answer' => 'required',
            ]);
        if (Auth::id() == env('ADMIN')) {
            DB::table('faqs')->insert(['question' => $req->get('question'), 'answer' => $req->get('answer')]);
            return back()->with('success', 'Added successfully');
        } else {
            return back()->with('error', 'Access denied!');
        }
    }
    
    public function delFaq(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            DB::table('faqs')->where('id', $req->query('id'))->delete();
            $faqs = DB::table('faqs')->get();
            return view('admin/faq', compact('faqs'));
        } else {
            return back()->with('error', 'Access denied!');
        }
    }
}
