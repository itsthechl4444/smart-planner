<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Here you may specify an array of paths that should be checked for
    | your views. The first path in the array is used by default.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade views will be stored.
    | A typical value for this is storage_path('framework/views') which is
    | the default for most installations.
    |
    */

    'compiled' => env('VIEW_COMPILED', realpath(storage_path('framework/views'))),

];
