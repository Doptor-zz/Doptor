<?php

use Illuminate\Database\Seeder;

class FormCategoriesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('form_categories')->delete();
        
		\DB::table('form_categories')->insert(array (
			0 => 
			array (
				'id' => '1',
				'name' => 'test',
				'description' => 'test',
				'created_at' => '2014-03-21 02:55:03',
				'updated_at' => '2014-03-21 02:55:03',
			),
		));
	}

}
