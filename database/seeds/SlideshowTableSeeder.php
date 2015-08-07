<?php

use Illuminate\Database\Seeder;

class SlideshowTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('slideshow')->delete();

		\DB::table('slideshow')->insert(array (
			0 =>
			array (
				'id' => '5',
				'caption' => '<p>doptor</p>
',
				'image' => 'doptor profile 11.png',
				'status' => 'published',
				'publish_start' => date('Y-m-d h:i:s', time()),
				'publish_end' => date('Y-m-d h:i:s', time()),
				'created_by' => '1',
				'updated_by' => '0',
				'created_at' => '2014-03-26 13:02:28',
				'updated_at' => '2014-03-26 13:02:28',
			),
			1 =>
			array (
				'id' => '2',
				'caption' => '<p>www.doptor.org</p>
',
				'image' => 'doptor profile.png',
				'status' => 'published',
				'publish_start' => date('Y-m-d h:i:s', time()),
				'publish_end' => date('Y-m-d h:i:s', time()),
				'created_by' => '1',
				'updated_by' => '0',
				'created_at' => '2014-03-22 09:12:07',
				'updated_at' => '2014-03-23 02:44:35',
			),
			2 =>
			array (
				'id' => '4',
				'caption' => '<p>DOPTOR</p>
',
				'image' => 'doptor_banner.png',
				'status' => 'published',
				'publish_start' => date('Y-m-d h:i:s', time()),
				'publish_end' => date('Y-m-d h:i:s', time()),
				'created_by' => '1',
				'updated_by' => '0',
				'created_at' => '2014-03-26 13:00:52',
				'updated_at' => '2014-03-26 13:00:52',
			),
		));
	}

}
