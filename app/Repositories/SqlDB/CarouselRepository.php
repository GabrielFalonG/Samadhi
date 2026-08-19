<?php

namespace App\Repositories\SqlDB;

use App\DTOs\Carousel\CarouselFiltersData;
use App\DTOs\Carousel\SaveCarouselData;
use App\Models\Carousel;
use App\Repositories\Contracts\CarouseRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CarouselRepository implements CarouseRepositoryInterface
{
    public function getCarouselById(int $id): Carousel
    {
        return Carousel::with('products')->find($id);
    }

    public function paginated(CarouselFiltersData $filters): LengthAwarePaginator
    {
        try {
            return Carousel::query()
                ->withCount('products')
                ->when($filters->search, function ($query) use ($filters) {
                    $query->where(function ($q) use ($filters) {
                        $q->where('title', 'like', "%{$filters->search}%")
                            ->orWhere('subtitle', 'like', "%{$filters->search}%")
                            ->orWhere('description', 'like', "%{$filters->search}%");
                    });
                })

                ->when($filters->section, function ($query) use ($filters) {
                    $query->where('section', $filters->section);
                })

                ->when($filters->active !== '', function ($query) use ($filters) {
                    $query->where('active', $filters->active);
                })

                ->orderBy(
                    $filters->sortBy,
                    $filters->sortDirection
                )

                ->paginate($filters->perPage);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(Carousel $carousel, SaveCarouselData $data): Carousel
    {
        try {
            return DB::transaction(function () use ($carousel, $data) {

                /*
                |--------------------------------------------------------------------------
                | Actualizar cabecera
                |--------------------------------------------------------------------------
                */

                $carousel->update([
                    'title' => $data->title,
                    'subtitle' => $data->subtitle,
                    'description' => $data->description,
                    'section' => $data->section,
                    'position' => $data->position,
                    'active' => $data->active,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Reemplazar productos del carrusel
                |--------------------------------------------------------------------------
                */
                $carousel->carouselItems()->delete();

                foreach ($data->items as $index => $item) {
                    $carousel->carouselItems()->create([
                        'product_id' => $item->productId,
                        'position' => $index + 1,
                    ]);
                }

                return $carousel->fresh([
                    'carouselItems.product',
                ]);
            });
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function create(SaveCarouselData $data): Carousel
    {
        try {
            return DB::transaction(function () use ($data) {
                /*
                |--------------------------------------------------------------------------
                | Crear cabecera
                |--------------------------------------------------------------------------
                */
                $carousel = Carousel::create([
                    'title' => $data->title,
                    'subtitle' => $data->subtitle,
                    'description' => $data->description,
                    'section' => $data->section,
                    'position' => $data->position,
                    'active' => $data->active,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Agregar productos al carrusel
                |--------------------------------------------------------------------------
                */
                foreach ($data->items as $index => $item) {
                    $carousel->carouselItems()->create([
                        'product_id' => $item->productId,
                        'position' => $index + 1,
                    ]);
                }

                return $carousel->fresh([
                    'carouselItems.product',
                ]);
            });
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Carousel $carousel): bool
    {
        try {
            return DB::transaction(function () use ($carousel) {
                // $carousel->carouselItems()->delete();
                return $carousel->delete();
            });
        } catch (Exception $e) {
            throw $e;
        }
    }
}
