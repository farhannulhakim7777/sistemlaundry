<?php

return [
    'default' => env('MAIL_MAILER', 'smtp'),
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 2525),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
        ],
        'log' => ['transport' => 'log'],
    ],
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],
    'markdown' => [
        'theme' => 'default',
        'paths' => [resource_path('views/vendor/mail')],
    ],
];