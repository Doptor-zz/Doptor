<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('alias');
            $table->string('type')->default('post');
            // $table->integer('language_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('status', 20)->default('published');

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
        Schema::drop('categories');
    }

}
