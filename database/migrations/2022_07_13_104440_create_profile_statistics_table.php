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
        Schema::create('profile_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->integer('wins');
            $table->integer('defeats');
            $table->enum('type', config('fight.types'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_statistics');
    }
};
