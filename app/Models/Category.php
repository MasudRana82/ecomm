<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FileUpload;

class Category extends Model
{
    use HasFactory;
    use FileUpload;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'order',
        'is_active',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    
    /**
     * Handle image upload for category
     */
    public function uploadImage($image)
    {
        if ($image) {
            return $this->uploadFile($image, 'categories');
        }
        return null;
    }
    
    /**
     * Delete category image
     */
    public function deleteCategoryImage($imagePath)
    {
        if ($imagePath) {
            $this->deleteFile($imagePath);
        }
    }
}
