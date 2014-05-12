<?php

$current_dir = basename(__DIR__);
$current_module = "\\" . Str::title(basename(__DIR__));

// Backend routes
Route::resource('admin/modules/'.$current_dir, 'AddCustomerBackendController');
Route::resource('backend/modules/'.$current_dir, 'AddCustomerBackendController');

