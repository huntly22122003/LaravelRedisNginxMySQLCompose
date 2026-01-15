<?php
return [
    'paths' => ['/*', 'hello'], // những route cần bật CORS
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // hoặc chỉ định http://localhost:3000
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];