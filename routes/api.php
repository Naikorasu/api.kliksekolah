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
      Route::post('fund-request','OptionsController@fundRequest');
      Route::post('budget','OptionsController@budget');


    });
    //budget
    Route::group([
        'prefix' => 'budget'
    ], function () {
        Route::group([
            'prefix' => 'head'
        ],function () {
            Route::post('list','BudgetsController@list_head');
            Route::post('add','BudgetsController@add_head');
            Route::post('delete','BudgetsController@delete_head');
        });

        Route::group([
            'prefix' => 'detail'
        ],function() {
            Route::post('list/{type?}','BudgetDetailsController@list_detail');
            Route::post('rapbu','BudgetDetailsController@list_detail_rapbu');
            Route::post('add','BudgetDetailsController@add_detail');
            Route::post('edit','BudgetDetailsController@edit_detail');
            Route::post('delete','BudgetDetailsController@delete_detail');
        });

        Route::group([
            'prefix' => 'relocation'
        ],function() {
          Route::post('get', 'BudgetDetailRelocationsController@get');
          Route::post('list', 'BudgetDetailRelocationsController@list');
          Route::post('submit', 'BudgetDetailRelocationsController@submit');
          Route::post('save','BudgetDetailRelocationsController@save');
          Route::post('{status}', 'BudgetDetailRelocationsController@updateStatus')->where('status', '(approve|reject)');
        });

        Route::group([
          'prefix' => 'request'
        ], function() {
          Route::post('list', 'FundRequestsController@list');
          Route::post('get', 'FundRequestsController@get');
          Route::post('add', 'FundRequestsController@add');
          Route::post('edit', 'FundRequestsController@edit');
          Route::post('cancel', 'FundRequestsController@cancel');
          Route::post('submit', 'FundRequestsController@submit');
          Route::post('{status}', 'FundRequestsController@updateStatus')->where('status', '(approve|reject)');
        });
        Route::group([
            'prefix' => 'realization'
        ], function() {
          Route::post('list', 'BudgetRealizationsController@list');
          Route::post('get', 'BudgetRealizationsController@get');
          Route::post('delete', 'BudgetRealizationsController@delete');
          Route::post('save', 'BudgetRealizationsController@save');

        });
    });
    Route::group([
        'prefix' => 'non-budget'
    ], function() {
      Route::post('list', 'NonBudgetsController@list');
      Route::post('get', 'NonBudgetsController@get');
      Route::post('add', 'NonBudgetsController@add');
      Route::post('edit', 'NonBudgetsController@edit');
      Route::post('submit', 'NonBudgetsController@submit');
      Route::post('{status}', 'NonBudgetsController@updateStatus')->where('status', '(approve|reject)');
    });

    Route::group([
        'prefix' => 'journal'
    ], function () {
      Route::post('realization', 'JournalRealizationController@list');
      Route::post('{journalType}/save', 'JournalsController@save');
      Route::post('{journalType}/get', 'JournalsController@get');
      Route::post('{journalType}/delete', 'JournalsController@save');
      Route::post('{journalType}/list', 'JournalsController@list');
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
