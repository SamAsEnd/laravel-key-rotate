<?php

namespace SamAsEnd\KeyRotate\Tests;

use Illuminate\Support\Facades\App;
use Orchestra\Testbench\Concerns\WithWorkbench;

class KeyRotateCommandTest extends TestCase
{
    use WithWorkbench;

    public function test_it_can_rotate_the_application_key()
    {
        config(['app.previous_keys' => []]);

        $currentKey = env('APP_KEY');

        $this->artisan('key:rotate')
            ->expectsOutputToContain('Application key set successfully.')
            ->assertSuccessful();

        $this->assertStringContainsString(
            "APP_PREVIOUS_KEYS=$currentKey\n",
            file_get_contents(App::environmentFilePath())
        );
    }

    public function test_it_can_rotate_the_application_key_with_previous_keys()
    {
        config(['app.previous_keys' => ['base64:previous_key_1']]);

        $currentKey = env('APP_KEY');

        $this->artisan('key:rotate')
            ->expectsOutputToContain('Application key set successfully.')
            ->assertSuccessful();

        $this->assertStringContainsString(
            "APP_PREVIOUS_KEYS=$currentKey,base64:previous_key_1\n",
            file_get_contents(App::environmentFilePath())
        );
    }

    public function test_it_do_not_rotate_the_application_key_when_in_production()
    {
        $this->app->detectEnvironment(fn () => 'production');

        $this->artisan('key:rotate')
            ->expectsConfirmation('Are you sure you want to run this command?')
            ->expectsOutputToContain('APPLICATION IN PRODUCTION.')
            ->expectsOutputToContain('WARN  Command cancelled.')
            ->doesntExpectOutput('Application key set successfully.')
            ->assertSuccessful();

        $this->app->detectEnvironment(fn () => 'testing');
    }
}
