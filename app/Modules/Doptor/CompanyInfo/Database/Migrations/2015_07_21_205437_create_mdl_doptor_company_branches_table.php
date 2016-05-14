<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdlDoptorCompanyBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdl_doptor_company_branches', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('reg_no')->nullable();
            $table->integer('country_id')->unsigned();
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->integer('company_id')->unsigned();
            $table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->nullable();

            $table->index('company_id');
            $table->foreign('company_id')->references('id')->on('mdl_doptor_companies')->on_delete('restrict')->on_update('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mdl_doptor_company_branches');
    }
}
