<?php

Route::get('/', 'Home\HomeController@index')->name('index');
Route::post('/', 'Home\HomeController@store')->name('store');

Auth::routes();

Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
], function () {
    Route::name('admin.')->group(function () {
        Route::get('/', 'AdminController@index')->name('index');
        Route::post('/status', 'StatusController@destroy')->name('status.destroy');
        Route::post('/employee/store', 'EmployeeController@store')->name('employee.store');
        Route::post('/employee/destroy/{employee}', 'EmployeeController@destroy')->name('employee.destroy');
    });
});
