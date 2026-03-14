<?php

declare(strict_types=1);

namespace Oxiginedev\Termii;

use Illuminate\Support\ServiceProvider;
use Override;

final class TermiiServiceProvider extends ServiceProvider
{
    /**
     * Register the application services
     */
    #[Override]
    public function register(): void
    {
        $this->app->singleton(Termii::class, Termii::class);
    }

    /**
     * Bootstrap the application services
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->mergeConfigFrom(
                __DIR__.'/../config/termii.php',
                'services'
            );
        }
    }
}
