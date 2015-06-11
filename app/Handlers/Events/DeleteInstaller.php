<?php namespace App\Handlers\Events;

use App;
use File;

use App\Events\InstallationWasCompleted;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class DeleteInstaller {

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  InstallationWasCompleted  $event
     * @return void
     */
    public function handle(InstallationWasCompleted $event)
    {
        // delete installation files after install
        if (App::environment() != 'local') {
            File::deleteDirectory(base_path('resources/views/install'));
            File::deleteDirectory(base_path('public/assets/shared/install'));
            File::delete(app_path('Http/controllers/InstallController.php'));
        }
    }

}
