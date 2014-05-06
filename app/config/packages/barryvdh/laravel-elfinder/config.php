<?php

$disabled = array();
if (!current_user()->hasAccess('media-manager.edit')) {
    array_push($disabled, array('rename'));
}
if (!current_user()->hasAccess('media-manager.destroy')) {
    array_push($disabled, array('delete', 'rm', 'duplicate', 'resize', 'cut', 'copy'));
}
$disabled = array_flatten($disabled);

return array(

    /*
    |--------------------------------------------------------------------------
    | Upload dir
    |--------------------------------------------------------------------------
    |
    | The dir where to store the images (relative from public)
    |
    */

    'dir' => 'uploads',

    /*
    |--------------------------------------------------------------------------
    | Access filter
    |--------------------------------------------------------------------------
    |
    | Filter callback to check the files
    |
    */

    'access' => 'access',

    /*
    |--------------------------------------------------------------------------
    | Roots
    |--------------------------------------------------------------------------
    |
    | By default, the roots file is LocalFileSystem, with the above public dir.
    | If you want custom options, you can set your own roots below.
    |
    */

    'disabled' => $disabled,

    'roots'  => null

);
