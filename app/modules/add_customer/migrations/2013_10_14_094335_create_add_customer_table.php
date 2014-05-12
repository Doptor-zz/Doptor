<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddCustomerTable extends Migration {

	// Read the configuration from the module.json file
	public $config;

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$this->config = json_decode(file_get_contents(__DIR__ . '/../module.json'), true);
		
		Schema::create('module_'. $this->config['table'], function(Blueprint $table)
		{
			$table->increments('id');
			foreach ($this->config['fields'] as $field) {
				$table->string($field)->nullable();
			}
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
		$this->config = json_decode(file_get_contents(__DIR__ . '/../module.json'), true);
		Schema::drop('module_'. $this->config['table']);
	}

}
