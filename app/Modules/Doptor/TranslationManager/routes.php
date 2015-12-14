<?php
/*
=================================================
Module Name     :   TranslationManager
Module Version  :   v1
Compatible CMS  :   v1.2
Site            :   http://www.doptor.org
Description     :   TranslationManager
===================================================
*/

Route::get('backend/modules/translation_manager/install',
           [
                'uses' => 'Modules\Doptor\TranslationManager\Controllers\Backend\LanguageManagerController@getInstall',
                'as' => 'backend.modules.doptor.translation_manager.languages.get_install'
           ]
       );
Route::post('backend/modules/translation_manager/install',
           [
                'uses' => 'Modules\Doptor\TranslationManager\Controllers\Backend\LanguageManagerController@postInstall',
                'as' => 'backend.modules.doptor.translation_manager.languages.post_install'
           ]
       );
Route::resource('backend/modules/translation_manager',
           'Modules\Doptor\TranslationManager\Controllers\Backend\LanguageManagerController',
            [
                'names' => [
                    'index' => 'backend.modules.doptor.translation_manager.languages.index',
                    'create' => 'backend.modules.doptor.translation_manager.languages.create',
                    'store' => 'backend.modules.doptor.translation_manager.languages.store',
                    'edit' => 'backend.modules.doptor.translation_manager.languages.edit',
                    'update' => 'backend.modules.doptor.translation_manager.languages.update',
                    'destroy' => 'backend.modules.doptor.translation_manager.languages.destroy'
                ]
            ]
    );
Route::get('backend/modules/translation_manager/export/{language_id}',
           [
                'uses' => 'Modules\Doptor\TranslationManager\Controllers\Backend\LanguageManagerController@export',
                'as' => 'backend.modules.doptor.translation_manager.export'
           ]
       );
Route::get('backend/modules/translation_manager/translate/{language_id}',
           [
                'uses' => 'Modules\Doptor\TranslationManager\Controllers\Backend\TranslationManagerController@index',
                'as' => 'backend.modules.doptor.translation_manager.index'
           ]
       );
Route::get('backend/modules/translation_manager/translate/{language_id}/manage/{group_id}',
           [
                'uses' => 'Modules\Doptor\TranslationManager\Controllers\Backend\TranslationManagerController@getManage',
                'as' => 'backend.modules.doptor.translation_manager.get_manage'
           ]
       );
Route::post('backend/modules/translation_manager/translate/{language_id}/manage/{group_id}',
           [
                'uses' => 'Modules\Doptor\TranslationManager\Controllers\Backend\TranslationManagerController@postManage',
                'as' => 'backend.modules.doptor.translation_manager.post_manage'
           ]
       );
