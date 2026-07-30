<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Semua form web tetap dilindungi token CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [];
}
