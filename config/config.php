<?php

return [
    'instrumentation_key' => env('AZ_INSTRUMENTATION_KEY'),
    'disable_tracking'    => env('AZ_APP_INS_DISABLED', false),
    'http_errors'         => env('AZ_APP_INS_ERROR', false),
];