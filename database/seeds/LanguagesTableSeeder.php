<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('languages')->delete();
        
		\DB::table('languages')->insert(array (
			0 => 
			array (
				'id' => '2',
				'name' => 'English',
				'created_at' => '2014-03-29 21:45:00',
				'updated_at' => '2014-03-29 21:45:00',
			),
		));
	}

}
