<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Cipher
    |--------------------------------------------------------------------------
    |
    | This cipher determines the algorithm that will be used to encrypt the
    | strings. By default, we will use the AES-256-CBC cipher. Please do not
    | change it unless you understand the ramifications.
    |
    */

    'cipher' => 'AES-256-CBC',

];
