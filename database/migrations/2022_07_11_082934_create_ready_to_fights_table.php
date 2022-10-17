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
        Schema::create('ready_to_fights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_one_id');
            $table->unsignedBigInteger('player_two_id')->nullable();
            $table->json('player_one_cards')->nullable();
            $table->json('player_two_cards')->nullable();
            $table->enum('coin', config('im_wallet.code_currency'))->default('REXA');
            $table->enum('balance_type', config('im_wallet.balance_type'))->default('main');
            $table->decimal('bet', 12, 8);
            $table->enum('status', config('fight.statuses'))->default('no_bets');
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
        Schema::dropIfExists('ready_to_fights');
    }
};
