<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('/test','TestController@index');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('profile', 'AuthController@profile');
    });
});


Route::group([
    'prefix' => 'budget'
], function () {
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::group([
            'prefix' => 'head'
        ],function () {
            Route::post('list','BudgetController@list_header');
            Route::post('add','BudgetController@add_header');
            Route::post('delete','BudgetController@delete_header');
        });

        Route::group([
            'prefix' => 'detail'
        ],function () {
            Route::post('data','BudgetController@data_detail');
            Route::post('add','BudgetController@add_detail');
            Route::post('delete','BudgetController@delete_detail');
        });
    });
});


Route::group([
    'prefix' => 'param'
], function() {

    Route::group([
        'prefix' => 'code'
    ], function() {
        Route::post('list','CodeAccountingController@list');

    });

    /*
    Route::group([
        'middleware' => 'auth:api'
    ], function() {

    });
    */

});

