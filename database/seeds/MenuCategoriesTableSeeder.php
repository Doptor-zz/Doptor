<?php

use Illuminate\Database\Seeder;

class MenuCategoriesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('menu_categories')->delete();

		\DB::table('menu_categories')->insert(array (
			0 =>
			array (
				'id' => '1',
				'name' => 'Onepage Top',
				'alias' => 'onepage-top',
				'position' => '1',
				'description' => '',
				'created_at' => '2014-10-01 23:08:19',
				'updated_at' => '2014-10-01 23:08:19',
			),
			1 =>
			array (
				'id' => '2',
				'name' => 'Onepage Bottom',
				'alias' => 'onepage-bottom',
				'position' => '2',
				'description' => '',
				'created_at' => '2014-10-01 23:08:28',
				'updated_at' => '2014-10-01 23:08:28',
			),
			2 =>
			array (
				'id' => '3',
				'name' => 'Multiplepage Top',
				'alias' => 'multiplepage-top',
				'position' => '1',
				'description' => '',
				'created_at' => '2014-10-01 23:08:40',
				'updated_at' => '2014-10-01 23:08:40',
			),
			3 =>
			array (
				'id' => '4',
				'name' => 'Multiplepage Bottom',
				'alias' => 'multiplepage-bottom',
				'position' => '2',
				'description' => '',
				'created_at' => '2014-10-01 23:08:50',
				'updated_at' => '2014-10-01 23:08:50',
			),
		));
	}

}
