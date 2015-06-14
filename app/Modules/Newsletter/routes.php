<?php

Route::resource('backend/modules/newsletters/subscribers', 'Modules\Newsletter\Controllers\Backend\SubscriberController');
Route::resource('backend/modules/newsletters', 'Modules\Newsletter\Controllers\Backend\NewsletterController');

Route::resource('admin/modules/newsletters/subscribers', 'Modules\Newsletter\Controllers\Backend\SubscriberController');
Route::resource('admin/modules/newsletters', 'Modules\Newsletter\Controllers\Backend\NewsletterController');


