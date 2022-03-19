<?php

use Yoeunes\Notify\Notifiers\Pnotify;
use Yoeunes\Notify\Notifiers\SweetAlert2;
use Yoeunes\Notify\Notifiers\Toastr;

return [

    'default' => 'toastr',

    'toastr' => [

        'class' => Toastr::class,

        'notify_js' => [
            env('ASSET_URL', 'http://127.0.0.1:8000') . '/plugins/toastr/toastr.min.js',
        ],

        'notify_css' => [
            env('ASSET_URL', 'http://127.0.0.1:8000') . '/plugins/toastr/toastr.min.css',
        ],

        'types' => [
            'error',
            'info',
            'success',
            'warning',
        ],

        'options' => [
            'closeButton' => true,
            'progressBar' => true,
            'preventDuplicates' => true
        ],
    ],

    'pnotify' => [

        'class' => Pnotify::class,

        'notify_js' => [
            /*            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',*/
            'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js',
        ],

        'notify_css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css',
            'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.brighttheme.css',
        ],

        'types' => [
            'alert',
            'error',
            'info',
            'notice',
            'success',
        ],

        'options' => [],
    ],

    'sweetalert2' => [

        'class' => SweetAlert2::class,

        'notify_js' => [
            /*            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',*/
            'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.1/sweetalert2.min.js',
            'https://cdn.jsdelivr.net/npm/promise-polyfill/dist/polyfill.min.js',
        ],

        'notify_css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.1/sweetalert2.min.css',
        ],

        'types' => [
            'error',
            'info',
            'question',
            'success',
            'warning',
        ],

        'options' => [],
    ],
];
