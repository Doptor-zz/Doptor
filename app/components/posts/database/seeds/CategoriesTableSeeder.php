<?php

class CategoriesTableSeeder extends \Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('categories')->delete();

		$categories = array(
            array(
                'name' => 'First Category',
                'alias' => 'first-category',
                'type' => 'post',
                'description' => 'Lorem Ipsum',
                'status' => 'published',
                'created_by' => 1,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')
            ),
            array(
                'name' => 'Another Category',
                'alias' => 'another-category',
                'type' => 'page',
                'description' => 'Lorem Ipsum',
                'status' => 'published',
                'created_by' => 1,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')
            )
		);

		// Uncomment the below to run the seeder
		DB::table('categories')->insert($categories);
	}

}
