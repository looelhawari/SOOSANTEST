# Drilling Dashboard Project: Full Backend & API Documentation

**Last updated:** July 8, 2025

---

## 1. Project Overview
This Laravel project powers the Drilling Dashboard, a business management platform with:
- Admin panel (user/product/report management, notifications, audit logs, etc.)
- Public frontend (not covered here)
- RESTful API endpoints for integration

---

## 2. Main Backend Structure
- **Controllers:**
  - `app/Http/Controllers/Admin/` — All admin panel logic (users, products, reports, etc.)
  - `app/Http/Controllers/Api/` — API endpoints (notifications, user info, etc.)
  - `app/Http/Controllers/` — Public, auth, and shared logic
- **Models:**
  - `User`, `Product`, `ProductCategory`, `SoldProduct`, `Owner`, `ContactMessage`, `PendingChange`, `AuditLog`, `Banner`
- **Routes:**
  - `routes/web.php` — Public and shared routes
  - `routes/admin.php` — Admin panel routes
  - `routes/api.php` — API endpoints
- **Middleware:**
  - `auth`, `admin`, `employee.permission`, `locale`, `csrf`, etc.

---

## 3. Authentication & Authorization
- **Admin Panel:** Session-based, uses Laravel's `auth` middleware
- **API:** Token-based (Laravel Sanctum)
- **Roles:** Users have roles (Admin, Employee, etc.)
- **Middleware:**
  - `auth` — Requires login
  - `admin` — Restricts to admin users
  - `employee.permission` — Restricts to employees

---

## 4. Route & API Reference

### 4.1. Admin Panel Routes (`/admin/*`)
- **Login:** `GET/POST /admin/login`
- **Logout:** `POST /admin/logout`
- **Dashboard:** `GET /admin/dashboard`
- **Users:**
  - `GET /admin/users` (list)
  - `GET /admin/users/{id}` (show)
  - `POST /admin/users` (create)
  - `PUT/PATCH /admin/users/{id}` (update)
  - `DELETE /admin/users/{id}` (delete)
  - `PATCH /admin/users/{id}/toggle-status` (activate/deactivate)
- **Products:**
  - `GET /admin/products`, `POST /admin/products`, etc. (standard CRUD)
- **Product Categories:**
  - `GET /admin/product-categories`, etc.
- **Sold Products:**
  - `GET /admin/sold-products`, etc.
- **Owners:**
  - `GET /admin/owners`, etc.
- **Contact Messages:**
  - `GET /admin/contact-messages`, etc.
- **Pending Changes:**
  - `GET /admin/pending-changes`, `POST /admin/pending-changes/{id}/approve`, etc.
- **Audit Logs:**
  - `GET /admin/audit-logs`, `GET /admin/audit-logs/dashboard`, etc.
- **Reports:**
  - `GET /admin/reports`, `GET /admin/reports/comprehensive`, etc.

### 4.2. API Endpoints (`/api/*`)
- **User Info:** `GET /api/user` (requires Bearer token)
- **Notifications:** (see web.php for session-based AJAX)
- **Other endpoints:** Most business logic is in admin panel, but can be exposed via API as needed.

### 4.3. Public Routes (`/`)
- **Homepage:** `GET /`
- **Products:** `GET /products`, `GET /products/{id}`
- **Contact:** `GET/POST /contact`
- **Serial Lookup:** `GET/POST /serial-lookup`

---

## 5. Models & Relationships
- **User:** Has roles, notifications, products, etc.
- **Product:** Belongs to category, has owner, can be sold
- **ProductCategory:** Has many products
- **SoldProduct:** Belongs to product, owner, user
- **Owner:** Has many products/sold products
- **ContactMessage:** User/customer messages
- **PendingChange:** Tracks pending admin actions
- **AuditLog:** System activity logs

---

## 6. Example API Usage

### Authentication (API)
```
POST /api/login
{
  "email": "admin@example.com",
  "password": "..."
}
```
Returns: `{ "token": "..." }`

### Get Users (API)
```
GET /api/users?role=employee&status=active
Authorization: Bearer <token>
Accept: application/json
```
Returns paginated user list.

---

## 7. Integration Notes
- **All API endpoints return JSON.**
- **Admin panel uses Blade views, but can be adapted for SPA/JS frontend.**
- **For new API endpoints, add controllers in `app/Http/Controllers/Api/` and register in `routes/api.php`.**
- **Use Bearer token for API, session for admin panel.**
- **See controllers for validation rules and business logic.**

---

## 8. Directory Structure (Key Parts)
```
app/
  Http/
    Controllers/
      Admin/         # Admin panel logic
      Api/           # API endpoints
      ...
  Models/            # Eloquent models
routes/
  web.php            # Public & shared routes
  admin.php          # Admin panel routes
  api.php            # API endpoints
resources/views/     # Blade templates (admin, public)
```

---

## 9. How to Extend
- Add new models to `app/Models/`
- Add new controllers to `app/Http/Controllers/`
- Register new routes in `routes/admin.php` or `routes/api.php`
- Use Laravel policies/middleware for access control

---

## 10. Contact
For questions or integration help, contact the backend team or see the codebase for more details.
