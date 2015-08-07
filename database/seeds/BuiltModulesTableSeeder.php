<?php

use Illuminate\Database\Seeder;

class BuiltModulesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('built_modules')->delete();
        
		\DB::table('built_modules')->insert(array (
			0 => 
			array (
				'id' => '3',
				'name' => 'Test Module',
				'hash' => '',
				'version' => '1',
				'author' => 'Andrew',
				'website' => 'http://www.doptor.org',
				'description' => '',
				'form_id' => '8',
				'target' => 'admin',
				'file' => '/home/tngbdcom/public_html/cms/app/storage/temp/test_module.zip',
				'table_name' => 'testing_form',
				'is_author' => '1',
				'created_at' => '2014-03-22 06:20:16',
				'updated_at' => '2014-03-22 06:20:16',
				'vendor' => NULL,
			),
		));
	}

}
