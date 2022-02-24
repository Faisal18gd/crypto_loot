<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class Offerwall extends Controller
{
    public function updateApi(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $type = $req->get('offerwall');
            $secrectname = $req->get('secretname');
            $secrectval = $req->get('secret');
            if ($secrectval != null) {
                \AIndex::setmisc($secrectname, $secrectval);
            }
            return back()->with('success', 'Successfully updated');
        } else {
            return back()->with('error', 'Access denied!');
        }
    }

    

    public function adminView(Request $req)
    {
        if (Auth::id() == env('ADMIN')) {
            $fyber_secret = \AIndex::getmisc('fyber_secret');
            $fyber_data = [
                'img' => '/img/fyber.png',
                'offerwall' => 'sdk',
                'secretname' => 'fyber_secret',
                'secret' => $fyber_secret,
                'postback' => $fyber_secret == '' ? '<i>Enter any alphanumeric secret code before unlocking postback url</i>' : env('APP_URL') . '/api/cpa/fyber?tok=' . $fyber_secret
            ];
			$pollfish_secret = \AIndex::getmisc('pollfish_secret');
            $pollfish_data = [
                'img' => 'Pollfish',
                'offerwall' => 'sdk',
                'secretname' => 'pollfish_secret',
                'secret' => $pollfish_secret,
                'postback' => $pollfish_secret == '' ? '<i>Enter any alphanumeric secret code before unlocking postback url</i>' : env('APP_URL') . '/api/cpa/pollfish?tok=' . $pollfish_secret
                    . '&userid=[[request_uuid]]&amount=[[cpa]]&event=[[tx_id]]&status=[[status]]'
            ];
            $data = ['fyber' => $fyber_data, 'pollfish' => $pollfish_data];
            return view('admin/offerwall', compact('data'));
        } else {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
    }
}
