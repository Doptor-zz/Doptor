<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('settings')->delete();

		\DB::table('settings')->insert(array (
			0 =>
			array (
				'id' => '1',
				'name' => 'website_name',
				'description' => '',
				'value' => 'Doptor CMS',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			1 =>
			array (
				'id' => '2',
				'name' => 'footer_text',
				'description' => '',
				'value' => 'Powered by : Doptor v1.2, Copyright @ 2011-2015',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			2 =>
			array (
				'id' => '3',
				'name' => 'public_offline',
				'description' => '',
				'value' => 'no',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			3 =>
			array (
				'id' => '4',
				'name' => 'public_offline_end',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			4 =>
			array (
				'id' => '5',
				'name' => 'admin_offline',
				'description' => '',
				'value' => 'no',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			5 =>
			array (
				'id' => '6',
				'name' => 'admin_offline_end',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			6 =>
			array (
				'id' => '7',
				'name' => 'backend_offline',
				'description' => '',
				'value' => 'no',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			7 =>
			array (
				'id' => '8',
				'name' => 'backend_offline_end',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			8 =>
			array (
				'id' => '9',
				'name' => 'offline_message',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			9 =>
			array (
				'id' => '10',
				'name' => 'email_host',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			10 =>
			array (
				'id' => '11',
				'name' => 'email_port',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			11 =>
			array (
				'id' => '12',
				'name' => 'email_encryption',
				'description' => '',
				'value' => 'false',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			12 =>
			array (
				'id' => '13',
				'name' => 'email_username',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			13 =>
			array (
				'id' => '14',
				'name' => 'email_password',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			14 =>
			array (
				'id' => '15',
				'name' => 'mysqldump_path',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			15 =>
			array (
				'id' => '16',
				'name' => 'backend_theme',
				'description' => '',
				'value' => '3',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			16 =>
			array (
				'id' => '17',
				'name' => 'admin_theme',
				'description' => '',
				'value' => '2',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			17 =>
			array (
				'id' => '18',
				'name' => 'public_theme',
				'description' => '',
				'value' => '1',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			18 =>
			array (
				'id' => '19',
				'name' => 'website_logo',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			19 =>
			array (
				'id' => '20',
				'name' => 'facebook_link',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			20 =>
			array (
				'id' => '21',
				'name' => 'twitter_link',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			21 =>
			array (
				'id' => '22',
				'name' => 'gplus_link',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			22 =>
			array (
				'id' => '23',
				'name' => 'company_name',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			23 =>
			array (
				'id' => '24',
				'name' => 'company_address',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			24 =>
			array (
				'id' => '25',
				'name' => 'company_contact',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			25 =>
			array (
				'id' => '26',
				'name' => 'disabled_ips',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
			26 =>
			array (
				'id' => '27',
				'name' => 'auto_logout_time',
				'description' => '',
				'value' => '',
				'created_at' => date('Y-m-d h:i:s', time()),
				'updated_at' => date('Y-m-d h:i:s', time()),
			),
		));
	}

}
