<?php

Route::get('/register', function () { return view('register/index'); })->name('register');

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::prefix('supervisor')->group(function () {
    Route::get('/index','SupervisorController@index');
    Route::get('/index/{id}','SupervisorController@show');
});

Route::prefix('contractor')->group(function () {
    Route::get('/index','ContractorController@index');
    Route::get('/index/{id}','ContractorController@show');
    Route::get('/occupy/{lot}','ContractorController@enter');
    Route::get('/complete/{lot}','ContractorController@finish');
    Route::get('/leave/{lot}','ContractorController@exit');
    Route::get('/clean/{lot}','ContractorController@clean');

});

Route::prefix('site')->group(function () {
    Route::get('/index','SiteController@index');
    Route::get('/index/{site}','SiteController@show');
    Route::get('/create', 'SiteController@create');
    Route::post('/create', 'SiteController@store');
    Route::get('/edit/{site}', 'SiteController@edit');
    Route::post('/edit/{site}', 'SiteController@update');
    Route::get('/apply', 'SiteController@avaliable');
    Route::get('/apply/{site}', 'SiteController@apply');
});

Route::prefix('lot')->group(function () {
    Route::get('/index','LotAssignmentsController@index');
    Route::get('/index/{lot}','LotController@show');
    Route::post('/index/{lot}','LotController@Details');
    Route::get('/remove/{j}/{l}', 'LotController@remove');
    Route::get('/create', 'LotController@create');
    Route::post('/create', 'LotController@store');
    Route::get('/edit/{lot}', 'LotController@edit');
    Route::post('/edit/{lot}', 'LotController@update');
    Route::get('/status/{lot}/{status}', 'LotController@status');

});


Route::prefix('admin')->group(function () {
    Route::get('/site','SiteApprovalController@index');
    Route::get('/lot','LotAssignmentsController@index');
    Route::post('/lot','LotAssignmentsController@store');
    Route::get('/Saccept/{approval}','SiteApprovalController@accept');
    Route::get('/Sreject/{approval}','SiteApprovalController@reject');
    Route::get('/Laccept/{approval}','LotAssignmentsController@accept');
    Route::get('/Lreject/{approval}','LotAssignmentsController@reject');
});

