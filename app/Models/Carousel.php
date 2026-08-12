<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carousel extends Model
{
    use SoftDeletes;

    protected $table = 'carousels';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'section',
        'position',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'position' => 'integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    /**
     * Relación con la entidad intermedia.
     * Útil para el backoffice y para administrar el orden.
     */
    public function carouselItems(): HasMany
    {
        return $this->hasMany(CarouselItem::class)
            ->orderBy('position');
    }

    /**
     * Productos asociados al carrusel.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'carousel_items'
        )
            ->withPivot('position')
            ->withTimestamps()
            ->orderByPivot('position');
    }
}
