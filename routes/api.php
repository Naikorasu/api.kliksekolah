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

//development - test
Route::post('/test','TestController@index');

//no auth
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});

//middleware auth:api
Route::group([
    'middleware' => 'auth:api'
], function() {

    //auth
    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('profile', 'AuthController@profile');
    });

    //budget
    Route::group([
        'prefix' => 'budget'
    ], function () {
        Route::group([
            'prefix' => 'head'
        ],function () {
            Route::post('list','BudgetController@list_head');
            Route::post('add','BudgetController@add_head');
            Route::post('delete','BudgetController@delete_head');
        });

        /*
        Route::group([
            'prefix' => 'account'
        ],function () {
            Route::post('list','BudgetController@list_account');
            Route::post('add','BudgetController@add_account');
            Route::post('delete','BudgetController@delete_account');
        });
        */

        Route::group([
            'prefix' => 'detail'
        ],function () {
            Route::post('list','BudgetController@list_detail');
            Route::post('add','BudgetController@add_detail');
            Route::post('delete','BudgetController@delete_detail');
        });
    });

    //param
    Route::group([
        'prefix' => 'param'
    ], function() {
        Route::group([
            'prefix' => 'code'
        ], function() {
            Route::post('list','CodeAccountingController@list');
        });

    });

});



