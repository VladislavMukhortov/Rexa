<?php

use Illuminate\Support\Facades\Route;



Route::group([
    'prefix' => 'games',
], function () {
    Route::post('/result', [\App\Http\Controllers\Api\GameServer\GameController::class, 'resultGame']);
});
