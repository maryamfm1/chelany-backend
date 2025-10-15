<?php

return [
    // 👇 Yahan apna actual PayPal Client ID aur Secret paste kro
    'client_id' => 'AT5Xj_e0itIyLw1tS-DtCkvc3X-n9-Ji2SG-gT3LwFw7iNk_c9ykhqiM-Ow4IW8BM7oeFSx-wZ04DZ0q',
    'secret' => 'YOUR_PAYPAL_SECRET_HERE',

    'settings' => [
        // 👇 'sandbox' testing k liye hota hai, 'live' production k liye
        'mode' => 'sandbox', // ya 'live'

        // 👇 Connection timeout seconds
        'http.ConnectionTimeOut' => 30,

        // 👇 Logging enable hai, error log store hogi yahan
        'log.LogEnabled' => true,
        'log.FileName' => storage_path('logs/paypal.log'),
        'log.LogLevel' => 'ERROR', // DEBUG, INFO, WARN, ERROR
    ],
];
