<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Users', function (Blueprint $table) {
            $table->increments('UserID');
            $table->integer('RoleID');
            $table->integer('JobID')->nullable()->default(null);
            $table->string('Company')->nullable()->default(null);
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('PhoneNumber');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_Users');

        Schema::dropIfExists('Users');
    }
}

