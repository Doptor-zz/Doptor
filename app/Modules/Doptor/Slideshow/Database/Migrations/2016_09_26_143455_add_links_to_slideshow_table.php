<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinksToSlideshowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slideshow', function(Blueprint $table) {
            $table->string('link_title')->nullable()->after('image');
            $table->string('link')->nullable()->after('link_title');
            $table->string('link_manual')->nullable()->after('link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slideshow', function(Blueprint $table) {
            $table->dropColumn('link_title');
            $table->dropColumn('link');
            $table->dropColumn('link_manual');
        });
    }
}
