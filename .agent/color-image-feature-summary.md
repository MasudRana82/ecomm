# Color-Based Image Switching Feature

## Overview

This feature allows customers to see different product images when they select different color options on the product detail page. Admins can upload color-specific images for each product variant.

## What Was Implemented

### 1. Database Changes

-   **Migration**: Added `color_images` JSON column to `products` table
-   Stores a mapping of color names to their respective image paths
-   Example: `{"Red": "products/red-shirt.jpg", "Blue": "products/blue-shirt.jpg"}`

### 2. Model Updates

-   Added `color_images` to Product model's `$fillable` array
-   Added `color_images` to `$casts` array as 'array' type

### 3. Admin Interface Updates

#### Create Product Form (`resources/views/admin/products/create.blade.php`)

-   Added dynamic color-specific image upload section
-   When admin enters colors (comma-separated), JavaScript automatically creates file upload inputs for each color
-   Each color gets its own file upload field

#### Edit Product Form (`resources/views/admin/products/edit.blade.php`)

-   Shows existing color-specific images with preview
-   Allows uploading new images to replace existing ones
-   Dynamically updates when colors are modified

### 4. Controller Updates (`ProductAdminController.php`)

-   **Store Method**: Handles uploading color-specific images when creating products
-   **Update Method**: Handles updating color-specific images, deleting old ones when replaced
-   Added validation for `color_images` array

### 5. Frontend Product Detail Page (`resources/views/products/show.blade.php`)

-   Color selectors now have `data-image` attributes containing the color-specific image URL
-   JavaScript listens for color selection changes
-   When a color is clicked, the main product image smoothly transitions to the color-specific image
-   Falls back to default product image if no color-specific image exists
-   First color is pre-selected by default

## How It Works

### For Admins:

1. Go to Admin → Products → Create/Edit Product
2. Enter colors in the "Colors" field (e.g., "Red, Blue, Green")
3. A "Color-Specific Images" section appears automatically
4. Upload an image for each color variant
5. Save the product

### For Customers:

1. Visit a product detail page
2. See available color options
3. Click on a color
4. The main product image changes to show that color variant
5. Smooth fade transition provides better UX

## Technical Details

### Image Storage

-   Color images are stored in `storage/app/public/products/`
-   Paths are saved in the database as JSON: `{"Color Name": "products/filename.jpg"}`

### JavaScript Implementation

-   Uses event listeners on color radio buttons
-   Smooth opacity transition (0.5 → 1) when changing images
-   Stores default image as fallback
-   Pre-loads first color's image on page load

### Data Flow

1. Admin uploads color images → Stored in filesystem
2. Paths saved to database in `color_images` JSON column
3. Frontend retrieves color_images array
4. JavaScript uses data attributes to switch images on color selection

## Files Modified

1. `database/migrations/2025_12_24_135352_add_color_images_to_products_table.php`
2. `app/Models/Product.php`
3. `app/Http/Controllers/ProductAdminController.php`
4. `resources/views/admin/products/create.blade.php`
5. `resources/views/admin/products/edit.blade.php`
6. `resources/views/products/show.blade.php`

## Testing Checklist

-   [ ] Create a new product with colors and color-specific images
-   [ ] Verify images upload correctly
-   [ ] Check product detail page shows correct image for each color
-   [ ] Edit existing product and update color images
-   [ ] Test with products that have colors but no color-specific images (should show default)
-   [ ] Test image transitions are smooth
-   [ ] Verify old images are deleted when replaced

## Future Enhancements

-   Add ability to upload multiple images per color
-   Add color swatch/preview in admin panel
-   Support for removing individual color images
-   Bulk upload for color images
-   Image optimization/compression
