# Localization Implementation for Soosan Cebotics Website

This PR adds complete localization support to the Soosan Cebotics Laravel + Filament catalog website, making it multilingual with support for English and Arabic languages.

## Changes

### Language Files and Translations

-   Created English translation file (`/lang/en/common.php`) with all site text strings
-   Created Arabic translation file (`/lang/ar/common.php`) with all site text translated to Arabic
-   Organized translations by section (navigation, homepage, products, etc.)

### Locale Middleware and Configuration

-   Added `LocaleMiddleware` to detect and set the application language
-   Configured middleware to handle language switching via `lang` query parameter
-   Updated bootstrap/app.php to register the locale middleware

### Template Updates

-   Updated all blade templates to use translation keys instead of hardcoded text
-   Modified all views to use `__('common.key')` syntax for localized content
-   Updated navigation bar language switcher to preserve the current URL when switching languages

### RTL Support for Arabic

-   Added conditional HTML `dir` attribute based on current locale
-   Added Bootstrap RTL CSS file when using Arabic language
-   Imported Cairo font for Arabic text
-   Added custom CSS for RTL-specific styling
-   Added logo switching based on language (en/ar versions)

### Responsive Design

-   Ensured all layout components work properly in both LTR and RTL modes
-   Verified proper display on mobile and desktop devices in both languages

## Testing

-   Verified language switching functionality
-   Tested RTL layout in Arabic mode
-   Confirmed all translated strings display correctly
-   Validated responsive design in both languages

## Notes for Reviewers

-   Please verify that the Arabic translations are accurate
-   Check for any UI issues in RTL mode, particularly in the product detail pages
-   Ensure the contact form submission still works properly in both languages
