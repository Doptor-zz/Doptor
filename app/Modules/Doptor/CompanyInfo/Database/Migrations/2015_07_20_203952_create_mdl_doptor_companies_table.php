<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdlDoptorCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mdl_doptor_companies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('reg_no')->nullable();
			$table->string('logo')->nullable();
            $table->text('address')->nullable();
            $table->integer('country_id')->unsigned();
            $table->string('currency')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->nullable();

			$table->index('country_id');
			$table->foreign('country_id')->references('id')->on('mdl_doptor_countries')->on_delete('restrict')->on_update('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mdl_doptor_companies');
	}

}
