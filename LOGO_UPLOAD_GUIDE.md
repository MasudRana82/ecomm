# Logo Upload Feature - Implementation Guide

## Overview

The admin can now upload and manage the website logo from the admin dashboard. The logo is stored in the database and can be changed at any time without modifying code.

## Features Implemented

### 1. Database Structure

- **Table**: `site_settings`
- **Columns**:
    - `id` - Primary key
    - `key` - Setting name (unique)
    - `value` - Setting value
    - `created_at`, `updated_at` - Timestamps

### 2. Admin Interface

- **Location**: Admin Dashboard → Settings
- **URL**: `/admin/settings`
- **Features**:
    - View current logo
    - Upload new logo (JPEG, PNG, JPG, GIF, SVG, WEBP)
    - Live preview before upload
    - Maximum file size: 2MB
    - Automatic old logo deletion when uploading new one

### 3. Frontend Integration

- Logo automatically displays on all pages
- Uses helper function `site_logo()` for easy access
- Falls back to default logo if none uploaded

## How to Use

### For Admins:

1. Log in to the admin dashboard
2. Click on "Settings" in the sidebar
3. Under "Website Logo", you'll see the current logo
4. Click "Choose File" to select a new logo
5. Preview will appear automatically
6. Click "Update Logo" to save

### For Developers:

To display the logo anywhere in the application:

```blade
<img src="{{ site_logo() }}" alt="Site Logo">
```

To get any site setting:

```php
$value = site_setting('key_name', 'default_value');
```

To set a site setting programmatically:

```php
SiteSetting::set('key_name', 'value');
```

## File Structure

```
app/
├── Models/
│   └── SiteSetting.php
├── Http/Controllers/
│   └── SiteSettingController.php
└── Helpers/
    └── helpers.php

database/
└── migrations/
    └── 2026_01_19_000002_create_site_settings_table.php

resources/views/
└── admin/
    └── settings/
        └── index.blade.php

routes/
└── web.php (added settings routes)
```

## Storage Location

Uploaded logos are stored in: `storage/app/public/logo/`

Make sure the storage link is created:

```bash
php artisan storage:link
```

## Security

- Only admin users can access settings
- File validation ensures only images are uploaded
- Maximum file size limit prevents abuse
- Old logos are automatically deleted to save space

## Future Enhancements

You can easily extend this system to add more settings:

- Site name
- Contact information
- Social media links
- SEO meta tags
- Color schemes
- And more...

Just add new settings to the database and create corresponding form fields in the settings page.
