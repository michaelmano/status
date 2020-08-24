<?php

Route::post('sign-in', 'Api\SignInController@destroy');

Route::post('/camera', 'Api\CameraController@store')->name('camera.store');
Route::delete('/camera', 'Api\CameraController@destroy')->name('camera.destroy');

Route::get('/employees', 'Api\EmployeeController@index')->name('employee.index');