<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'long_description',
        'image_url',
        'price',
        'ingredients',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'active' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function carouselItems(): HasMany
    {
        return $this->hasMany(CarouselItem::class);
    }

    public function carousels(): BelongsToMany
    {
        return $this->belongsToMany(
            Carousel::class,
            'carousel_items'
        )
            ->withPivot('position')
            ->withTimestamps()
            ->orderByPivot('position');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Route Model Binding
    |--------------------------------------------------------------------------
    */

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value
                ? Storage::url($value)
                : asset('images/default-placeholder.png'), // Imagen por defecto si es null
        );
    }

    protected function ingredientsArray(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->ingredients
                ? array_map('trim', explode(',', $this->ingredients))
                : []
        );
    }
}
