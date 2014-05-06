<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThemesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('themes', function(Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('version');
			$table->string('author');
			$table->text('description');
			$table->string('screenshot');
			$table->string('directory');
			$table->string('target');
			$table->integer('created_by')->unsigned();
			$table->timestamps();

			$table->index('created_by');
			$table->foreign('created_by')->references('id')->on('users')->on_delete('restrict')->on_update('cascade');

        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('themes');
	}

}
