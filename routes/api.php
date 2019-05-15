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

    Route::group([
      'prefix' => 'options'
    ], function() {

      Route::post('code-of-account/{type?}','OptionsController@code_of_account');
      Route::post('periode/{type?}','OptionsController@periode');

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

        Route::group([
            'prefix' => 'detail'
        ],function() {
            Route::post('list/{type?}','BudgetDetailController@list_detail');
            Route::post('rapbu','BudgetDetailController@list_detail_rapbu');
            Route::post('add','BudgetDetailController@add_detail');
            Route::post('edit','BudgetDetailController@edit_detail');
            Route::post('delete','BudgetDetailController@delete_detail');
        });

        Route::group([
            'prefix' => 'relocation'
        ],function() {
          Route::post('save','BudgetDetailRelocationController@save');
        });

        Route::group([
          'prefix' => 'request'
        ], function() {
          Route::post('list', 'FundRequestController@list');
          Route::post('get', 'FundRequestController@get');
          Route::post('add', 'FundRequestController@add');
          Route::post('edit', 'FundRequestController@edit');
          Route::post('cancel', 'FundRequestController@cancel');
          Route::post('submit', 'FundRequestController@submit');
          Route::post('{status}', 'FundRequestController@updateStatus')->where('status', '(approve|reject)');
        });
        Route::group([
            'prefix' => 'realization'
        ], function() {
          Route::post('list', 'BudgetRealizationController@list');
          Route::post('get', 'BudgetRealizationController@get');
          Route::post('add', 'BudgetRealizationController@add');
        });
    });
    Route::group([
        'prefix' => 'non-budget'
    ], function() {
      Route::post('list', 'NonBudgetController@list');
      Route::post('get', 'NonBudgetController@get');
      Route::post('add', 'NonBudgetController@add');
      Route::post('edit', 'NonBudgetController@edit');
      Route::post('submit', 'NonBudgetController@submit');
      Route::post('update-status', 'NonBudgetController@updateStatus');
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

    Route::group([
      'prefix' => 'file'
    ], function() {
      Route::post('upload', 'FileUploadController@upload');
    });

});
