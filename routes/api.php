<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware(['locale'])->group(function () {
    //Тут для лейдинга, так как авторизация не нужна
    Route::middleware(['auth:sanctum'])->group(function () {
        //Тут для самого ЛК
        Route::group([
            'prefix' => 'profile',
        ], function () {
            Route::get('/', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'getInfo']);
            Route::post('/update', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'update']);
            Route::post('/upload-avatar', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'uploadAvatar']);
            Route::get('/get-all-media', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'getAllProfileMedia']);
            Route::post('/choose-default-avatar', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'chooseDefaultAvatar']);
            Route::get('/get-friends', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'getAllFriends']);
            Route::post('/add-to-friends/{client}', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'addToFriends']);
            Route::delete('/remove-from-friends/{client}', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'removeFromFriends']);
        });
        Route::group([
            'prefix' => 'balance',
        ], function () {
            Route::get('/get-balance', [\App\Http\Controllers\Api\Balance\IndexController::class, 'getBalance']);
            Route::post('/debit', [\App\Http\Controllers\Api\Balance\IndexController::class, 'debitBalance']);
            Route::post('/credit', [\App\Http\Controllers\Api\Balance\IndexController::class, 'creditBalance']);
            Route::post('/{client}/transfer', [\App\Http\Controllers\Api\Balance\IndexController::class, 'transfer']); //api/v1/5/transfer
            Route::get('/', [\App\Http\Controllers\Api\Balance\IndexController::class, 'test']);
        });
        Route::group([
            'prefix' => 'fight',
        ], function () {
            Route::post('/{readyToFight}/start-pvp', [\App\Http\Controllers\Api\GameServer\GameController::class, 'startPvp']);
            Route::post('/{readyToFight}/prepare-pvp', [\App\Http\Controllers\Api\GameServer\GameController::class, 'preparePvp']);
            Route::post('/{readyToFight}/select-cards', [\App\Http\Controllers\Api\GameServer\GameController::class, 'cardSelectionStage']);
            Route::get('/enemies/all-cards/{enemy}', [\App\Http\Controllers\Api\GameServer\GameController::class, 'getAllEnemiesCards']);
            Route::get('/all-ready-to-fight', [\App\Http\Controllers\Api\GameServer\GameController::class, 'getAllReadyToFightPlayers']);
            Route::post('/registration', [\App\Http\Controllers\Api\GameServer\GameController::class, 'registrationToFight']);
            Route::post('/cancel-registration', [\App\Http\Controllers\Api\GameServer\GameController::class, 'cancelRegistration']);
        });
    });
});
