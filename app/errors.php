<?php

// Custom error handling for http codes
App::error(function($exception, $code) {
    Log::error($exception);
    if (App::environment() != 'local') {
        list($link_type, $link, $layout, $theme) = current_section();
        $current_user = current_user();

        if ($exception instanceof Illuminate\Database\Eloquent\ModelNotFoundException) {
            return Response::view("$link_type.$theme.404", array('title' => 'Page Not Found', 'current_user' => $current_user), 404);
        }

        switch ($code) {
            case 401:
                return Response::view("$link_type.$theme.401", array('title' => 'Unauthorized access', 'current_user' => $current_user), 401);
                break;

            case 404:
                return Response::view("$link_type.$theme.404", array('title' => 'Page Not Found', 'current_user' => $current_user), 404);
                break;

            case 503:
                return Response::view('503', array('title' => 'Site Offline', 'link_type' => $link_type, 'current_user' => $current_user), 503);
                break;

            default:
                return Response::view("$link_type.$theme.500", array('title'=>'Error', 'current_user' => $current_user), $code);
                break;
        }
    }
});
