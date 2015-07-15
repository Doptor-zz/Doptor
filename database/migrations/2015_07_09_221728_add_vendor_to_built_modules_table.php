<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVendorToBuiltModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('built_modules', function(Blueprint $table) {
            $table->string('vendor')->nullable()->after('author');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('built_modules', function(Blueprint $table) {
            $table->dropColumn('vendor');
        });
    }
}
