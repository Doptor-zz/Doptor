<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotGroupMenuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_menu', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('group_id')->unsigned()->index();
			$table->integer('menu_id')->unsigned()->index();
			$table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
			$table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_menu');
	}

}
