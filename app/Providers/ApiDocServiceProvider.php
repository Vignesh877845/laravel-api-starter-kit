<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Illuminate\Support\ServiceProvider;

class ApiDocServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Scramble::extendOpenApi(function (OpenApi $openApi) {
            $openApi->info->title = 'Laravel API Starter Kit';
            $openApi->info->version = '1.0.0';
            $openApi->info->description = "
            ## Overview

            This Laravel API Starter Kit provides a structured and production-ready foundation for building scalable RESTful APIs. The project follows clean architecture principles and emphasizes maintainability, security, and consistency.

            ---

            ## Core Features

            - Service Layer pattern for clear separation of business logic.
            - Token-based authentication powered by Laravel Sanctum.
            - UUID primary keys for improved security and distributed system compatibility.
            - Role-Based Access Control (RBAC) integration.
            - Standardized JSON API responses.
            - Versioned API structure (`/api/v1`).

            ---

            ## Authentication

            All protected endpoints require a Bearer token.

            1. Authenticate using the login endpoint.
            2. Include the access token in the request header:

            Authorization: Bearer {access_token}

            ---

            ## Base URL

            The API is versioned and accessible via:

            http://your-domain.test/api/v1
            ";
        });

    }
}
