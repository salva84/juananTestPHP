<?php
declare(strict_types=1);

return [
    'db' => [
        'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=accommodations;charset=utf8mb4',
        'user' => 'accom_user',
        'password' => 'accom_password',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ],
    ],
    'default_locale' => 'en',
    'result_limit' => 200,
];


