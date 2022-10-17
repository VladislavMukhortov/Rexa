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
        Schema::create('fight_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->unsignedBigInteger('player_one_id');
            $table->unsignedBigInteger('player_two_id');
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->enum('coin', config('im_wallet.code_currency'))->default('REXA');
            $table->string('fight_type');
            $table->decimal('bet', 12, 8);
            $table->decimal('profit', 12, 8);
            $table->enum('status', ['in_process', 'finished'])->default('in_process');
            $table->time('duration')->nullable();
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
        Schema::dropIfExists('fight_statistics');
    }
};
