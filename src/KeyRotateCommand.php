<?php

namespace SamAsEnd\KeyRotate;

use Illuminate\Foundation\Console\KeyGenerateCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'key:rotate')]
class KeyRotateCommand extends KeyGenerateCommand
{
    protected $signature = 'key:rotate
                    {--show : Display the key instead of modifying files}
                    {--force : Force the operation to run when in production}';

    protected $description = 'Rotate the application key';

    /**
     * Set the application key in the environment file.
     *
     * @param  string  $key
     */
    protected function setKeyInEnvironmentFile($key): bool
    {
        $currentKey = $this->laravel['config']['app.key'];

        if (strlen($currentKey) !== 0 && (! $this->confirmToProceed())) {
            return false;
        }

        // Our magic starts here
        if (strlen($currentKey) !== 0) {
            $this->rotateExistingKeysWith($currentKey);
        }
        // Our magic ends here

        if (! $this->writeNewEnvironmentFileWith($key)) {
            return false;
        }

        return true;
    }

    /**
     * Rotates application keys in the Laravel environment file.
     */
    protected function rotateExistingKeysWith($currentKey): void
    {
        $previousKeys = [$currentKey, ...$this->laravel['config']['app.previous_keys'] ?? []];

        $newLine = 'APP_PREVIOUS_KEYS='.implode(',', $previousKeys);

        $replaced = preg_replace(
            $this->previousKeysReplacementPattern(),
            $newLine,
            $input = file_get_contents($this->laravel->environmentFilePath())
        );

        if ($replaced === $input || $replaced === null) {
            file_put_contents(
                $this->laravel->environmentFilePath(),
                PHP_EOL.$newLine.PHP_EOL,
                FILE_APPEND
            );

            return;
        }

        file_put_contents($this->laravel->environmentFilePath(), $replaced);
    }

    /**
     * Get a regex pattern that will match env APP_PREVIOUS_KEYS with any set of previous keys.
     */
    protected function previousKeysReplacementPattern(): string
    {
        $escaped = preg_quote('='.implode(',', $this->laravel['config']['app.previous_keys'] ?? []), '/');

        return "/^APP_PREVIOUS_KEYS{$escaped}/m";
    }
}
