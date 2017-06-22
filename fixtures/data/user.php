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
        'password_hash' => '$2y$13$iw6I1wH3xex.W8.i2oaYiuRqAesSHhzYfFZYZUjGzxxbBxIgaqGZS', // manager
        'created_at' => 0,
        'confirmed' => 1,
        'last_login_at' => 0,
        'get_emails' => true,
        'get_browser_notify' => false,
    ],
    'user' => [
        'username' => 'user',
        'email' => 'user@test.test',
        'password_hash' => '$2y$13$s.2SJOxygY.8SuELLjctTuJsJTSn4PxMkN2epH04sMvKJQEztYxGm', //user
        'created_at' => 0,
        'confirmed' => 1,
        'last_login_at' => 0,
        'get_emails' => true,
        'get_browser_notify' => true,
    ],
];
