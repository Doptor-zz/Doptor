<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRequiresToBuiltModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('built_modules', function(Blueprint $table) {
            $table->text('requires')->nullable()->after('models');
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
            $table->dropColumn('requires');
        });
	}

}
