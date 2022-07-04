<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('userslogin2', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('email');
            $table->remembertoken()->after('status');
           
           });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('userslogin2', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('email');
            $table->remembertoken()->after('status');
        });
    }
};
