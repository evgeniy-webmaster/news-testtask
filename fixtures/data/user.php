<?php

return [
    'admin' => [
        'username' => 'root',
        'email' => 'root@test.test',
        'password_hash' => '$2y$13$qYFh0hd95ERsslCHuIHEbuwlb..xb/aZCjov41ztNVwlrikMZ4/xm', //root
        'created_at' => 0,
        'confirmed' => 1,
        'last_login_at' => 0,
        'get_emails' => false,
        'get_browser_notify' => false,
    ],
    'manager' => [
        'username' => 'manager',
        'email' => 'manager@test.test',
        'password_hash' => '$2y$13$7o7axCGWFQznCWHBnbMgS..17T1Hw68GWNUUMCKLL6QAPFnVWcYJu', // manager
        'created_at' => 0,
        'confirmed' => 1,
        'last_login_at' => 0,
        'get_emails' => true,
        'get_browser_notify' => false,
    ],
    'user' => [
        'username' => 'user',
        'email' => 'user@test.test',
        'password_hash' => '$2y$13$Q0XDWoaCj/YPm/wLPM3EaO/c1pj3yHb/uN1iPiio0KIjj2li7weEO', //user
        'created_at' => 0,
        'confirmed' => 1,
        'last_login_at' => 0,
        'get_emails' => true,
        'get_browser_notify' => false,
    ],
];
