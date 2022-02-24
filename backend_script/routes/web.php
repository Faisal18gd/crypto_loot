<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('api/tos', function () {
    return view('terms');
});

Auth::routes();
Route::get('/register', 'HomeController@regs');
Route::post('/register', 'HomeController@regs');
Route::get('members/index', 'HomeController@index')->name('home');
Route::get('members/notifications', 'HomeController@notif');
Route::get('members/users', 'HomeController@users');
Route::get('members/withdrawals', 'HomeController@withd');
Route::get('members/paysettings', 'HomeController@psett');
Route::get('members/appsettings', 'HomeController@appsett');
Route::get('members/admins', 'HomeController@adminprof');
Route::get('members/whistory', 'HomeController@wdhist');
Route::get('members/ehistory', 'HomeController@erhist');
Route::get('members/frauds', 'HomeController@frauds');
Route::get('members/terms', 'HomeController@terms');
Route::get('members/leaderboard', 'Admin\Leaderboard@adminView');

Route::get('admin/chart', 'Admin\Index@chart');
Route::get('admin/snotif', 'Admin\Notification@sendnotif');
Route::get('admin/smemb', 'Admin\Members@membersearch');
Route::get('admin/ban', 'Admin\Members@memberban');
Route::get('admin/mailchk', 'Admin\Withdraw@mailcheck');
Route::get('admin/wprocessed', 'Admin\Withdraw@wdprocessed');
Route::get('admin/url', 'Admin\Withdraw@url');
Route::post('admin/aprof', 'Admin\Adminprofile@change');
Route::get('admin/antifraud', 'Admin\Frauds@antifraud');
Route::get('admin/prevent', 'Admin\Frauds@extraprevention');
Route::get('admin/addtos', 'Admin\Tos@tosedit');
Route::get('admin/reward', 'Admin\Members@reward');
Route::get('admin/penalty', 'Admin\Members@penalty');
Route::get('config/setint', 'Admin\Index@setEnvInt');

//SITE & APP settings link
Route::get('admin/apsett', 'Admin\Appsettings@change');
Route::get('admin/payoutsett', 'Admin\Appsettings@payoutsett');
Route::get('admin/refsett', 'Admin\Appsettings@referralsett');
Route::post('admin/adminid', 'Admin\Adminprofile@adminID');
Route::get('admin/rcache', 'Admin\Appsettings@clearcache');
Route::get('admin/setmisc', 'Admin\Appsettings@setmisc');

//Wheel
Route::get('members/spinwheel', 'HomeController@gameWheel');
Route::get('game/wheel/type', 'Admin\Wheel@setRewardType');
Route::get('game/wheel/setmaxspin', 'Admin\Wheel@setMaxSpin');
Route::get('game/wheel/setprice', 'Admin\Wheel@setPrice');
Route::get('game/wheel/setdata', 'Admin\Wheel@setGameData');
Route::get('game/wheel/deldata', 'Admin\Wheel@delGameData');

//Scratcher
Route::get('members/scratcher', 'HomeController@gameScratcher');
Route::post('admin/addscratchcard', 'Admin\Scratcher@addCard');
Route::get('admin/editscratchcard', 'Admin\Scratcher@editCard');
Route::post('admin/updatescratchcard', 'Admin\Scratcher@updateCard');
Route::get('admin/delscratchcard', 'Admin\Scratcher@delCard');
Route::get('game/scratcher/setwinner', 'Admin\Scratcher@addWinner');
Route::get('game/scratcher/delwinner', 'Admin\Scratcher@delWinner');

//Lotto
Route::get('members/lotto', 'HomeController@gameLotto');
Route::get('game/lotto/setwinner', 'Admin\Lotto@addWinner');
Route::get('game/lotto/delwinner', 'Admin\Lotto@delWinner');
Route::get('game/lotto/showemail', 'Admin\Lotto@showEmail');

//Slot
Route::get('members/slot', 'Admin\Slot@gameSlot');

// Support
Route::get('members/faq', 'HomeController@faq');
Route::get('admin/delfaq', 'SupportController@delFaq');
Route::get('admin/addfaq', 'SupportController@addFaq');

// Withdrawals
Route::get('members/gcreward', 'HomeController@gcreward');
Route::post('admin/ngateway', 'Admin\Gateways@createGC');
Route::get('admin/delgateway', 'Admin\Gateways@deletesGC');
Route::get('members/cashreward', 'HomeController@cashreward');
Route::post('admin/ngatewayc', 'Admin\Gateways@createCash');
Route::get('admin/delgatewayc', 'Admin\Gateways@deletesCash');

// Online
Route::get('admin/resetonline', 'Admin\Index@resetOnline');

// Offerwall
Route::get('members/offerwalls', 'Admin\Offerwall@adminView');
Route::get('admin/updateapi', 'Admin\Offerwall@updateApi');

//memberinfo
Route::get('admin/action', 'Admin\Members@action');

//User reward on ref code enter
Route::get('admin/seturefrwd', 'Admin\Appsettings@setPositiveIntEnv');

// pass reset
Route::get('login/resetpass', 'Auth\PassReset@view');
Route::post('login/doreset', 'Auth\PassReset@reset');
Route::get('login/reset/{dta?}', 'Auth\PassReset@makeReset')->where('dta', '(.*)');