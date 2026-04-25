<?php

return [
    'provider' => env('CHAT_WEBHOOK_PROVIDER', 'synology_chat'),
    'verify_token' => env('CHAT_WEBHOOK_VERIFY_TOKEN', ''),
    'allowed_ips' => array_values(array_filter(array_map(
        static fn ($ip) => trim($ip),
        explode(',', (string) env('CHAT_WEBHOOK_ALLOWED_IPS', ''))
    ))),
    'enable_signature_check' => filter_var(
        env('CHAT_WEBHOOK_ENABLE_SIGNATURE_CHECK', false),
        FILTER_VALIDATE_BOOL
    ),
    'signature_header' => env('CHAT_WEBHOOK_SIGNATURE_HEADER', 'X-Webhook-Signature'),
    'signature_secret' => env('CHAT_WEBHOOK_SIGNATURE_SECRET', ''),
    'log_payload' => filter_var(env('CHAT_WEBHOOK_LOG_PAYLOAD', true), FILTER_VALIDATE_BOOL),
];
