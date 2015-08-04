<?php
/*
=================================================
Module Name     :   Company Info
Module Version  :   v1.0
Compatible CMS  :   v1.2
Site            :   http://doptor.net
Description     :
===================================================
*/
$current_dir = Str::snake(basename(__DIR__), '_');
$routeCollection = Route::getRoutes();

/* Company Info Homepage */
Route::get('modules/'.$current_dir,
            [
                'uses' => 'Modules\Doptor\CompanyInfo\Controllers\CompanyController@index',
                'as' => 'modules.'.$current_dir
            ]
        );
Route::get('admin/modules/'.$current_dir,
            [
                'uses' => 'Modules\Doptor\CompanyInfo\Controllers\CompanyController@index',
                'as' => 'admin.modules.'.$current_dir
            ]
        );
Route::get('backend/modules/'.$current_dir,
            [
                'uses' => 'Modules\Doptor\CompanyInfo\Controllers\CompanyController@index',
                'as' => 'backend.modules.'.$current_dir
            ]
        );

/* View Branches of a company */
Route::get('modules/'.$current_dir.'/{company_id}/branches',
            [
                'uses' => 'Modules\Doptor\CompanyInfo\Controllers\CompanyBranchController@index',
                'as' => 'modules.'.$current_dir.'.companies.branches'
            ]
        );
Route::get('admin/modules/'.$current_dir.'/{company_id}/branches',
            [
                'uses' => 'Modules\Doptor\CompanyInfo\Controllers\CompanyBranchController@index',
                'as' => 'admin.modules.'.$current_dir.'.companies.branches'
            ]
        );
Route::get('backend/modules/'.$current_dir.'/{company_id}/branches',
            [
                'uses' => 'Modules\Doptor\CompanyInfo\Controllers\CompanyBranchController@index',
                'as' => 'backend.modules.'.$current_dir.'.companies.branches'
            ]
        );

/* Company Branches */
Route::resource('modules/'.$current_dir.'/branches',
                'Modules\Doptor\CompanyInfo\Controllers\CompanyBranchController');
Route::resource('admin/modules/'.$current_dir.'/branches',
                'Modules\Doptor\CompanyInfo\Controllers\CompanyBranchController');
Route::resource('backend/modules/'.$current_dir.'/branches',
                'Modules\Doptor\CompanyInfo\Controllers\CompanyBranchController');

/* Companies */
Route::resource('modules/'.$current_dir.'/companies',
                'Modules\Doptor\CompanyInfo\Controllers\CompanyController');
Route::resource('admin/modules/'.$current_dir.'/companies',
                'Modules\Doptor\CompanyInfo\Controllers\CompanyController');
Route::resource('backend/modules/'.$current_dir.'/companies',
                'Modules\Doptor\CompanyInfo\Controllers\CompanyController');

/*foreach ($routeCollection as $value) {
    // dd(get_class_methods($value));
    \Debugbar::info($value->getPath() . ' => ' . $value->getName());
}
*/
