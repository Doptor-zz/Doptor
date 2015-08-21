<?php
/*
=================================================
Module Name     :   Slideshow
Module Version  :   v1
Compatible CMS  :   v1.2
Site            :   http://www.doptor.org
Description     :   Slideshow
===================================================
*/
Route::resource('backend/modules/slideshow',
           'Modules\Doptor\Slideshow\Controllers\Backend\SlideshowController',
            [
                'names' => [
                    'index' => 'backend.modules.doptor.slideshow.index',
                    'create' => 'backend.modules.doptor.slideshow.create',
                    'store' => 'backend.modules.doptor.slideshow.store',
                    'edit' => 'backend.modules.doptor.slideshow.edit',
                    'update' => 'backend.modules.doptor.slideshow.update',
                    'destroy' => 'backend.modules.doptor.slideshow.destroy'
                ]
            ]
    );
