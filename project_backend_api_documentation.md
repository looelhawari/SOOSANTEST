# Drilling Dashboard Backend Documentation

## Overview
This document provides a detailed overview of the backend logic, routes, and API endpoints for the Drilling Dashboard Laravel project. It is intended for frontend developers to understand how to integrate with the backend, including authentication, admin/user management, product and report APIs, and general architectural notes.

---

## Table of Contents
1. [Authentication](#authentication)
2. [User & Admin Management](#user--admin-management)
3. [Products & Categories](#products--categories)
4. [Sold Products](#sold-products)
5. [Reports](#reports)
6. [Notifications](#notifications)
7. [Contact Messages](#contact-messages)
8. [General API Notes](#general-api-notes)
9. [Route Structure](#route-structure)
10. [Middleware](#middleware)

---

## 1. Authentication
- **Login:** `POST /admin/login` (admin panel), `POST /api/login` (API)
- **Logout:** `POST /admin/logout`, `POST /api/logout`
- **Session:** Laravel session-based for admin, token-based for API
- **Registration:** Usually handled by admins (no public registration)
- **Password Reset:** Standard Laravel password reset endpoints

## 2. User & Admin Management
- **List Users:** `GET /admin/users` (Blade), `GET /api/users` (API)
- **Show User:** `GET /admin/users/{id}` (Blade), `GET /api/users/{id}` (API)
- **Create User:** `POST /admin/users` (Blade/API)
- **Edit User:** `PUT/PATCH /admin/users/{id}` (Blade/API)
- **Delete User:** `DELETE /admin/users/{id}` (Blade/API)
- **Roles:** Users have roles (Admin, Employee, etc.)
- **Status:** Users can be verified/unverified, active/inactive

## 3. Products & Categories
- **List Products:** `GET /admin/products`, `GET /api/products`
- **Show Product:** `GET /admin/products/{id}`, `GET /api/products/{id}`
- **Create Product:** `POST /admin/products`
- **Edit Product:** `PUT/PATCH /admin/products/{id}`
- **Delete Product:** `DELETE /admin/products/{id}`
- **Categories:** Similar CRUD endpoints for `/admin/product-categories` and `/api/product-categories`

## 4. Sold Products
- **List Sold Products:** `GET /admin/sold-products`, `GET /api/sold-products`
- **Show Sold Product:** `GET /admin/sold-products/{id}`
- **Create/Edit/Delete:** Standard RESTful endpoints

## 5. Reports
- **List Reports:** `GET /admin/reports`, `GET /api/reports`
- **Show Report:** `GET /admin/reports/{id}`
- **Specialized Reports:** `/admin/reports/sales`, `/admin/reports/owners`, `/admin/reports/comprehensive`

## 6. Notifications
- **List Notifications:** `GET /admin/notifications`, `GET /api/notifications`
- **Mark as Read:** `POST /admin/notifications/{id}/read`
- **Real-time:** Uses Laravel notifications, can be polled or pushed

## 7. Contact Messages
- **List Messages:** `GET /admin/contact-messages`, `GET /api/contact-messages`
- **Show Message:** `GET /admin/contact-messages/{id}`
- **Delete:** `DELETE /admin/contact-messages/{id}`

## 8. General API Notes
- **Format:** JSON for all API endpoints
- **Auth:** Most API endpoints require Bearer token (JWT or Laravel Sanctum)
- **Validation:** Standard Laravel validation, errors returned as JSON
- **Pagination:** Most list endpoints support `?page=`, `?per_page=`
- **Filtering/Sorting:** Many endpoints accept query params for filtering/sorting

## 9. Route Structure
- **Web (Blade/Admin):**
  - `/admin/*` (protected by `auth`, `admin` middleware)
  - `/` (public frontend, not covered here)
- **API:**
  - `/api/*` (protected by `auth:api` or `sanctum`)
  - See `routes/api.php` for details

## 10. Middleware
- **auth:** Requires authentication
- **admin:** Requires admin role
- **employee.permission:** Restricts access to employee-only features
- **locale:** Handles language switching
- **csrf:** CSRF protection for web routes

---

## Example API Request
```
GET /api/users?role=employee&status=active
Authorization: Bearer <token>
Accept: application/json
```

## Example API Response
```
{
  "data": [
    {
      "id": 1,
      "name": "Admin Ali",
      "email": "admin@example.com",
      "role": "Admin",
      "status": "active",
      ...
    },
    ...
  ],
  "meta": {
    "current_page": 1,
    "last_page": 3,
    "per_page": 15,
    "total": 45
  }
}
```

---

## For More Details
- See `routes/api.php` and `routes/admin.php` for all endpoints
- See `app/Http/Controllers/Api/` for API logic
- See `app/Models/` for Eloquent models and relationships
- Contact backend team for custom integration needs

---

*This documentation is up to date as of July 8, 2025.*
