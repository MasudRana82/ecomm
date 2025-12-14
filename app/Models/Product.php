<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FileUpload;

class Product extends Model
{
    use HasFactory;
    use FileUpload;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'compare_price',
        'sku',
        'quantity',
        'is_active',
        'is_featured',
        'image',
        'images',
        'colors',
        'sizes',
        'category_id',
    ];

    protected $casts = [
        'images' => 'array',
        'colors' => 'array',
        'sizes' => 'array',
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return 0;
    }
    
    /**
     * Handle image upload for product
     */
    public function uploadImage($image)
    {
        if ($image) {
            return $this->uploadFile($image, 'products');
        }
        return null;
    }
    
    /**
     * Handle multiple image uploads for product
     */
    public function uploadMultipleImages($images)
    {
        if ($images) {
            return $this->uploadMultipleFiles($images, 'products');
        }
        return null;
    }
    
    /**
     * Delete product image
     */
    public function deleteProductImage($imagePath)
    {
        if ($imagePath) {
            $this->deleteFile($imagePath);
        }
    }
}
