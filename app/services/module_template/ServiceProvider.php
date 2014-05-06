<?php namespace App\Modules\Content;
/*
=================================================
Module Name     :   NameOfTheModule
Module Version  :   vVersionOfTheModule
Compatible CMS  :   v1.2
Site            :   WebsiteOfTheModule
Description     :   DescriptionOfTheModule
===================================================
*/
class ServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		// Register facades
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			// $loader->alias('Entry', 'App\Modules\Content\Facades\EntryFacade');
		});
	}

}
