<?php

// config for Fintech/Tab
use Fintech\Tab\Models\PayBill;
use Fintech\Tab\Repositories\Eloquent\PayBillRepository;

return [

    /*
    |--------------------------------------------------------------------------
    | Enable Module APIs
    |--------------------------------------------------------------------------
    | This setting enable the API will be available or not
    */
    'enabled' => env('PACKAGE_TAB_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Tab Group Root Prefix
    |--------------------------------------------------------------------------
    |
    | This value will be added to all your routes from this package
    | Example: APP_URL/{root_prefix}/api/tab/action
    |
    | Note: while adding prefix add closing ending slash '/'
    */

    'root_prefix' => 'api/',

    /*
    |--------------------------------------------------------------------------
    | PayBill Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'pay_bill_model' => PayBill::class,

    //** Model Config Point Do not Remove **//

    /*
    |--------------------------------------------------------------------------
    | Service Providers
    |--------------------------------------------------------------------------
    |
    | This value will be used across systems where a repository instance is needed
    */
    'providers' => [
        'sslwireless' => [
            'mode' => env('PACKAGE_TAB_SSLUTIL_MODE','sandbox'),
            'driver' => Fintech\Tab\Vendors\SSLUtility::class,
            'live' => [
                'endpoint' => 'https://common-api.sslwireless.com/api',
                'auth_key' => env('PACKAGE_TAB_SSLUTIL_AUTH_KEY'),
                'stk_code' => env('PACKAGE_TAB_SSLUTIL_STK_CODE'),
            ],
            'sandbox' => [
                'endpoint' => 'https://api.sslwireless.com/api',
                'auth_key' => env('PACKAGE_TAB_SSLUTIL_AUTH_KEY'),
                'stk_code' => env('PACKAGE_TAB_SSLUTIL_STK_CODE'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Repositories
    |--------------------------------------------------------------------------
    |
    | This value will be used across systems where a repository instance is needed
    */

    'repositories' => [
        \Fintech\Tab\Interfaces\PayBillRepository::class => PayBillRepository::class,

        //** Repository Binding Config Point Do not Remove **//
    ],

];
