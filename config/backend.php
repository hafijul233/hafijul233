<?php

use App\Supports\Constant;

return [
    'name' => 'Core',
    'guard' => [
        'web' => 'WEB',
        'api' => 'API'
    ],
    /*
    |--------------------------------------------------------------------------
    | Application Preloader
    |--------------------------------------------------------------------------
    |
    | Preloader that will display when as webpage is very slow.
    | Null if we don't want preloader default enabled
    |
    | @var string|null
    */

    'preloader' => 'assets/img/logo.png',

    /*
    |--------------------------------------------------------------------------
    | Application Default Date & Time Format
    |--------------------------------------------------------------------------
    |
    | Format for date and time setting
    |
    | @var string|null
    */

    'datetime' => 'd M Y h:i a',

    'date' => 'd M Y',

    'time' => 'h:i a',

    /*
    |--------------------------------------------------------------------------
    | Application JavaScript Default Date & Time Format
    |--------------------------------------------------------------------------
    |
    | Null if we don't want preloader default enabled
    |
    | @ref use 'js' as prefix for every field
    | @ref follow moment.js for details
    |
    | @var string|null
    */

    'js_datetime' => 'DD MMM YYYY hh:mm a',

    'js_date' => 'DD MMM YYYY',

    'js_time' => 'hh:mm a',

    /*
    |--------------------------------------------------------------------------
    | Application JavaScript Default Date & Time Format
    |--------------------------------------------------------------------------
    |
    | Null if we don't want preloader default enabled
    |
    | @ref use 'js' as prefix for every field
    | @ref follow moment.js for details
    |
    | @var string|null
    */
    'settings' => [
        /*'country' => [
            'module' => 'Contact',
            'name' => 'Country',
            'icon' => 'fas fa-globe',
            'route' => 'backend.settings.countries.index',
            'color' => '#007bff',
            'description' => 'Countries list on this system',
            'enabled' => Constant::ENABLED_OPTION
        ],*/
        'state' => [
            'module' => 'Contact',
            'name' => 'State',
            'icon' => 'fas fa-mountain',
            'route' => 'backend.settings.states.index',
            'color' => '#007bff',
            'description' => 'states available on countries',
            'enabled' => Constant::ENABLED_OPTION
        ],
/*        'city' => [
            'module' => 'Contact',
            'name' => 'City',
            'icon' => 'fas fa-building',
            'route' => 'backend.settings.cities.index',
            'color' => '#007bff',
            'description' => 'user who can access this system',
            'enabled' => Constant::ENABLED_OPTION
        ],
        'blood-group' => [
            'module' => 'Contact',
            'name' => 'Blood Group',
            'icon' => 'fas fa-object-group',
            'route' => 'backend.settings.blood-groups.index',
            'color' => '#007bff',
            'description' => 'user who can access this system',
            'enabled' => Constant::ENABLED_OPTION
        ],
        'gender' => [
            'module' => 'Contact',
            'name' => 'Gender',
            'icon' => 'fas fa-venus-mars',
            'route' => 'backend.settings.genders.index',
            'color' => '#007bff',
            'description' => 'user who can access this system',
            'enabled' => Constant::ENABLED_OPTION
        ],
        'occupation' => [
            'module' => 'Contact',
            'name' => 'ExamGroup',
            'icon' => 'fas fa-user-md',
            'route' => 'backend.settings.occupations.index',
            'color' => '#007bff',
            'description' => 'user who can access this system',
            'enabled' => Constant::ENABLED_OPTION
        ],
        'relation' => [
            'module' => 'Contact',
            'name' => 'Relation',
            'icon' => 'fas fa-people-arrows',
            'route' => 'backend.settings.relations.index',
            'color' => '#007bff',
            'description' => 'user who can access this system',
            'enabled' => Constant::ENABLED_OPTION
        ],
        'religion' => [
            'module' => 'Contact',
            'name' => 'Religion',
            'icon' => 'fas fa-place-of-worship',
            'route' => 'backend.settings.religions.index',
            'color' => '#007bff',
            'description' => 'user who can access this system',
            'enabled' => Constant::ENABLED_OPTION
        ],*/
        'user' => [
            'module' => 'Core',
            'name' => 'User',
            'icon' => 'fas fa-users',
            'route' => 'backend.settings.users.index',
            'color' => '#007bff',
            'description' => 'user who can access this system',
            'enabled' => Constant::ENABLED_OPTION
        ],
        'role' => [
            'module' => 'Core',
            'name' => 'Role',
            'icon' => 'fas fa-address-card',
            'route' => 'backend.settings.roles.index',
            'color' => '#007bff',
            'description' => 'user who can access this system',
            'enabled' => Constant::ENABLED_OPTION
        ],
        'permission' => [
            'module' => 'Core',
            'name' => 'Permission',
            'icon' => 'fas fa-list-alt',
            'route' => 'backend.settings.permissions.index',
            'color' => '#007bff',
            'description' => 'user who can access this system',
            'enabled' => Constant::ENABLED_OPTION
        ],
        'catalog' => [
            'module' => 'Core',
            'name' => 'Catalog',
            'icon' => 'fas fa-clipboard-list',
            'route' => 'backend.settings.catalogs.index',
            'color' => '#007bff',
            'description' => 'user who can access this system',
            'enabled' => Constant::ENABLED_OPTION
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Footer Copyrights
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'copyright' => env('APP_COPYRIGHTS', env('APP_NAME', 'Laravel')),

    /*
    |--------------------------------------------------------------------------
    | Application Footer Copyrights
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'sidebar' => env('APP_SHORT_NAME', env('APP_NAME', 'Laravel')),

    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'version' => env('APP_VERSION', '1.0'),


];
