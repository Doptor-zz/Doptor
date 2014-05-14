<?php

// Delete all the installation files
Event::listen('installer.delete', function() {
    if (app()->environment() != 'local') {
        File::deleteDirectory('app/views/install');
        File::deleteDirectory('assets/shared/install');
        File::delete('app/controllers/InstallController.php');
    }
});