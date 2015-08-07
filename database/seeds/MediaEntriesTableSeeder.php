<?php

use Illuminate\Database\Seeder;

class MediaEntriesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('media_entries')->delete();
        
		\DB::table('media_entries')->insert(array (
			0 => 
			array (
				'id' => '1',
				'caption' => '',
				'image' => 'time line11_ihA2koJj.jpg',
				'thumbnail' => 'time line11_ihA2koJj.jpg',
				'album_id' => '0',
				'created_by' => '1',
				'updated_by' => '0',
				'created_at' => '2014-03-21 01:59:09',
				'updated_at' => '2014-03-21 01:59:09',
			),
			1 => 
			array (
				'id' => '3',
				'caption' => '',
				'image' => 'Doptor Logo_UdhdA20E.png',
				'thumbnail' => 'Doptor Logo_UdhdA20E.png',
				'album_id' => '0',
				'created_by' => '3',
				'updated_by' => '0',
				'created_at' => '2014-03-23 03:32:53',
				'updated_at' => '2014-03-23 03:32:53',
			),
			2 => 
			array (
				'id' => '8',
				'caption' => NULL,
				'image' => 'doptor/Doptor Logo Black_M6Cxwm5B.png',
				'thumbnail' => 'doptor/thumbs/Doptor Logo Black_M6Cxwm5B.png',
				'album_id' => NULL,
				'created_by' => '14',
				'updated_by' => NULL,
				'created_at' => '2014-03-31 10:07:29',
				'updated_at' => '2014-03-31 10:07:29',
			),
		));
	}

}
