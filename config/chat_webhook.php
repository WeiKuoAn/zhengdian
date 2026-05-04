<?php

return [
    'provider' => env('CHAT_WEBHOOK_PROVIDER', 'synology_chat'),
    'verify_token' => env('CHAT_WEBHOOK_VERIFY_TOKEN', ''),
    'synology_host' => env('SYNOLOGY_CHAT_HOST', ''),
    'synology_token' => env('SYNOLOGY_CHAT_TOKEN', ''),
    'synology_bot_token' => env('SYNOLOGY_CHAT_BOT_TOKEN', ''),
    /** 選填：發「頻道」訊息時使用。私訊（DM）只要 payload 有 user_ids 即可，不必設定此項 */
    'synology_dispatch_channel_id' => env('SYNOLOGY_CHAT_DISPATCH_CHANNEL_ID', ''),
    'synology_outgoing_token' => env('SYNOLOGY_CHAT_OUTGOING_TOKEN', ''),
    'synology_slash_token' => env('SYNOLOGY_CHAT_SLASH_TOKEN', ''),
    /** 選填：僅給 /search 斜線指令用的識別 token（與 SYNOLOGY_CHAT_SLASH_TOKEN 擇一或並存均可） */
    'synology_search_slash_token' => env('SYNOLOGY_CHAT_SEARCH_SLASH_TOKEN', ''),
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
