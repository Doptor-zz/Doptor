<?php

use Illuminate\Database\Seeder;

class CategoryPostTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('category_post')->delete();
        
		\DB::table('category_post')->insert(array (
			0 => 
			array (
				'id' => '1',
				'category_id' => '1',
				'post_id' => '1',
			),
			1 => 
			array (
				'id' => '2',
				'category_id' => '1',
				'post_id' => '2',
			),
			2 => 
			array (
				'id' => '3',
				'category_id' => '1',
				'post_id' => '3',
			),
			3 => 
			array (
				'id' => '4',
				'category_id' => '1',
				'post_id' => '4',
			),
			4 => 
			array (
				'id' => '5',
				'category_id' => '1',
				'post_id' => '5',
			),
			5 => 
			array (
				'id' => '6',
				'category_id' => '1',
				'post_id' => '7',
			),
			6 => 
			array (
				'id' => '7',
				'category_id' => '1',
				'post_id' => '8',
			),
			7 => 
			array (
				'id' => '8',
				'category_id' => '3',
				'post_id' => '13',
			),
		));
	}

}
