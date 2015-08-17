<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsDefaultToMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('menus', function(Blueprint $table) {
            $table->boolean('is_default')->default(false)->after('show_image');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('menus', function(Blueprint $table) {
            $table->dropColumn('is_default');
        });
	}

}
