<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

		$this->call('FormCategoriesTableSeeder');
		$this->call('FormEntriesTableSeeder');
        $this->call('BuiltFormsTableSeeder');
        $this->call('BuiltModulesTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('CategoryPostTableSeeder');
		$this->call('GroupMenuTableSeeder');
		$this->call('MediaEntriesTableSeeder');
		$this->call('MenusTableSeeder');
		$this->call('MenuCategoriesTableSeeder');
		$this->call('PostsTableSeeder');
		$this->call('ReportGeneratorsTableSeeder');
		$this->call('SettingsTableSeeder');
		$this->call('SlideshowTableSeeder');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Model::reguard();
	}
}
