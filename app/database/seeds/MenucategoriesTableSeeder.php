<?php

class MenucategoriesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('menu_categories')->truncate();

		$menu_categories = array(
            array(
                    'name' => 'Public Small Menu Left',
                    'menu_type' => 'public-small-menu-left',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ),
            array(
                    'name' => 'Public Small Menu Right',
                    'menu_type' => 'public-small-menu-right',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ),
            array(
                    'name' => 'Public Top Menu',
                    'menu_type' => 'public-top-menu',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ),
            array(
                    'name' => 'Public Bottom Menu',
                    'menu_type' => 'public-bottom-menu',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ),
            array(
                    'name' => 'Admin Top Menu',
                    'menu_type' => 'admin-top-menu',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ),
            array(
                    'name' => 'Admin Menu Menu',
                    'menu_type' => 'admin-main-menu',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ),
		);

		// Uncomment the below to run the seeder
		DB::table('menu_categories')->insert($menu_categories);
	}

}
