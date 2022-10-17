<?php


namespace App\Services;


use App\Models\Client;
use App\Models\FightStatistic;
use App\Models\Profile;
use App\Models\ReadyToFight;
use Illuminate\Support\Facades\DB;

class FightService
{
    public ?Client $client = null;

    public function __construct(Client $client = null)
    {
        $this->client = $client;
    }

    /**
     * Записать статистику боя
     *
     * @param array $data
     * @return void
     */
    public static function writeStatistic(array $data): void
    {
        FightStatistic::query()->updateOrCreate([
            'uuid' => $data['uuid'],
        ], [
            'client_id' => $data['client_id'],
            'enemy_id' => $data['enemy_id'],
            'winner_id' => $data['winner_id'] ?? null,
            'bet' => $data['bet'],
            'profit' => $data['profit'],
            'status' => $data['status'] ?? 'in_process',
            'duration' => $data['duration'] ?? null,
        ]);
    }

    /**
     * Удалить из списка готовых к бою
     *
     * @return void
     */
    public function deleteFromReady():void
    {
        if (is_null($this->client)) {
            return;
        }
        ReadyToFight::query()
            ->where('player_one_id', $this->client->id)
            ->orWhere('player_two_id', $this->client->id)
            ->delete();
    }

    /**
     * Изменить статус готового к битве игрока
     *
     * @param string $status
     * @return void
     */
    public function changeReadyToFightStatus(string $status, ReadyToFight $readyToFight): void
    {
        if (is_null($this->client)) {
            return;
        }
        $readyToFight->update([
            'status' => $status
        ]);
    }

    /**
     * Расчитать комиссию
     *
     * @param int $type
     * @param float|int $amount
     * @return float|int
     */
    public static function calcCommission(int $type, float|int $amount): float|int
    {
        if ($amount <= 0) return 0;
        $commissionDefault = config('im_wallet.commission_default') ?? 0;
        $additionalCommission = config("im_wallet.commission.$type") ?? null;
        if (!is_null($additionalCommission)) {
            $commission = $amount / 100 * $additionalCommission;
        } else {
            $commission = $amount / 100 * $commissionDefault;
        }
        return $commission;
    }

    /**
     * Расчитать выйгрыш
     *
     * @param int $type
     * @param float|int $amount
     * @return float|int
     */
    public static function calcProfit(int $type, float|int $amount): float|int
    {
        return ($amount - self::calcCommission($type, $amount));
    }

    /**
     * Сортировка карт из запроса
     *
     * @param array $data
     * @return array
     */
    public static function sortPlayersCards(array $data): array
    {
        $playerOneCards = [];
        $playerTwoCards = [];

        foreach ($data as $key => $value) {
            if (stristr($key, 'player_one_cards')) {
                $playerOneCards[] = $value;
            } elseif (stristr($key, 'player_two_cards')) {
                $playerTwoCards[] = $value;
            }
        }

        return [
            $playerOneCards,
            $playerTwoCards
        ];
    }

    /**
     * Посчитать количество побед и поражений
     *
     * @param Profile $profile
     * @return array
     */
    public static function calcWinsAndDefeats(Profile $profile): array
    {
        $wins = 0;
        $defeats = 0;

        $stats = $profile->fightStatistics()->where('status', 'finished')->get();
        foreach ($stats as $stat) {
            $stat->client_id == $stat->winner_id ? $wins++ : $defeats++;
        }

        return [
            'wins' => $wins,
            'defeats' => $defeats,
        ];
    }

    /**
     * Возврат ставок игрокам
     *
     * @param ReadyToFight $readyToFight
     * @return bool
     */
    public static function returnBetsToUsers(ReadyToFight $readyToFight): bool
    {
        DB::beginTransaction();
        try {
            $profileOne = Profile::query()
                ->where('client_id', $readyToFight->player_one_id)
                ->first();
            $profileOne->debitBalance(
                $readyToFight->bet,
                config('im_wallet.debit.return_bet'),
                $readyToFight->coin,
                $readyToFight->balance_type,
                $profileOne,
            );
            $profileTwo = Profile::query()
                ->where('client_id', $readyToFight->player_two_id)
                ->first();
            $profileTwo->debitBalance(
                $readyToFight->bet,
                config('im_wallet.debit.return_bet'),
                $readyToFight->coin,
                $readyToFight->balance_type,
                $profileTwo,
            );
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }

    }
}
