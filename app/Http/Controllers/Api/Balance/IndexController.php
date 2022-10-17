<?php

namespace App\Http\Controllers\Api\Balance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Balance\CreditBalanceRequest;
use App\Http\Requests\Api\Balance\DebitBalanceRequest;
use App\Http\Requests\Api\Balance\GetBalanceRequest;
use App\Http\Requests\Api\Balance\TransferBalanceRequest;
use App\Http\Resources\BalanceCollection;
use App\Http\Resources\BalanceResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     *
     */
    public function test()
    {
//        auth()->user()->profile->debitBalance(1000, config('im_wallet.debit.put'), config('im_wallet.code_currency.gold'));
//        auth()->user()->profile->creditBalance(100, config('im_wallet.credit.withdrawal'), config('im_wallet.code_currency.gold'));

        return [
            'balance_client' => auth()->user()->profile->balance(),
            'balance_client_gold' => auth()->user()->profile->balance(config('im_wallet.code_currency.gold')),
            'all_transaction' => new BalanceCollection(auth()->user()->profile->balanceTransaction(config('im_wallet.code_currency.gold'))->get()), //Все транзакции
        ];
    }

    /**
     * Получить балланс пользователя
     *
     * @return JsonResponse
     */
    public function getBalance(): JsonResponse
    {
        $balances = [];

        foreach (config('im_wallet.balance_type') as $type){
            foreach (config('im_wallet.code_currency_name') as $keyCode => $code) {
                $balances[$type][$keyCode] = auth()->user()->profile->balance($keyCode, $type);
            }
        }

        return response()->json([
            'status' => true,
            'data' => $balances,
        ], 200);
    }

    /**
     * Пополнить балланс
     *
     * @param DebitBalanceRequest $debitBalanceRequest
     * @return BalanceResource
     */
    public function debitBalance(DebitBalanceRequest $debitBalanceRequest): BalanceResource
    {
        return new BalanceResource(
            auth()->user()->profile->debitBalance(
                $debitBalanceRequest->get('amount'),
                config('im_wallet.debit.put'),
                $debitBalanceRequest->get('coin_code'),
                $debitBalanceRequest->get('balance_type'),
            )
        );
    }

    /**
     * Снять с балланса
     *
     * @param CreditBalanceRequest $debitBalanceRequest
     * @return BalanceResource
     */
    public function creditBalance(CreditBalanceRequest $debitBalanceRequest): BalanceResource
    {
        return new BalanceResource(
            auth()->user()->profile->creditBalance(
                $debitBalanceRequest->get('amount'),
                config('im_wallet.credit.withdrawal'),
                $debitBalanceRequest->get('coin_code'),
                $debitBalanceRequest->get('balance_type'),
            ),
        );
    }

    /**
     * Перевод денег от одного пользователя другому
     *
     * @param TransferBalanceRequest $transferBalanceRequest
     * @param Client $client
     * @return JsonResponse
     */
    public function transfer(TransferBalanceRequest $transferBalanceRequest, Client $client): JsonResponse
    {
        DB::beginTransaction();

        try {
            auth()->user()->profile->creditBalance(
                $transferBalanceRequest->get('amount'),
                config('im_wallet.credit.transfer'),
                $transferBalanceRequest->get('coin_code'),
                $transferBalanceRequest->get('balance_type'),
                $client
            );

            $client->profile->debitBalance(
                $transferBalanceRequest->get('amount'),
                config('im_wallet.debit.transfer'),
                $transferBalanceRequest->get('coin_code'),
                $transferBalanceRequest->get('balance_type'),
                auth()->user()->profile
            );

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => __('multi_wallet.currency_operations.transfer.success'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => __('multi_wallet.currency_operations.transfer.error'),
            ], 422);
        }
    }
}
