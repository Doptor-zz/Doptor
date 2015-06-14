<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlideshowTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slideshow', function(Blueprint $table) {
			$table->increments('id');
			$table->text('caption')->nullable();
			$table->string('image');
			$table->string('status', 20)->default('published');
			// $table->integer('language_id')->unsigned();
			$table->dateTime('publish_start')->nullable();
			$table->dateTime('publish_end')->nullable();
			// $table->string('meta_title')->nullable();
			// $table->string('meta_description')->nullable();
			// $table->string('meta_keywords')->nullable();
			$table->integer('created_by')->unsigned();
			$table->integer('updated_by')->unsigned()->nullable();
			$table->timestamps();

			// $table->index('language_id');
			// $table->foreign('language_id')->references('id')->on('languages')->on_delete('restrict')->on_update('cascade');

			$table->index('created_by');
			$table->foreign('created_by')->references('id')->on('users')->on_delete('restrict')->on_update('cascade');

			$table->index('updated_by');
			$table->foreign('updated_by')->references('id')->on('users')->on_delete('restrict')->on_update('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('slideshow');
	}

}
