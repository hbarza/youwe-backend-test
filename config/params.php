<?php

return [
    // 'adminEmail' => 'admin@example.com',
    'cache' => [
        // @todo change to default values for porduction
        'enable' => true, // production default: true
        'flush'  => false // production default: false
    ],
    'modules' => [
        'products' => ['insurance', 'bus'],
        'payments' => ['sepmicro', 'wallet']
    ]
];
