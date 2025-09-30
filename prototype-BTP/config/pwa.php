<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Would you like the install button to appear on all pages?
      Set true/false
    |--------------------------------------------------------------------------
    */

    'install-button' => false,

    /*
    |--------------------------------------------------------------------------
    | PWA Manifest Configuration
    |--------------------------------------------------------------------------
    |  php artisan erag:pwa-update-manifest
    */

    'manifest' => [
        'name' => 'SpaceRent BTP - v1',
        'short_name' => 'SpaceRentBTP',
        'description' => 'Website yang menyediakan penyewaan ruangan di Bandung Techno Park yang mudah dan terpercaya.',
        'scope' => '/',
        'start_url' => '/dashboardPenyewa',
        'display_override' => ["window-controls-overlay", "standalone"],
        'display' => 'standalone',
        'orientation' => 'natural',
        'background_color' => '#ffffff',
        'theme_color' => '#419343',
        'lang' => 'id',
        'icons' => [
            [
                'src' => '/assets/img/logoHead-192x192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'src' => '/assets/img/logoHead-192x192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'maskable',
            ],
            [
                'src' => '/assets/img/logoHead-512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'src' => '/assets/img/logoHead-512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'maskable',
            ],
        ],
        'screenshots' => [
            [
                'src' => 'assets/img/Desktop/pwa-screenshot-wide.png',
                'sizes' => "3840x2205",
                'type' => "image/png",
                'form_factor' => "wide",
            ],
            [
                'src' => 'assets/img/Mobile/pwa-screenshot-mobile.png',
                'sizes' => "405x881",
                'type' => "image/png",
                'form_factor' => "narrow",
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug Configuration
    |--------------------------------------------------------------------------
    | Toggles the application's debug mode based on the environment variable
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Livewire Integration
    |--------------------------------------------------------------------------
    | Set to true if you're using Livewire in your application to enable
    | Livewire-specific PWA optimizations or features.
    */

    'livewire-app' => false,
];
