<?php

namespace SamAsEnd\KeyRotate\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use SamAsEnd\KeyRotate\KeyRotateServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        copy(
            __DIR__.'/../vendor/orchestra/testbench-core/laravel/.env.example',
            __DIR__.'/../vendor/orchestra/testbench-core/laravel/.env',
        );
    }

    protected function getPackageProviders($app): array
    {
        return [KeyRotateServiceProvider::class];
    }
}
