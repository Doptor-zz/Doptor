<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsVisibleToBuiltModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('built_modules', function(Blueprint $table) {
            $table->boolean('is_visible')->default(true)->after('is_author');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('built_modules', function(Blueprint $table) {
            $table->dropColumn('is_visible');
        });
	}

}
