<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('alias');
			$table->string('image')->nullable();
			$table->string('email')->nullable();
			$table->string('address')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('zip_code')->nullable();
			$table->string('country')->nullable();
			$table->string('telephone')->nullable();
			$table->string('mobile')->nullable();
			$table->string('fax')->nullable();
			$table->string('website')->nullable();
			$table->text('location')->nullable();
			$table->text('display_options')->nullable();
			$table->integer('category_id')->unsigned()->nullable();
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
		Schema::drop('contact_details');
	}

}
