<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theme_settings', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('theme_id')->unsigned();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('value')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->index('theme_id');
            $table->foreign('theme_id')->references('id')->on('themes')->on_delete('cascade')->on_update('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('theme_settings');
    }
}
