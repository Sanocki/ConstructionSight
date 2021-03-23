<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSiteApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_SiteApproval', function (Blueprint $table) {
            $table->increments('ApprovalID');
            $table->integer('SiteID')->default(0);
            $table->integer('UserID');
            // 0-pending 1-accepted 2-rejected 3-removed
            $table->integer('Status')->default(0);
            $table->timestamp('Date')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_SiteApproval');
    }
}