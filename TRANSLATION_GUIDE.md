# Translation Implementation Guide

## Overview
The drilling dashboard has been implemented with comprehensive Arabic and English translation support, focusing on the Serial Lookup pages and related components.

## Features Implemented

### 1. Language Support
- **English (en)**: Default language
- **Arabic (ar)**: RTL (Right-to-Left) support with Bootstrap RTL

### 2. Translation Keys Added
All translation keys are stored in:
- `lang/en/common.php` - English translations
- `lang/ar/common.php` - Arabic translations

### 3. Pages Translated

#### Serial Lookup Pages
- **Index Page** (`/serial-lookup`):
  - Page title and descriptions
  - Form labels and placeholders
  - Help text and instructions
  - Sample serials section
  - Information cards

- **Result Page** (`/serial-lookup` POST):
  - Page headers and navigation
  - Product details section
  - Owner information section
  - Warranty coverage section
  - Unit toggle (SI/Imperial)

#### Products Pages
- **Products Index** (`/products`):
  - Page title and descriptions
  - Search and filter options
  - Sorting options
  - Product listings
  - Unit toggles

### 4. RTL (Arabic) Support

#### CSS Enhancements
- Custom RTL stylesheet: `public/css/rtl-styles.css`
- Bootstrap RTL integration
- Icon spacing adjustments
- Form control directionality
- Table and card alignments

#### Layout Adaptations
- Direction attribute based on locale
- Font family for Arabic text
- Navigation adjustments
- Button group directionality

### 5. Middleware Integration
- `LocaleMiddleware` handles language switching
- Session-based locale persistence
- URL parameter support (`?lang=ar` or `?lang=en`)

### 6. Language Switching
- Visual toggle in navigation
- Route-based switching: `/lang/{lang}`
- Maintains current page context

## Usage

### Testing the Implementation

1. **Start the Laravel server**:
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```

2. **Access the application**:
   - English: `http://localhost:8000`
   - Arabic: `http://localhost:8000/lang/ar`

3. **Test Serial Lookup**:
   - Navigate to Serial Lookup page
   - Try sample serial numbers: `2231`, `TEST123`, `HD1200-2025-001`
   - Switch languages using the toggle in navigation

### Adding New Translations

1. **Add to language files**:
   ```php
   // lang/en/common.php
   'new_key' => 'English text',
   
   // lang/ar/common.php
   'new_key' => 'النص العربي',
   ```

2. **Use in Blade templates**:
   ```php
   {{ __('common.new_key') }}
   ```

3. **Use in controllers**:
   ```php
   return __('common.new_key');
   ```

## File Structure

```
lang/
├── en/
│   └── common.php          # English translations
└── ar/
    └── common.php          # Arabic translations

resources/views/
├── layouts/
│   └── public.blade.php    # Main layout with RTL support
└── public/
    ├── serial-lookup/
    │   ├── index.blade.php # Serial lookup form
    │   └── result.blade.php # Serial lookup results
    └── products/
        └── index.blade.php # Products listing

public/css/
└── rtl-styles.css         # RTL-specific styles

app/Http/
├── Controllers/
│   └── SerialLookupController.php # Translated error messages
└── Middleware/
    └── LocaleMiddleware.php       # Language handling
```

## Translation Keys Reference

### Navigation & Common
- `home`, `products`, `serial_lookup`, `about`, `support`, `contact`
- `search`, `filter`, `submit`, `back`, `view_details`

### Serial Lookup
- `serial_lookup_title`, `serial_lookup_subtitle`
- `equipment_serial_lookup`, `check_coverage`
- `warranty_status`, `warranty_coverage`
- `product_details`, `owner_details`

### Products
- `products_title`, `filter`, `sort_by`
- `model_name`, `operating_weight`, `specifications`

### Error Messages
- `not_found`, `processing_error`
- `serial_min_length`, `serial_invalid_format`

## Next Steps

1. **Extend to other pages**:
   - Homepage translations
   - About page
   - Contact form
   - Product details pages

2. **Add more languages**:
   - Create new language directories
   - Update language switcher
   - Add new RTL stylesheets if needed

3. **Database content translation**:
   - Consider translatable models for products
   - Category translations
   - Dynamic content translation

## Notes

- The application uses Laravel's built-in localization features
- Locale is stored in session for persistence
- RTL styles are conditionally loaded for Arabic
- Serial number inputs maintain LTR directionality for consistency
- Unit values and technical specifications preserve their format across languages
