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
        Schema::create('pwd_resets', function (Blueprint $table) {
            $table->id();
            $table->string('PwdResetEmail');
            $table->string('PwdResetSelector');
            $table->string('PwdResetToken');
            $table->string('PwdResetExpires');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pwd_resets');
    }
};
