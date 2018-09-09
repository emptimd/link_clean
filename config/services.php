<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\Campaigns::class,
        // Test
        'key'    => env('sk_test_qC4GDfPf7qihqRFMF42lKrgY'),
        'secret' => env('pk_test_gjkWLrfHnciAgyazUyUJ8kDL'),
        // Live
//        'key'    => env('sk_live_8xTyemLKGdutV5jwDgxowHLM'),
//        'secret' => env('pk_live_AGlbu3uHqG6smiiqYVP756Bf'),
    ],

//    'rollbar' => [
//        'access_token' => 'f4dbd8dcbf2d41f3ac01d60feeaa8e60',
//        'level' => 'debug',
//    ],
];
