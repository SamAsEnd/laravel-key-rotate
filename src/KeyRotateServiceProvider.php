<?php

namespace SamAsEnd\KeyRotate;

use Illuminate\Support\ServiceProvider;

class KeyRotateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([KeyRotateCommand::class]);
        }
    }

    public function provides(): array
    {
        return [KeyRotateCommand::class];
    }
}
