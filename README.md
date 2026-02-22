# Laravel API Starter Kit

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

A production-ready Laravel API template designed for **Clean Architecture**, **Scalability**, and **Maintainability**. This kit leverages the latest **Laravel 12** features to provide a robust foundation for modern web applications.

---

## Key Dependencies & Features

* **Laravel 12 Framework:** Built on Laravel 12 for modern API development.
* **Service Layer Pattern:** Dedicated services to isolate business logic from controllers.
* **Authentication (Sanctum):** Lightweight, secure token-based authentication with multi-device support.
* **RBAC (Spatie Permission):** Powerful role and permission management integrated out-of-the-box.
* **UUID Security:** Core models utilize UUIDs as primary keys for distributed system compatibility.
* **Auto-Docs (Scramble):** Zero-config OpenAPI documentation accessible at `/docs/api`.
* **Custom CLI:** Includes a `make:api` command to scaffold versioned API components instantly.

---

## Architecture Overview

- Versioned API structure (Api/V1)
- Service layer separation
- Form Request validation
- Role-based authorization
- UUID-based models

---

### Controller Structure

- `ApiController` → Base controller for API endpoints (uses ApiResponses trait for standardized JSON responses).
- `Controller` → Base controller for Web (Blade/Inertia) controllers.

---

## Requirements

* **PHP:** ^8.2
* **Laravel:** ^12.0

---

## Quick Installation

1.  **Clone the project:**
    ```bash
    git clone https://github.com/Vignesh877845/laravel-api-starter-kit.git
    cd laravel-api-starter-kit
    ```

2.  **Install & Automate Setup:**
    ```bash
    composer setup
    ```

> **Note:** The `composer setup` command automatically handles `.env` creation, key generation, and database migrations with seeding.

---

## Custom CLI Usage

Generate versioned API components:

```bash
php artisan make:api controller User --ver=V1
php artisan make:api request UserStoreRequest --ver=V1
```

> **Note:** The `--ver` option specifies the API version. It is optional and defaults to `V1` if omitted. To generate components for another version (e.g., `V2`), use `--ver=V2`.