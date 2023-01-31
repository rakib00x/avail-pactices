<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'verify',
        'forgotPassword',
        'getUnreadMessage',
        'loadSupplierInfo',
        'loadSupplierChat',
        'chatDetails',
        'saveSupplierMessage',
        'saveMessage',
        'loadMessagesSecond',
        'loadMessages',
        'loadMessagesOnDocumentReady',
        'message',
        'getMessage',
        'chat',
        'sendsuppliercontactmessage',
        'mobilelogin',
        'getsearchproductresutlistview',
        'getThana'
    ];
}
