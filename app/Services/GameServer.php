<?php

namespace App\Services;

use App\Models\Client;
use App\Models\FightStatistic;
use App\Models\Profile;
use App\Models\ReadyToFight;
use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GameServer
{
    /**
     * DEV: https://core.cardgame.icekristal.ru
     * STAGE: -
     *
     * URL гейм сервера
     *
     * @var string|Repository|Application|mixed
     */
    public ?string $gameServerUrl;

    /**
     * Token для связки с гейм сервером
     *
     * @var string|Repository|Application|mixed|null
     */
    public ?string $gameServerToken;

    public string $gameLogChanel = 'game_server';

    public string $additionalUrl = '';
    public array $paramsRequest = [];

    public ?int $clientId = null;

    public string $method = 'get';

    public function __construct($clientId = null)
    {
        $this->gameServerUrl = config('app.url_game') . "/api/game";
        $this->gameServerToken = config('services.game_server.token');
        $this->clientId = !is_null($clientId) ? intval($clientId) : null;
    }


    /**
     * Получаем карты пользователя
     *
     * @param int $clientId
     * @return Response|mixed|never|void
     */
    public function getClientCards(int $clientId)
    {
        if(is_null($clientId)) return abort(422, 'Need clientId');
        $this->additionalUrl = "cards/{$clientId}/list";
        return $this->sendRequest();
    }

    /**
     * Начинаем битву за точку
     *
     * @param int $playerTwoId
     * @param array $playerOneCards
     * @param array $playerTwoCards
     * @param mixed $firstStepPlayerId
     * @return Response|mixed|never|void
     */
    public function startGame(int $playerTwoId, array $playerOneCards, array $playerTwoCards, mixed $firstStepPlayerId = null)
    {
        if(is_null($this->clientId)) return abort(422, 'Need clientId');
        $this->method = 'post';
        $this->additionalUrl = "games/start";

        $this->paramsRequest = [
            'player_one_id' => $this->clientId,
            'player_two_id' => intval($playerTwoId),
            'step_one_player_id' => $firstStepPlayerId,
            'player_one_cards' => $playerOneCards,
            'player_two_cards' => $playerTwoCards,
        ];

        return $this->sendRequest();
    }

    /**
     * Меняем владельца карты
     * @return Response|mixed|never|void
     */
    public function changeOwnerCard(string $cardUuid)
    {
        if(is_null($this->clientId)) return abort(422, 'Need clientId');
        $this->method = 'post';
        $this->additionalUrl = "cards/change-owner";
        $this->paramsRequest = [
            'new_owner_id' => $this->clientId,
            'card_uuid' => $cardUuid,
        ];
        return $this->sendRequest();
    }

    /**
     * Крафтим карты для игрока
     * @return Response|mixed|never|void
     */
    public function craftCard(int $countCraft = 1)
    {
        if(is_null($this->clientId)) return abort(422, 'Need clientId');
        $this->method = 'post';
        $this->additionalUrl = "cards/{$this->clientId}/craft";
        $this->paramsRequest = [
            'count_craft_card' => $countCraft,
        ];
        return $this->sendRequest();
    }

    /**
     * Узнать результат игры (дополнительно, если не пришло в api)
     * @return Response|mixed|never|void
     */
    public function getResultGame(string $gameUuid)
    {
        $this->method = 'post';
        $this->additionalUrl = "games/result";
        $this->paramsRequest = [
            'game_uuid' => $gameUuid,
        ];
        return $this->sendRequest();
    }


    /**
     * В ответ приходит:
     * status: true | false
     * data - коллекция
     * message - текст
     *
     * либо data, либо message
     *
     * Отправляем запрос на игровой сервер
     */
    public function sendRequest()
    {
        try {
            if ($this->method == 'get') {
                $result = Http::withToken($this->gameServerToken)->acceptJson()
                    ->timeout(3)->get($this->gameServerUrl . "/{$this->additionalUrl}", $this->paramsRequest);
            } else {
                $result = Http::withToken($this->gameServerToken)->acceptJson()
                    ->timeout(3)->post($this->gameServerUrl . "/{$this->additionalUrl}", $this->paramsRequest);
            }

            if ($result['status']) {
                if (isset($result['data'])) {
                    return $result['data'];
                } elseif (isset($result['message'])) {
                    return $result['message'];
                }
                return abort(403);
            } else {
                dd($result['errors']);
            }
        } catch (Exception $e) {
            Log::channel($this->gameLogChanel)->error($e);
            return new Response([
                'status' => false,
                'message' => "Error connect game server. Please try later"
            ], 401);
        }
    }
}
