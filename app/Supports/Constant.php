<?php


namespace App\Supports;

/**
 * Class Constant
 * @package App\Supports
 */
class Constant
{
    /**
     * System Model Status
     */
    const ENABLED_OPTIONS = ['yes' => 'Yes', 'no' => 'No'];

    /**
     * System User Permission Guards
     */
    const PERMISSION_GUARDS = ['web' => 'WEB'];

    /**
     * System Permission Title Constraint
     */
    const PERMISSION_NAME_ALLOW_CHAR = '([a-zA-Z0-9.-_]+)';

    /**
     * Keyword to purge Soft Deleted Models
     */
    const PURGE_MODEL_QSA = 'purge';

    /**
     * Timing Constants
     */
    const SECOND = '1';
    const MINUTE = '60';
    const HOUR = '3600';
    const DAY = '86400';
    const WEEK = '604800';
    const MONTH = '2592000';
    const YEAR = '31536000';
    const DECADE = '315360000'; //1de=10y

    /**
     * Toastr Message Levels
     */
    const MSG_TOASTR_ERROR = 'error';
    const MSG_TOASTR_WARNING = 'warning';
    const MSG_TOASTR_SUCCESS = 'success';
    const MSG_TOASTR_INFO = 'info';

    /**
     * Authentication Login Medium
     */
    const LOGIN_EMAIL = 'email';
    const LOGIN_USERNAME = 'username';
    const LOGIN_MOBILE = 'mobile';
    const LOGIN_OTP = 'otp';

    /**
     * OTP Medium Source
     */
    const OTP_MOBILE = 'mobile';
    const OTP_EMAIL = 'email';

    const EXPORT_OPTIONS = [
        'xlsx' => 'Microsoft Excel (.xlsx)',
        'ods' => 'Open Document Spreadsheet (.ods)',
        'csv' => 'Comma Seperated Values (.csv)'
    ];


    /**
     * Default Role Name for system administrator
     */
    const SUPER_ADMIN_ROLE = 'Super Administrator';

    /**
     * Default Email Address for backend admin panel
     */
    const EMAIL = 'hafijul233@gmail.com';

    /**
     * Default model enabled status
     */
    const ENABLED_OPTION = 'yes';

    /**
     * Default model disabled statusENABLED_OPTION
     */
    const DISABLED_OPTION = 'no';

    /**
     * Default Password
     */
    const PASSWORD = 'password';

    /**
     * Default profile display image is user image is missing
     */
    const USER_PROFILE_IMAGE = '/assets/img/AdminLTELogo.png';

    /**
     * Default Logged User Redirect Route
     */
    const DASHBOARD_ROUTE = 'backend.dashboard';

    const LOCALE = 'en';

    /**
     * Default Exp[ort type
     */
    const EXPORT_DEFAULT = 'xlsx';
    /**
     * CATALOG TYPES
     */
    const CATALOG_TYPE = [
        "GENDER" => 'GEN',
        "MARITAL_STATUS" => 'MAS',
        "RELIGION" => 'REL',
        "UNIVERSITY" => 'UNI',
        "BOARD" => 'BOR',
        "QUOTA" => 'QOT'
    ];
    /**
     * CATALOG TYPES
     */
    const CATALOG_LABEL = [
        "GEN" => 'Gender',
        "MAS" => 'Marital Status',
        "REL" => 'Religion',
        "UNI" => 'University',
        "BOR" => 'Board',
        "QOT" => 'Quote'
    ];

    const GPA_TYPE = [
        1 => "1st Division",
        2 => "2nd Division",
        3 => "3rd Division",
        4 => "GPA(Out of 4)",
        5 => "GPA(Out of 5)",
        6 => "Others",

    ];
}
