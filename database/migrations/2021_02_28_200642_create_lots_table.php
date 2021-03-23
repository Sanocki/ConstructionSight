<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_Lots', function (Blueprint $table) {
            $table->increments('LotID');
            $table->integer('SiteID');
            $table->integer('StatusID')->default(1);
            $table->string('Number');
            $table->date('CompletionDate')->nullable();
            $table->date('DueDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_Lots');
    }
}
