# Reports System Testing Guide

## Overview
This guide provides instructions for testing the comprehensive PDF reporting system for admins and CEOs.

## Setup Instructions

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed test data (optional)
php artisan db:seed --class=ReportsTestDataSeeder
```

### 3. Start the Application
```bash
php artisan serve
```

## Test Accounts

After running the ReportsTestDataSeeder, you can use these accounts:

- **Admin**: admin@reports.test / password
- **CEO**: ceo@reports.test / password
- **Employees**: employee1@reports.test through employee5@reports.test / password

## Features to Test

### 1. Access Control
- ✅ Admin users can access reports
- ✅ CEO users can access reports
- ❌ Employee users cannot access reports (should get 403 error)

### 2. Report Types
Test each report type with different time periods:

#### Comprehensive Report (`/admin/reports/comprehensive`)
- **Contains**: Financial overview, sales metrics, staff performance, regional analysis
- **Test with**: Last 7 days, 30 days, 90 days, this year, custom range

#### Owners Report (`/admin/reports/owners`)
- **Contains**: Customer demographics, geographic distribution, purchase behavior
- **Test with**: Different time periods to see acquisition trends

#### Sales Report (`/admin/reports/sales`)
- **Contains**: Product performance, daily sales trends, staff sales metrics
- **Test with**: Various periods to analyze sales patterns

### 3. Time Period Options
- Last 7 days
- Last 30 days
- Last 90 days
- This year
- Last year
- Custom date range

### 4. PDF Generation
- Reports should download as PDF files
- PDFs should be properly formatted with modern styling
- Charts should display placeholders (ready for future chart integration)

## Navigation Testing

1. **Admin Navigation**
   - Login as admin
   - Navigate to admin panel
   - Look for "Reports" menu item in sidebar
   - Should appear only for admin/CEO users

2. **Report Selection**
   - Visit `/admin/reports`
   - Should see three report cards
   - Each card should show preview statistics
   - Time period selector should work

## Manual Testing Steps

### Test 1: Basic Access
1. Login as admin user
2. Navigate to `/admin/reports`
3. Verify page loads with all three report options
4. Check that all UI elements are properly styled

### Test 2: Report Generation
1. Select "Comprehensive Report"
2. Choose "Last 30 Days"
3. Click "Download PDF"
4. Verify PDF downloads and contains expected data

### Test 3: Custom Date Range
1. Select any report type
2. Choose "Custom Range"
3. Set start and end dates
4. Generate report
5. Verify date range is reflected in the report

### Test 4: Permission Testing
1. Login as employee
2. Try to access `/admin/reports`
3. Should receive 403 Forbidden error
4. Reports menu should not appear in navigation

## Expected Data in Reports

With test data seeded, reports should contain:
- **Revenue**: Varies based on random sales data
- **Sales Count**: Approximately 300-400 sales over 90 days
- **Products**: 20 different products across 5 categories
- **Staff**: 5 employees with sales attributed to them
- **Owners**: 50 customers from various cities/countries
- **Geographic**: Distribution across US, Canada, Mexico, UK, Germany

## Troubleshooting

### Common Issues

1. **PDF Generation Fails**
   - Check that dompdf is installed: `composer show barryvdh/laravel-dompdf`
   - Ensure proper memory limits in PHP
   - Check Laravel logs for errors

2. **No Data in Reports**
   - Run the seeder: `php artisan db:seed --class=ReportsTestDataSeeder`
   - Check database tables have data
   - Verify date ranges include sample data

3. **Permission Errors**
   - Check user roles in database
   - Verify middleware is properly configured
   - Test with different user types

4. **Translation Issues**
   - Verify translation files exist in `lang/en/reports.php` and `lang/ar/reports.php`
   - Check Laravel locale settings

## Testing Checklist

- [ ] Admin can access reports page
- [ ] CEO can access reports page
- [ ] Employee cannot access reports page
- [ ] All three report types generate PDFs
- [ ] Time period filters work correctly
- [ ] Custom date range functions properly
- [ ] Navigation menu appears for authorized users
- [ ] PDFs contain expected data and formatting
- [ ] Loading modal appears during generation
- [ ] Error handling works for invalid requests

## Performance Testing

For production readiness, test with larger datasets:
- 1000+ products
- 10,000+ owners
- 50,000+ sales records
- Various date ranges spanning years

## Security Testing

- Verify unauthorized users cannot access reports
- Test for SQL injection in date parameters
- Check that sensitive data is properly protected
- Ensure PDFs are not cached inappropriately

## Conclusion

This reporting system provides comprehensive financial and operational insights for business decision-making. The modern UI and PDF generation make it suitable for executive presentations and strategic planning.

For production deployment, consider:
- Adding real chart generation (Chart.js, etc.)
- Implementing caching for large datasets
- Adding email delivery for scheduled reports
- Creating report templates for different business needs
