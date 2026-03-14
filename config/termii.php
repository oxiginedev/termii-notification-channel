<?php

declare(strict_types=1);

return [
    'termii' => [
        'url' => env('TERMII_URL', 'https://api.ng.termii.com'),
        'key' => env('TERMII_API_KEY'),
        'sender' => env('TERMII_SENDER_ID'),
    ],
];
