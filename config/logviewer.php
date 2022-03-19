<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pattern and storage path settings
    |--------------------------------------------------------------------------
    |
    | The env key for pattern and storage path with a default value
    |
    */
    'max_file_size' => 31457280, // size in Byte
    'pattern'       => env('LOGVIEWER_PATTERN', '*.log'),
    'storage_path'  => env('LOGVIEWER_STORAGE_PATH', storage_path('logs')),
];
