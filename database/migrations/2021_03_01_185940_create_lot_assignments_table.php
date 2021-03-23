<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateLotAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_LotAssignment', function (Blueprint $table) {
            $table->increments('AssignmentID');
            $table->integer('JobID');
            $table->integer('LotID');
            $table->integer('UserID')->nullable();
            $table->boolean('Occupying')->default(false);
            $table->timestamp('DateAssigned')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('DateOccupied')->nullable();
            $table->boolean('Complete')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_LotAssignment');
    }
}
