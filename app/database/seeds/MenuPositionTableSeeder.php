<?php

class MenuPositionTableSeeder extends Seeder {

	public function run()
	{
		$menu_positions = array(
            array(
                    'name'       => 'Public Top Menu',
                    'alias'      => 'public-top-menu',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ),
            array(
                    'name'       => 'Public Bottom Menu',
                    'alias'      => 'public-bottom-menu',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ),
            array(
                    'name'       => 'Public Small Menu Left',
                    'alias'      => 'public-small-menu-left',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ),
            array(
                    'name'       => 'Public Small Menu Right',
                    'alias'      => 'public-small-menu-right',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ),
            array(
                    'name'       => 'Admin Top Menu',
                    'alias'      => 'admin-top-menu',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ),
            array(
                    'name'       => 'Admin Menu Menu',
                    'alias'      => 'admin-main-menu',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ),
        );

        // Uncomment the below to run the seeder
        DB::table('menu_positions')->insert($menu_positions);
	}

}
