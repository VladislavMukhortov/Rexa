<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('multi_wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('owner');
            $table->unsignedTinyInteger('type');
            $table->char('code_currency', 7)->default('YE');
            $table->enum('balance_type', ['main', 'demo', 'bonus'])->default('main');
            $table->decimal('amount', 12, 8);
            $table->decimal('commission', 12, 8)->default(0);
            $table->nullableMorphs('who');
            $table->json('other')->nullable();
            $table->timestamps();
        });
    }
};
