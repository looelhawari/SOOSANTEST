<?php

return [
    // Owners Management
    'title' => 'Owners Management',
    'owners_management' => 'Owners Management',
    'manage_owners' => 'Manage system owners and their information',
    'owner_information' => 'Owner Information',
    
    // Statistics
    'total_owners' => 'Total Owners',
    'active_owners' => 'Active Owners',
    'inactive_owners' => 'Inactive Owners',
    'verified_owners' => 'Verified Owners',
    'owners_stats' => 'Owners Statistics',
    
    // Search & Filter
    'search_filter_owners' => 'Search & Filter Owners',
    'search_owners' => 'Search Owners',
    'search_placeholder' => 'Search by name, email, or phone...',
    'status' => 'Status',
    'all_status' => 'All Status',
    'active' => 'Active',
    'inactive' => 'Inactive',
    'verified' => 'Verified',
    'unverified' => 'Unverified',
    'filter_by' => 'Filter by',
    'apply_filters' => 'Apply Filters',
    'clear_filters' => 'Clear Filters',
    
    // Owner Actions
    'add_owner' => 'Add Owner',
    'create_owner' => 'Create Owner',
    'edit_owner' => 'Edit Owner',
    'view_owner' => 'View Owner',
    'delete_owner' => 'Delete Owner',
    'activate_owner' => 'Activate Owner',
    'deactivate_owner' => 'Deactivate Owner',
    'verify_owner' => 'Verify Owner',
    'unverify_owner' => 'Unverify Owner',
    'save_owner' => 'Save Owner',
    'update_owner' => 'Update Owner',
    'cancel' => 'Cancel',
    'back_to_owners' => 'Back to Owners',
    
    // Owner Details
    'name' => 'Name',
    'email' => 'Email',
    'phone' => 'Phone',
    'address' => 'Address',
    'city' => 'City',
    'state' => 'State',
    'country' => 'Country',
    'postal_code' => 'Postal Code',
    'company' => 'Company',
    'website' => 'Website',
    'notes' => 'Notes',
    'view' => 'View',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'search' => 'Search',
    'previous' => 'Previous',
    'next' => 'Next',
    'required' => '*',
    
    // Create Owner Page
    'create_new_owner' => 'Create New Owner',
    'add_new_owner' => 'Add a new owner to the system',
    'basic_information' => 'Basic Information',
    'basic_info_desc' => 'Enter the owner\'s basic details',
    'contact_information' => 'Contact Information',
    'contact_info_desc' => 'Enter contact details and address',
    'additional_information' => 'Additional Information',
    'additional_info_desc' => 'Optional company and website information',
    'owner_options' => 'Owner Options',
    'owner_options_desc' => 'Configure owner status and verification',
    'active_owner' => 'Active Owner',
    'verified_owner' => 'Verified Owner',
    
    // Edit Owner Page
    'edit_owner_details' => 'Edit Owner Details',
    'update_owner_info' => 'Update owner information and settings',
    'view_owner_details' => 'View Owner Details',
    'essential_owner_details' => 'Essential owner details and information',
    
    // Show Owner Page
    'owner_details' => 'Owner Details',
    'owner_profile' => 'Owner Profile',
    'contact_details' => 'Contact Details',
    'status_details' => 'Status & Details',
    'additional_details' => 'Additional Details',
    'created' => 'Created',
    'updated' => 'Updated',
    'n_a' => 'N/A',
    'normal' => 'Normal',
    
    // Show page translations
    'show' => [
        'title' => 'Owner Details',
        'header' => [
            'title' => 'Owner Details',
            'description' => 'View complete owner information and details',
            'edit_btn' => 'Edit Owner',
            'back_btn' => 'Back to Owners',
        ],
        'sections' => [
            'owner_info' => 'Owner Information',
            'basic_info' => 'Basic Information',
            'contact_info' => 'Contact Information',
            'location_info' => 'Location Information',
            'preferences' => 'Preferences',
        ],
        'labels' => [
            'full_name' => 'Full Name',
            'email_address' => 'Email Address',
            'phone_number' => 'Phone Number',
            'company' => 'Company',
            'address' => 'Address',
            'city' => 'City',
            'country' => 'Country',
            'preferred_language' => 'Preferred Language',
            'created_at' => 'Created At',
            'last_updated' => 'Last Updated',
            'time_since_created' => 'Time Since Created',
        ],
        'fallbacks' => [
            'individual_owner' => 'Individual Owner',
            'na' => 'N/A',
        ],
    ],
    
    // Placeholders
    'enter_name' => 'Enter full name',
    'enter_email' => 'Enter email address',
    'enter_phone' => 'Enter phone number',
    'enter_address' => 'Enter address',
    'enter_city' => 'Enter city',
    'enter_state' => 'Enter state/province',
    'enter_country' => 'Enter country',
    'enter_postal_code' => 'Enter postal code',
    'enter_company' => 'Enter company name',
    'enter_website' => 'Enter website URL',
    'enter_notes' => 'Enter additional notes',
    
    // Empty State
    'no_owners_found' => 'No Owners Found',
    'start_adding_owners' => 'Start building your owner database by adding your first owner.',
    'add_first_owner' => 'Add First Owner',
    
    // Pagination
    'showing_results' => 'Showing :first to :last of :total results',
    
    // Confirmation Messages
    'delete_confirmation' => 'Are you sure you want to delete this owner?',
    'delete_cannot_undone' => 'Are you sure you want to delete this item? This action cannot be undone.',
    
    // Processing States
    'processing' => 'Processing...',
    'creating_owner' => 'Creating Owner...',
    'updating_owner' => 'Updating Owner...',
    
    // Messages
    'owner_created' => 'Owner created successfully',
    'owner_updated' => 'Owner updated successfully',
    'owner_deleted' => 'Owner deleted successfully',
    'owner_activated' => 'Owner activated successfully',
    'owner_deactivated' => 'Owner deactivated successfully',
    'owner_verified' => 'Owner verified successfully',
    'owner_unverified' => 'Owner unverified successfully',
    
    // Additional translations for index page
    'with_email' => 'With Email',
    'with_phone' => 'With Phone',
    'with_company' => 'With Company',
    'all_countries' => 'All Countries',
    'all_cities' => 'All Cities',
    'no_contact_information' => 'No contact information',
    'employee_access' => 'Employee Access',
    'employee_access_desc' => 'You can create new owners and edit existing ones. Any edits to existing owners will be submitted for admin approval before taking effect.',
    
    // Additional missing translations
    'location_information' => 'Location Information',
    'preferences' => 'Preferences',
    'preferred_language' => 'Preferred Language',
    'select_language' => 'Select Language',
    'english' => 'English',
    'arabic' => 'Arabic',
    'spanish' => 'Spanish',
    'french' => 'French',
    'german' => 'German',
    'chinese' => 'Chinese',
    'japanese' => 'Japanese',
    'russian' => 'Russian',
    
    // Additional missing translations
    'creating' => 'Creating...',
    
    // Additional missing translations for edit page
    'full_name' => 'Full Name',
    'email_address' => 'Email Address',
    'enter_full_name' => 'Enter full name',
    'enter_email_example' => 'user@example.com',
    'phone_number' => 'Phone Number',
    'updating' => 'Updating...',
    
    // Additional missing translations for edit page fields
    'company_name_placeholder' => 'Company name',
    'full_street_address' => 'Full street address',
    'city_name_placeholder' => 'City name',
    'state_province' => 'State/Province',
    'state_province_placeholder' => 'State or province',
    'postal_code_placeholder' => 'Postal code',
    'country_placeholder' => 'Country',
    'italian' => 'Italian',
    'portuguese' => 'Portuguese',
    
    // Update owner information in the drilling dashboard system
    'update_owner_info_system' => 'Update owner information data',
    
    // Sold Products Table
    'sold_products' => 'Sold Products',
    'product' => 'Product',
    'serial_number' => 'Serial Number',
    'sale_date' => 'Sale Date',
    'warranty_status' => 'Warranty Status',
    'warranty_end' => 'Warranty End',
    'warranty_active' => 'Active',
    'warranty_expired' => 'Expired',
    'warranty_voided' => 'Voided',
    'sold_products_empty' => 'No sold products found for this owner.',
    'sections' => [
        'sold_products' => 'Sold Products',
    ],
];
