<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 3/23/2019
 * Time: 11:05 PM
 */
Route::group(['namespace'=>'Fordav3\Seat\Payout\Http\Controllers',
        'prefix'=>'payout'
        ], function() {
        Route::group([
            'middleware' => ['web','auth'],
        ], function () {
           Route::get('/', [
               'as' => 'payout.view',
               'uses' => 'PayoutController@getPayoutView',
               'middleware' => 'bouncer:payout.view'
           ]);
            Route::post('/savePayout', [
                'as' => 'payout.savePayout',
                'uses' => 'PayoutController@buildPayoutTable',
                'middleware' => 'bouncer:payout.request'
            ]);
        });

});

