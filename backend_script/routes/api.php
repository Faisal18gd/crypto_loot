<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['api']], function () {
    Route::post('auth/register', 'Auth\RegisterController@apicreate');
    Route::post('auth/login', 'Auth\ApiAuthController@login');
    Route::post('auth/fblogin', 'Auth\ApiAuthController@fblogin');
    Route::post('auth/glogin', 'Auth\ApiAuthController@glogin');
    Route::post('auth/login/check', 'Admin\Frauds@doCheck');
    Route::get('traffic', 'Admin\Frauds@vpnDetected');

    Route::post('withdraw', 'WithdrawController@client');
    Route::get('profile', 'ProfileController@profile');
    Route::get('balance', 'ProfileController@balance');
    Route::get('profile/checkin', 'ProfileController@checkin');
    Route::post('profile/refcode', 'ProfileController@refcod');
    Route::get('profile/adref', 'ProfileController@addref');
    Route::get('pay/type', 'WithdrawController@typeGC');
    Route::get('pay/typec', 'WithdrawController@typeCash');
    
    //Callbacks
	Route::post('cpa/fyber', 'CpaCallbackController@fyber');
	Route::get('cpa/fyber', 'CpaCallbackController@fyber');
	Route::post('cpa/pollfish', 'CpaCallbackController@pollfish');
	Route::get('cpa/pollfish', 'CpaCallbackController@pollfish');
    
    //Video Callbacks
    Route::get('cpv/adcolony', 'VideoCallbackController@adcolony');
    
    //Wheel
	Route::get('game/wheel/data', 'Admin\Wheel@gameData');
	Route::get('game/wheel/get', 'Admin\Wheel@getReward');
	Route::get('game/wheel/free', 'Admin\Wheel@getFreeChance');
	Route::get('game/wheel/purchase', 'Admin\Wheel@purchaseChance');
    
    // Scratcher
    Route::get('game/scratcher/get', 'Admin\Scratcher@getReward');
    Route::get('game/scratcher/cards', 'Admin\Scratcher@Cards');
    Route::get('game/scratcher/purchase', 'Admin\Scratcher@purchaseCard');

	//Lotto
    Route::get('game/lotto/get', 'Admin\Lotto@getReward');
    Route::get('game/lotto/history', 'Admin\Lotto@getRewardHistory');
	
	//Slot
	Route::get('game/slot/data', 'Admin\Slot@gameData');
	Route::get('game/slot/get', 'Admin\Slot@getReward');
	Route::get('game/slot/free', 'Admin\Slot@getFreeChance');
	Route::get('game/slot/purchase', 'Admin\Slot@purchaseChance');

    // Terms
    Route::get('terms', 'Admin\Tos@getTos');

    // Profile
    Route::get('profile/info', 'ProfileController@profileInfo');
    Route::post('profile/change', 'ProfileController@changesett');

    // faq
    Route::get('support/faq', 'SupportController@viewFaq');

    // History
    Route::get('history', 'HistoryController@getHistory');

    // Leaderboard
    Route::get('leaderboard', 'Admin\Leaderboard@getLeaderboard');
    Route::get('getwinnerleaderboard', 'Admin\Leaderboard@getwinnerleaderboard');
    //pass reset
    Route::post('auth/resetpass', 'Auth\PassReset@apiReset');
});
