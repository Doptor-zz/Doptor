<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuiltModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('built_modules', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('hash', 50)->unique()->nullable();
			$table->string('version')->nullable();
			$table->string('author')->nullable();
			$table->string('website')->nullable();
			$table->text('description')->nullable();
			$table->string('form_id');
			$table->string('target');
			$table->string('file');
			$table->string('table_name');
			$table->boolean('is_author')->default(true);
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
		Schema::drop('built_modules');
	}

}
