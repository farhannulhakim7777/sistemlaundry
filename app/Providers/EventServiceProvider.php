<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Tambahkan event listener jika diperlukan.
    ];

    public function boot()
    {
        // Event booting.
    }
}
