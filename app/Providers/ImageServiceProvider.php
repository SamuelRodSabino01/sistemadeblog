<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\ImageHelper;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('image.helper', function ($app) {
            return new ImageHelper();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Registra aliases globais se necessário
        if (!class_exists('ImageHelper')) {
            class_alias(ImageHelper::class, 'ImageHelper');
        }
    }
}
