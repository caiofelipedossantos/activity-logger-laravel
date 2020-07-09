<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Database Migration
    |--------------------------------------------------------------------------
    */

    'table' => [
        'name' => 'activity_logger',
        'columns' => [
            'id' => 'id',
            'description' => 'description',
            'userType' => 'userType',
            'userId' => 'userId',
            'route' => 'route',
            'ipAddress' => 'ipAddress',
            'userAgent' => 'userAgent',
            'locale' => 'locale',
            'referer' => 'referer',
            'methodType' => 'methodType',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default User ID Field
    |--------------------------------------------------------------------------
    */
    'defaultUserIDField' => 'id',

    /*
    |--------------------------------------------------------------------------
    | Failed to Log Settings
    |--------------------------------------------------------------------------
    */
    'logDBActivityLoggerFailuresToFile' => true,

    /*
    |--------------------------------------------------------------------------
    | Data Base Settings
    |--------------------------------------------------------------------------
    */

    'activityLoggerDatabaseConnection' => 'mysql',

    'defaultUserModel' => 'App\User',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    */

    'loggerMiddlewareExcept' => array_filter(explode(',', trim('ignore1pattern1,ignorepattern2'))),

    /*
    |--------------------------------------------------------------------------
    | Authentication Listeners Enable/Disable
    |--------------------------------------------------------------------------
    */
    'logAllAuthEvents'      => false,
    'logAuthAttempts'       => false,
    'logFailedAuthAttempts' => true,
    'logLockOut'            => true,
    'logPasswordReset'      => true,
    'logSuccessLogin'    => true,
    'logSuccessLogout'   => true,
];
