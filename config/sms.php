<?php
return [
    'gateway'   =>  env('SMS_GATEWAY'),
    'smsbin'    =>  [
        'url'       =>  env('SMSBIN_API_URL'),
        'key'       =>  env('SMSBIN_API_KEY'),
        'senderid'  =>  env('SMSBIN_API_SENDERID'),
        'routeid'   =>  env('SMSBIN_API_ROUTE_ID'),
    ],

    'msg91'     =>  [
        'url'       =>  env('MSG91_API_URL'),
        'key'       =>  env('MSG91_API_KEY'),
        'senderid'  =>  env('MSG91_API_SENDERID'),
        'routeid'   =>  env('MSG91_API_ROUTE_ID'),
    ]
];