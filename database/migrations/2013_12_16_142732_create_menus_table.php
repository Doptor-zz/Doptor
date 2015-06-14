<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('alias');
			$table->string('link');
			$table->string('icon')->nullable();
			$table->string('link_manual')->nullable();
			$table->integer('category')->unsigned();
			$table->string('display_text')->nullable();
			$table->boolean('same_window')->default(true); 	// Whether to display the target in same window or not.
			$table->boolean('show_image')->default(true); 	// Whether to display the image or not
			$table->boolean('is_wrapper')->default(false);
			$table->integer('wrapper_width')->unsigned()->nullable();
			$table->integer('wrapper_height')->unsigned()->nullable();
			// ALTER TABLE  `menus` ADD  `wrapper_width` INT UNSIGNED NULL AFTER  `is_wrapper` ,
			// ADD  `wrapper_height` INT UNSIGNED NULL AFTER  `wrapper_width` ;
			$table->string('status')->default('published');
			$table->integer('parent')->unsigned();
			$table->integer('order')->default(0);
			$table->string('target');
			$table->integer('language_id')->unsigned();
			$table->dateTime('publish_start')->nullable();
			$table->dateTime('publish_end')->nullable();
			$table->string('meta_title')->nullable();
			$table->string('meta_description')->nullable();
			$table->string('meta_keywords')->nullable();
			$table->timestamps();

			$table->index('category');
			$table->foreign('category')->references('id')->on('menu_categories')->on_delete('restrict')->on_update('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menus');
	}

}
