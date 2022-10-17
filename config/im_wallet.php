<?php
return [
    'code_currency' => [
        'REXA' => 'REXA', //default
        'YE' => 'YE',
        'gold' => 'gold'
    ],
    'code_currency_name' => [
        'REXA' => 'REXA', //default
        'YE' => 'conventional unit of measurement',
        'gold' => 'Gold Monet'
    ],

    'balance_required_type' => 'main',
    'balance_type' => [
        'main' => 'main',
        'demo' => 'demo',
        'bonus' => 'bonus'
    ],

    'debit' => [
        'put' => 101,
        'return_bet' => 102,
        'win_in_fight' => 103,
        'transfer' => 105,
    ],

    'debit_names' => [
        101 => 'multi_wallet.debit_put',
        102 => 'multi_wallet.debit_transfer',
        103 => 'multi_wallet.win_in_fight',
        105 => 'multi_wallet.transfer',
    ],


    'credit' => [
        'withdrawal' => 201,
        'transfer' => 202,
        'buy' => 203,
        'fight_bet' => 204,
    ],

    'credit_names' => [
        201 => 'multi_wallet.credit_withdrawal',
        202 => 'multi_wallet.credit_transfer',
        203 => 'multi_wallet.credit_buy',
    ],

    'commission_default' => 0, // percentage commission (%)
    'commission' => [
        201 => 0, // set commission on withdrawal
        204 => 0, // set commission on fight bet
        103 => 10, // set commission on fight bet
    ],


    'multi_wallet_model' => \Icekristal\LaravelInteriorMultiWallet\Models\MultiWallet::class
];
