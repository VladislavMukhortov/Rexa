<?php

namespace App\Http\Controllers\Api\GameServer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GameServer\CancelRegistrationToFightRequest;
use App\Http\Requests\Api\GameServer\CardsSelectionStageRequest;
use App\Http\Requests\Api\GameServer\PreparePvpRequest;
use App\Http\Requests\Api\GameServer\RegistrationToFightRequest;
use App\Http\Requests\Api\GameServer\ResultGameRequest;
use App\Http\Requests\Api\GameServer\StartPvpRequest;
use App\Http\Resources\ReadyToFightCollection;
use App\Models\Client;
use App\Models\Profile;
use App\Models\ReadyToFight;
use App\Services\FightService;
use App\Services\GameServer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * Регистрация на битву pvp
     *
     * @param RegistrationToFightRequest $registrationToFightRequest
     * @return JsonResponse
     */
    public function registrationToFight(RegistrationToFightRequest $registrationToFightRequest): jsonResponse
    {
        DB::beginTransaction();
        try {
            ReadyToFight::query()->create([
                'player_one_id' => auth()->user()->id,
                'player_two_id' => null,
                'bet' => $registrationToFightRequest->get('bet'),
                'balance_type' => config('im_wallet.balance_type.main'),
                'coin' => $registrationToFightRequest->get('coin'),
                'status' => config('fight.statuses.player_one_made_bet'),
            ]);

            auth()->user()->profile->creditBalance(
                $registrationToFightRequest->get('bet'),
                config('im_wallet.credit.fight_bet'),
                $registrationToFightRequest->get('coin'),
                config('im_wallet.balance_type.main'),
                auth()->user(),
            );

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => __('fight.registration.success'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => true,
                'message' => __('fight.registration.error'),
            ], 200);
        }
    }

    /**
     * Отменить регистрацию на бой
     *
     * @param CancelRegistrationToFightRequest $cancelRegistrationToFightRequest
     * @return JsonResponse
     */
    public function cancelRegistration(CancelRegistrationToFightRequest $cancelRegistrationToFightRequest): jsonResponse
    {
        DB::beginTransaction();
        try {
            $readyToFight = auth()->user()->profile->readyToFight()->first();
            if (!$readyToFight) {
                throw new \Exception();
            }
            auth()->user()->profile->debitBalance(
                $readyToFight->bet,
                config('im_wallet.debit.return_bet'),
                $readyToFight->coin,
                $readyToFight->balance_type,
                auth()->user(),
            );

            $fightService = new FightService(auth()->user());
            $fightService->changeReadyToFightStatus(config('fight.statuses.cancelled'), $readyToFight);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => __('fight.cancel_registration.success'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => true,
                'message' => __('fight.cancel_registration.error'),
            ], 200);
        }
    }

    /**
     * Подготовить бой между двумя игроками
     *
     * @param PreparePvpRequest $preparePvpRequest
     * @param ReadyToFight $readyToFight
     * @return JsonResponse
     */
    public function preparePvp(PreparePvpRequest $preparePvpRequest, ReadyToFight $readyToFight): JsonResponse
    {
        DB::beginTransaction();
        try {
            auth()->user()->profile
                ->creditBalance(
                    $readyToFight->bet,
                    config('im_wallet.credit.fight_bet'),
                    $readyToFight->coin,
                    config('im_wallet.balance_type.main'),
                    auth()->user()->profile,
                );

            $readyToFight->update([
                    'player_two_id' => auth()->user()->profile->client_id,
                    'status' => config('fight.statuses.player_two_made_bet'),
                ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => __('fight.prepare_pvp.success'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => __('fight.prepare_pvp.error'),
            ], config('errors.error_start_game.code'));
        }
    }

    /**
     * Выбор карт игроками
     *
     * @param CardsSelectionStageRequest $cardsSelectionStageRequest
     * @param ReadyToFight $readyToFight
     * @return JsonResponse
     */
    public function cardSelectionStage(CardsSelectionStageRequest $cardsSelectionStageRequest, ReadyToFight $readyToFight): JsonResponse
    {
        DB::beginTransaction();
        try {
            $cards = FightService::sortPlayersCards($cardsSelectionStageRequest->all());
            if ($cardsSelectionStageRequest->who_id == $readyToFight->player_one_id) {
                $readyToFight->player_one_cards = json_encode($cards[0]);
            } else {
                $readyToFight->player_two_cards = json_encode($cards[1]);
            }
            if (empty($readyToFight->player_one_cards) && empty($readyToFight->player_two_cards)) {
                $readyToFight->status = config('fight.statuses.one_player_selected_cards');
            } else {
                $readyToFight->status = config('fight.statuses.cards_selected');
            }
            $readyToFight->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => __('fight.select_cards.success'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => __('fight.start.error'),
            ], config('errors.error_start_game.code'));
        }
    }

    /**
     * Начало pvp боя
     *
     * @param StartPvpRequest $startPvpRequest
     * @param ReadyToFight $readyToFight
     * @return JsonResponse
     */
    public function startPvp(StartPvpRequest $startPvpRequest, ReadyToFight $readyToFight):  JsonResponse
    {
        DB::beginTransaction();
        try {
            $gameServer = new GameServer($readyToFight->player_one_id);

            $whoFirst = rand(1, 2) == 1 ? $readyToFight->player_one_id : $readyToFight->player_two_id;
            $game = $gameServer->startGame(
                $readyToFight->player_two_id,
                json_decode($readyToFight->player_one_cards),
                json_decode($readyToFight->player_two_cards),
                $whoFirst,
            );
            if (!isset($game['uuid'])) {
                throw new \Exception();
            }
            $readyToFight->update([
                'status' => config('fight.statuses.in_process'),
            ]);
            FightService::writeStatistic([
                'uuid' => $game['uuid'],
                'player_one_id' => $readyToFight->player_one_id,
                'player_two_id' => $readyToFight->player_two_id,
                'winner_id' => null,
                'coin' => $readyToFight->coin,
                'bet' => $readyToFight->bet,
                'profit' => FightService::calcProfit(config("im_wallet.commission.204"), $readyToFight->bet * 2),
                'fight_type' => config('fight.types.pvp'),
                'status' => 'in_process',
                'duration' => null,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => __('fight.start.success'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            FightService::returnBetsToUsers($readyToFight);
            $fightService = new FightService(auth()->user());
            $fightService->changeReadyToFightStatus(config('fight.statuses.cancelled'), $readyToFight);
            return response()->json([
                'status' => false,
                'message' => __('fight.start.error'),
            ], config('errors.error_start_game.code'));
        }

    }

    /**
     * Получить всех пользователей, готовых к бою
     *
     * @return ReadyToFightCollection
     */
    public function getAllReadyToFightPlayers(): ReadyToFightCollection
    {
        $ready = ReadyToFight::query()
            ->where('status', config('fight.statuses.player_one_ready'))
            ->with(['profile'])
            ->get();

        return new ReadyToFightCollection($ready);
    }

    /**
     * Получить все карты обоих соперников
     *
     * @param Client $enemy
     * @return JsonResponse
     */
    public function getAllEnemiesCards(Client $enemy): jsonResponse
    {
        $gameServer = new GameServer(auth()->user()->id);
        return response()->json([
            'status' => true,
            'data' => [
                auth()->user()->id => $gameServer->getClientCards(auth()->user()->id),
                $enemy->id => $gameServer->getClientCards($enemy->id),
            ],
        ], 200);
    }

    /**
     * Результат боя
     *
     * @param ResultGameRequest $gameRequest
     * @return Response
     */
    public function resultGame(ResultGameRequest $gameRequest): Response
    {
        return new Response([
            'status' => true,
            'message' => 'Game result success save'
        ]);
    }
}
