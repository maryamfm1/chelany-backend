<?php

return [
    // 👇 Yahan apna actual PayPal Client ID aur Secret paste kro
    'client_id' => 'AQBNJuDJGGqSofHpXJd2aRf8ww9l-oFordJizHvDlv03YCsrWAnHeRO1vyleORMS2dURI8HLfs-OoH0S',
    'secret' => 'YOUR_PAYPAL_SECRET_HERE',

    'settings' => [
        // 👇 'sandbox' testing k liye hota hai, 'live' production k liye
        'mode' => 'live', // ya 'live'

        // 👇 Connection timeout seconds
        'http.ConnectionTimeOut' => 30,

        // 👇 Logging enable hai, error log store hogi yahan
        'log.LogEnabled' => true,
        'log.FileName' => storage_path('logs/paypal.log'),
        'log.LogLevel' => 'ERROR', // DEBUG, INFO, WARN, ERROR
    ],
];