<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaEntriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media_entries', function(Blueprint $table) {
			$table->increments('id');
			$table->string('caption')->nullable();
			$table->string('image');
			$table->string('thumbnail');
			// $table->boolean('highlighted')->default(false);
			$table->integer('album_id')->unsigned()->nullable();
			$table->integer('created_by')->unsigned();
			$table->integer('updated_by')->unsigned()->nullable();
			$table->timestamps();

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
		File::cleanDirectory('uploads/media');
		Schema::drop('media_entries');
	}

}
