<?php

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('modules')->delete();
        
		\DB::table('modules')->insert(array (
			0 => 
			array (
				'id' => '10',
				'name' => 'Add Customer',
				'hash' => '',
				'alias' => 'add_customer',
				'table' => 'add_customer',
				'version' => '0.1',
				'author' => 'Doptor',
				'website' => 'http://www.tngbd.com',
				'description' => '',
				'target' => 'admin|backend',
				'links' => NULL,
				'migrations' => NULL,
				'enabled' => '1',
				'created_at' => '2014-03-24 13:10:44',
				'updated_at' => '2014-03-24 13:10:44',
				'vendor' => NULL,
			),
		));
	}

}
