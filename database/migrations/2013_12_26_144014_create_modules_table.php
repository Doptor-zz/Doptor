<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modules', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('alias');
			$table->string('hash', 50)->unique()->nullable();
			$table->string('table');
			$table->string('version');
			$table->string('author');
			$table->string('website')->nullable();
			$table->text('description')->nullable();
			$table->string('target');
			$table->text('links')->nullable();
			$table->boolean('enabled')->default(false);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('modules');
	}

}
