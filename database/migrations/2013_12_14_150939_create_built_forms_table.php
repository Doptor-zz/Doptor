<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuiltFormsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('built_forms', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('hash', 50)->unique()->nullable();
			$table->integer('category')->unsigned();
			$table->text('description');
			$table->boolean('show_captcha')->default(false);
			$table->text('data');
			$table->text('rendered');
			$table->string('redirect_to');
			$table->text('extra_code')->nullable();
			$table->text('email')->nullable();
			$table->timestamps();

			$table->index('category');
			$table->foreign('category')->references('id')->on('form_categories')->on_delete('restrict')->on_update('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('built_forms');
	}

}
