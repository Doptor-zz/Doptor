<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuiltReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('built_reports', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('author')->nullable();
			$table->string('version')->nullable();
			$table->string('website')->nullable();
			$table->text('modules')->nullable();
			$table->boolean('show_calendars')->default(true);
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
		Schema::drop('built_reports');
	}

}
