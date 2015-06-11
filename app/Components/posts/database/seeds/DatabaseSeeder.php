<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		// $this->call('SentrySeeder');
		$this->call('FormCategoriesTableSeeder');
		// $this->call('MenucategoriesTableSeeder');
		// $this->call('PostsTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('ThemesTableSeeder');
	}

}
