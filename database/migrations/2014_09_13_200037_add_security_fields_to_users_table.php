<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSecurityFieldsToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->text('security_answer')->after('photo')->nullable();
			$table->text('security_question')->after('photo')->nullable();
			$table->dateTime('last_pw_changed')->after('last_login');
			$table->integer('auto_logout_time')->after('security_answer')->unsigned()->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('security_question');
			$table->dropColumn('security_answer');
			$table->dropColumn('last_pw_changed');
			$table->dropColumn('auto_logout_time');
		});
	}

}
