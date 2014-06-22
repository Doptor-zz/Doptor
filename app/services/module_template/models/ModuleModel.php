<?php namespace Modules\ModuleName\Models;
/*
=================================================
Module Name     :   NameOfTheModule
Module Version  :   vVersionOfTheModule
Compatible CMS  :   v1.2
Site            :   WebsiteOfTheModule
Description     :   DescriptionOfTheModule
===================================================
*/
use Eloquent;

class ModuleModel extends Eloquent {

	protected $table = 'module_entries';

	protected $fillable = array(table_fields);
	protected $guarded = array();


}
