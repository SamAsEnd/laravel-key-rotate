# Laravel [Key Rotate](https://laravel.com/docs/11.x/encryption#gracefully-rotating-encryption-keys)

[![Github Actions](https://github.com/SamAsEnd/laravel-key-rotate/actions/workflows/tests.yml/badge.svg)](https://github.com/SamAsEnd/laravel-key-rotate/actions/workflows/tests.yml)
![From Ethiopia](https://img.shields.io/badge/From-Ethiopia-brightgreen?style=plastic)
[![Total Downloads](https://img.shields.io/packagist/dt/samasend/laravel-key-rotate?style=plastic)](https://packagist.org/packages/samasend/laravel-key-rotate)
[![Latest Stable Version](https://img.shields.io/packagist/v/samasend/laravel-key-rotate?style=plastic)](https://packagist.org/packages/samasend/laravel-key-rotate)
[![License](https://img.shields.io/packagist/l/samasend/laravel-key-rotate?style=plastic)](https://packagist.org/packages/samasend/laravel-key-rotate)

Laravel Key Rotate is a package that extends Laravel's built-in `key:generate` command, providing a simple and efficient way to rotate your Laravel application's key.

This is particularly useful for maintaining the security and integrity of your application by ensuring that the encryption key is regularly updated.

## Prerequisites
  - **PHP** >= 8.2
  - **Laravel** >= 11.x

## Installation

You can install the package via composer:

```bash
composer require samasend/laravel-key-rotate
```

## Usage

To rotate your application key, simply run the following artisan command:

```bash
php artisan key:rotate
```

This command will generate a new application key and update your `.env` file.
The previous key will be stored in the `APP_PREVIOUS_KEYS` environment variable, allowing for graceful key rotation.

## How It Works

The `key:rotate` command extends Laravel's built-in `key:generate` command. When run, it generates a new application key as usual. However, instead of simply replacing the old key, it stores the old key in the `APP_PREVIOUS_KEYS` environment variable. This allows for a smooth transition to the new key, as the old key is still available for decrypting any data that was encrypted with it.

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
