# 🚀 Soosan Cebotics MVP - Project Instructions

## 🎯 MVP Overview

A simplified Lara### Core Database Models

#### Contact Messages (Added)

```sql
contact_messages (
  id, first_name, last_name, email,
  phone, company, subject, message,
  is_read BOOLEAN DEFAULT false,
  read_at TIMESTAMP NULL,
  created_at, updated_at
)
```

#### Products

````sql
products (
  id, model_name, serial_number, category_id,
  image_urls JSON, -- Multiple product images
  specs_si JSON, -- SI specifications
  specs_imperial JSON, -- Imperial specifications
  description_en TEXT, description_ar TEXT,
  features JSON, -- Product features
  applications JSON, -- Use cases (Mining, Construction, etc.)
  brochure_url, manual_url,
  is_featured BOOLEAN,
  status ENUM('active', 'discontinued', 'coming_soon'),
  created_by, created_at, updated_atnt catalog website for Soosan Cebotics drilling equipment company.

**Key Principles:**

- ✅ **Public catalog browsing** (no user registration)
- ✅ **Admin/Employee login only** (CEO creates accounts)
- ✅ **Product management** with specifications
- ✅ **Manual purchase/warranty logging** (admin side)
- ✅ **Serial number lookup** for public users

---

## 🛠 Tech Stack

- **Backend**: Laravel 11
- **Database**: MySQL
- **Frontend**: Blade Templates + Bootstrap 5.3
- **Admin Panel**: Filament v3
- **Authentication**: Laravel Breeze + Sanctum
- **Localization**: Arabic & English support (Implemented)

---

## 🌐 Public Website Features

### Homepage

- Hero banner with company overview
- Quick product search by model/serial
- Navigation to product categories
- Language toggle (Arabic/English)
- Unit toggle (SI/Imperial)

### Product Catalog

- Category-based filtering
- Search by model name/number
- Product grid with images and basic specs
- Pagination/lazy loading

### Product Detail Page

- High-resolution product images
- Technical specifications (SI & Imperial units)
- Downloadable manuals/brochures
- Serial number verification form

### Serial Number Lookup

- Public form to check serial numbers
- Display product info, warranty status, owner details
- No login required

### Static Pages

- Legal Notice, Privacy Policy, Terms of Service
- Support contacts with phone numbers
- Company information
- **Note**: These are static Blade template files, not database-managed content

---

## 🔐 Authentication & Roles

### User Roles

| Role         | Access               | Permissions                                   |
| ------------ | -------------------- | --------------------------------------------- |
| **Admin**    | Full Filament access | Create employees, manage all data, edit pages |
| **Employee** | Limited panel access | View-only access to assigned dashboard pages  |

### Login Rules

- No public registration
- Only Admin can create employee accounts
- All admin/employee access through Filament dashboard only
- No separate public login system

---

## 📦 Core Database Models

### Products

```sql
products (
  id, model_name, serial_number, category_id,
  image_urls JSON, -- Multiple product images
  specs_si JSON, -- SI specifications
  specs_imperial JSON, -- Imperial specifications
  description_en TEXT, description_ar TEXT,
  features JSON, -- Product features
  applications JSON, -- Use cases (Mining, Construction, etc.)
  brochure_url, manual_url,
  is_featured BOOLEAN,
  status ENUM('active', 'discontinued', 'coming_soon'),
  created_by, created_at, updated_at
)
````

### Product Categories

```sql
product_categories (
  id, name_en, name_ar, slug,
  description_en, description_ar,
  icon_url, parent_id, sort_order, is_active
)
```

### Owners (Customers)

```sql
owners (
  id, full_name, phone, email, company,
  address, city, country,
  preferred_language ENUM('en', 'ar'),
  created_at, updated_at
)
```

### Sold Products (Manual Entry)

```sql
sold_products (
  id, product_id, owner_id, employee_id,
  serial_number, sale_date,
  warranty_start_date, warranty_end_date,
  purchase_price, notes,
  created_at, updated_at
)
```

### Employees

```sql
employees (
  id, name, email, password,
  role ENUM('ceo', 'sales_rep', 'product_manager'),
  is_verified BOOLEAN DEFAULT false,
  created_by, created_at, updated_at
)
```

### Static Pages

```sql
static_pages (
  id, slug, title_en, title_ar,
  body_en LONGTEXT, body_ar LONGTEXT,
  is_published BOOLEAN, updated_at
)
```

### Audit Logs

```sql
audit_logs (
  id, employee_id, action, target_type, target_id,
  old_values JSON, new_values JSON, timestamp
)
```

---

## 🎨 Product Information Fields (From Soosan Website)

### Basic Product Data

-   **Model Name** (e.g., "AT-5", "SB 81")
-   **Product Category** (AT, Hydraulic Drills, Breakers, etc.)
-   **Serial Number** (for tracking)
-   **Product Images** (multiple angles)
-   **Status** (Active, Discontinued, Coming Soon)

### Technical Specifications

-   **Weight** (SI: kg, Imperial: lbs)
-   **Dimensions** (Length, Width, Height)
-   **Operating Pressure** (SI: bar, Imperial: psi)
-   **Flow Rate** (SI: L/min, Imperial: gal/min)
-   **Impact Energy** (SI: J, Imperial: ft-lbs)
-   **Tool Carrier Weight** (excavator compatibility)
-   **Oil Flow Requirements**
-   **Working Pressure Range**

### Applications & Features

-   **Industry Applications**: Mining, Civil Construction, Demolition, Recycling, Electrical work, Ship & Marine
-   **Key Features**: Impact power, durability features, efficiency metrics
-   **Compatibility**: Compatible excavator models/weights

### Documentation

-   **Product Brochures** (PDF downloads)
-   **Technical Manuals** (installation, operation, maintenance)
-   **Specification Sheets** (detailed technical data)
-   **Warranty Information**

---

## 🖥 Filament Admin Panel

### Dashboard Overview

-   Recent sales entries
-   Product statistics
-   Warranty expiration alerts
-   User activity logs

### Product Management

-   **Products Resource**: Full CRUD with image gallery
-   **Categories Resource**: Hierarchical category management
-   **Specifications Builder**: SI/Imperial unit management
-   **File Manager**: Upload manuals, brochures, images

### Sales & Warranty Management

-   **Owners Resource**: Customer information management
-   **Sold Products Resource**: Manual sales entry with warranty tracking
-   **Serial Number Lookup**: Admin can verify ownership

### User Management (CEO Only)

-   **Employees Resource**: Create/manage employee accounts
-   **Role Assignment**: Assign roles with permissions
-   **Audit Logs**: Track all admin actions

### Content Management

-   **Static Pages**: Edit legal pages, support info
-   **System Settings**: Contact info, company details
-   **Contact Messages**: View and manage customer contact form submissions

---

## 🔍 Core Features Implementation

### Serial Number Lookup (Public)

1. Public form accepts serial number input
2. System searches `sold_products` table
3. If found: display product info, warranty status, owner details
4. If not found: suggest contacting sales

### Product Specifications Display

1. Store specs in JSON format for both SI and Imperial
2. Frontend toggle switches between unit systems
3. Real-time conversion for compatible units
4. Responsive specification tables

### Multi-language Support ✅

1. ✅ Translation files in `lang/en/common.php` and `lang/ar/common.php`
2. ✅ Language toggle in header with query parameter-based switching
3. ✅ RTL support for Arabic with Bootstrap RTL stylesheet and Cairo font
4. ✅ LocaleMiddleware for handling language preferences
5. ✅ Conditional logo display based on language (en/ar versions)
6. ✅ All templates updated to use `__('common.key')` syntax

### File Management

1. Product images stored as JSON array
2. PDF uploads for manuals/brochures
3. Organized file structure by product categories
4. Image optimization and WebP conversion

---

## 🚀 Development Priorities

### Phase 1: Core Foundation ✅

1. Laravel 11 setup with MySQL ✅
2. Filament v3 installation and configuration ✅
3. Basic authentication (Breeze + Sanctum) ✅
4. Core models and migrations ✅

### Phase 2: Admin Panel ✅

1. Filament resources for all models ✅
2. Role-based permissions ✅
3. File upload functionality ✅
4. Basic dashboard ✅

### Phase 3: Public Website ✅

1. Homepage with hero banner ✅
2. Product catalog with filtering ✅
3. Product detail pages ✅
4. Serial number lookup tool ✅

### Phase 4: Polish & Features ✅

1. Multi-language implementation ✅
2. SI/Imperial unit conversion ✅
3. Responsive design optimization ✅
4. Performance optimization ✅

---

## 📋 Installed Laravel Packages

```bash
# Core packages
composer require filament/filament
composer require spatie/laravel-permission
composer require spatie/laravel-medialibrary

# Frontend
npm install bootstrap@5.3.0
npm install @popperjs/core

# Optional enhancements
composer require spatie/laravel-activitylog # For audit logs
composer require intervention/image # For image processing
```

---

## 🎯 Success Metrics

### Functional Requirements

-   ✅ Public users can browse products without registration
-   ✅ Serial number lookup works for sold products
-   ✅ Admin can manually log sales and warranties
-   ✅ Product specs display in both SI and Imperial units
-   ✅ Multi-language support (English/Arabic)
-   ✅ Contact form with admin dashboard integration

### Technical Requirements

-   ✅ Role-based admin access (CEO, Sales Rep, Product Manager)
-   ✅ Responsive design across all devices (Bootstrap 5.3 implementation)
-   ✅ File upload and management for product documentation
-   ✅ Audit logging for admin actions
-   ✅ Performance optimization for product catalog
-   ✅ RTL support for Arabic language

### Completed Major Milestones

-   ✅ **Framework Conversion**: Successfully migrated from Tailwind CSS to Bootstrap 5.3
-   ✅ **Localization System**: Implemented complete English/Arabic localization with proper RTL support
-   ✅ **Contact Form**: Added contact message submission system with Filament admin integration
-   ✅ **Responsive Design**: Ensured all pages are fully responsive in both LTR and RTL modes

This MVP has now been completed with all core functionality implemented while maintaining minimal complexity and high maintainability.

### CRITICAL NOTES

-   Don't change the UI/UX format (standardize UI/UX)
-   If a feature is implemented, don't re-implement it without asking
-   Try to continuously update this file based on our progress
