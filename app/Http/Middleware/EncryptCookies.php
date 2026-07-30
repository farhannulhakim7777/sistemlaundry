<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * Cookie yang tidak perlu dienkripsi.
     *
     * @var array<int, string>
     */
    protected $except = [];
}
