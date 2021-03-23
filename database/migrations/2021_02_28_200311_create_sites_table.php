<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tbl_Sites', function (Blueprint $table) {
            $table->increments('SiteID');
            $table->integer('OwnerID');
            $table->string('Name');
            $table->string('Address')->unique();
            $table->string('Phone');
            $table->binary('Photo')->nullable()->default(null);
            $table->boolean('Compelete')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_Sites');
    }
}
