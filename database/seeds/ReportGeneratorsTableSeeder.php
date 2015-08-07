<?php

use Illuminate\Database\Seeder;

class ReportGeneratorsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('report_generators')->delete();
        
	}

}
