<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;

class EncryptCookies extends BaseEncrypter
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /**** EncryptCookie override functions ****/
    /* Copied from "/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php" */

    /**
     * The encrypter instance.
     *
     * @var \Illuminate\Contracts\Encryption\Encrypter
     */
    protected $encrypter;

    /**
     * Create a new CookieGuard instance.
     *
     * @param  \Illuminate\Contracts\Encryption\Encrypter  $encrypter
     * @return void
     */
    public function __construct(EncrypterContract $encrypter) {
        $this->encrypter = $encrypter;
        $cookieNames = config('cookie_config.unguarded_cookies', []);
        $this->except = $cookieNames;
    }
}
