<?php

return [
    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),
    'request_timeout' => env('OPENAI_REQUEST_TIMEOUT', 600), // Increased to 10 minutes for detailed responses
    'max_tokens' => env('OPENAI_MAX_TOKENS', 6000), // Added max tokens configuration
];
