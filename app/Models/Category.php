<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    const DEFAULT_ID = 1;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_path',
        'position',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'position' => 'integer',
    ];

    /**
     * Relación Muchos a Muchos con Productos
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
                    ->withTimestamps();
    }
}
