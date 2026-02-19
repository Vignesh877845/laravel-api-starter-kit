# Laravel API Starter Kit (v1.0.0)

## 📌 Project Overview
A production-ready Laravel API template designed for scalability and maintainability. This starter kit implements modern best practices, follows a structured Service Layer Pattern, UUID-based primary keys, and Role-Based Access Control (RBAC).

## 🛠 Core Features
* **Clean Architecture:** Strict separation of concerns using a dedicated Service layer to handle business logic.
* **Authentication:** Token-based authentication powered by Laravel Sanctum.
* **UUID Primary Keys:** Core models use UUIDs instead of auto-increment IDs for improved security and distributed system compatibility.
* **Role-Based Access Control:** Fully integrated with the Spatie Permission package for granular access management.
* **Standardized API Responses:** Implements a custom `ApiResponses` trait to ensure a consistent JSON structure across all endpoints.
* **Soft Deletes:** Optional model-level soft delete support to prevent accidental data loss.

## 🔐 Authentication Flow
* **Access:** Use the provided registration or login endpoints to authenticate.
* **Automation:** On a successful login, a post-response script automatically updates the `auth_token` in the collection variables.
* **Authorization:** All protected endpoints are pre-configured to use the `{{auth_token}}` variable as a Bearer token.
