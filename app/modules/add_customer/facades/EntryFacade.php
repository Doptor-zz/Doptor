<?php namespace App\Modules\Add_Customer\Facades;

use Illuminate\Support\Facades\Facade;

class EntryFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return new \App\Modules\Content\Models\Entry; }

}
