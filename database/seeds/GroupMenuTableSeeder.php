<?php

use Illuminate\Database\Seeder;

class GroupMenuTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('group_menu')->delete();
        
		\DB::table('group_menu')->insert(array (
			0 => 
			array (
				'id' => '2',
				'group_id' => '2',
				'menu_id' => '11',
			),
			1 => 
			array (
				'id' => '3',
				'group_id' => '1',
				'menu_id' => '11',
			),
			2 => 
			array (
				'id' => '4',
				'group_id' => '1',
				'menu_id' => '33',
			),
			3 => 
			array (
				'id' => '5',
				'group_id' => '2',
				'menu_id' => '33',
			),
			4 => 
			array (
				'id' => '6',
				'group_id' => '1',
				'menu_id' => '37',
			),
			5 => 
			array (
				'id' => '7',
				'group_id' => '1',
				'menu_id' => '38',
			),
		));
	}

}
