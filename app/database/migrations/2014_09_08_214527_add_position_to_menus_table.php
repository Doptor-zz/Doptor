<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPositionToMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('menus', function(Blueprint $table) {
			$table->integer('position')->after('category')->unsigned();

			$table->foreign('position')->references('id')->on('menu_positions');
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
			$table->dropColumn('position');

			$table->dropForeign('menus_position_foreign');
		});
	}

}
