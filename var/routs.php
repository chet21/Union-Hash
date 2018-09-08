<?php

return array(
    'kingdom/enter' => 'dashboard/enter',
    'enter' => 'index/enter',
    'reg' => 'index/reg',
    'out', 'index/out',
    'dashboard' => 'account/dashboard',
    'deposit' => 'account/deposit',
    'buy' => 'account/buy_user',
    'create' => 'paymant/create',
    'pay/([A-Za-z0-9]+)' => 'paymant/pay/$1',
    'settings' => 'account/settings',
    'callback' => 'paymant/callback',
    'callback/([A-Za-z0-9]+)' => 'paymant/callback/$1',
//    'invoice' => 'paymant/invoice',
//    'invoice/([A-Za-z0-9]+)' => 'paymant/invoice/$1',
//    'success/([A-Za-z0-9]+)' => 'paymant/success/$1',
    'status/([A-Za-z0-9]+)' => 'paymant/status/$1',
    'out' => 'account/out',
    '' => 'index/index'
);