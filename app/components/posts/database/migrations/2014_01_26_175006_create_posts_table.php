<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('permalink');
			$table->string('image')->nullable();
			$table->text('content');
			$table->enum('status', array('published', 'unpublished', 'drafted', 'archived'))
				->default('published');
			$table->string('target');
			// $table->integer('language_id')->unsigned();
			$table->boolean('featured')->default(false);
			$table->dateTime('publish_start')->nullable();
			$table->dateTime('publish_end')->nullable();
			$table->string('meta_title')->nullable();
			$table->string('meta_description')->nullable();
			$table->string('meta_keywords')->nullable();
			$table->enum('type', array('page', 'post'))->default('post');
			$table->integer('hits')->default(0);
			$table->text('extras')->nullable();
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
		File::cleanDirectory('uploads/posts');
		Schema::drop('posts');
	}

}
