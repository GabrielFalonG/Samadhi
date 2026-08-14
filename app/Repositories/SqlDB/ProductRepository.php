<?php

namespace App\Repositories\SqlDB;

use App\DTOs\Products\ProductFilterData;
use App\DTOs\Products\ProductSaveData;
use App\Models\CarouselItem;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginated(ProductFilterData $filters): LengthAwarePaginator
    {
        return Product::query()
        ->with('categories')
        ->when($filters->categories, function ($query, $category) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->whereIn('categories.id', $category);
            });
        }, function ($query) {
            $query->whereHas('categories', function ($q) {
                $q->where('categories.id', \App\Models\Category::DEFAULT_ID);
            });
        })
        ->when($filters->minPrice, function ($query, $minPrice) {
            $query->where('price', '>=', $minPrice);
        })

        ->when($filters->maxPrice, function ($query, $maxPrice) {
            $query->where('price', '<=', $maxPrice);
        })
        ->when(
            filled($filters->search),
            function ($query) use ($filters) {
                $query->where(function ($query) use ($filters) {
                    $query->where('title', 'like',"%{$filters->search}%")
                          ->orWhere('description', 'like', "%{$filters->search}%");
                });
            }
        )
        ->when(
            !is_null($filters->active),fn ($query) => $query->where(
                'active',
                $filters->active
            )
        )
        ->orderBy(
            $filters->sortBy,
            $filters->sortDirection
        )
        ->paginate($filters->perPage);
    }

    public function getAllProducts(): Collection
    {
        return Product::all();
    }

    public function getProductById(int $id): Product
    {
        try {
            $product = Product::query()->where('id', $id)->first();

            if (!$product) {
                throw new Exception('Producto no encontrado');
            }

            return $product;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getProductBySlug(string $slug): Product
    {
        try {
            $product = Product::query()->where('slug', $slug)->first();

            if (!$product) {
                throw new Exception('Producto no encontrado');
            }

            return $product;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getSelectableProducts(array $associatedProductsId = []): array
    {
        return Product::query()
            ->when(!empty($associatedProductsId), function ($query) use ($associatedProductsId) {
                $query->whereNotIn('id', $associatedProductsId);
            })
            ->get()
            ->toArray();
    }

    public function generateSlug(string $title): string
    {
        $slug = Str ::slug($title);
        $original = $slug;
        $i = 1;

        while (
            Product::where('slug', $slug)->exists()
        ) {
            $slug = "{$original}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function create(ProductSaveData $data): Product
    {
        return DB::transaction(function () use ($data) {
            $product = new Product();
            $product->title = $data->title;
            $product->slug = $this->generateSlug($data->title);
            $product->price = $data->price;
            $product->active = $data->active;
            $product->description = $data->description;
            $product->long_description = $data->long_description;
            $product->ingredients = $data->ingredients;

            // 1. Primer save para generar el ID en DB (si storeImage usa $product->id)
            $product->save();

            if ($data->image) {
                $product->image_url = $this->storeImage($data->image, $product);
                $product->save();
            }

            // Asociar categorías
            $product->categories()->sync($data->categories);

            return $product;
        });
    }

    public function update(Product $product, ProductSaveData $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            $product->title = $data->title;
            $product->price = $data->price;
            $product->active = $data->active;
            $product->description = $data->description;
            $product->long_description = $data->long_description;
            $product->ingredients = $data->ingredients;

            // Si el usuario subió una imagen nueva
            if ($data->image) {
                // 1. (Opcional) Borrar la imagen anterior del Storage si existía
                if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                    Storage::disk('public')->delete($product->image_url);
                }

                // 2. Guardar la nueva imagen y asignar la ruta
                $product->image_url = $this->storeImage($data->image, $product);
            }

            // Se persisten todos los cambios (atributos + nueva imagen_url si aplicó)
            $product->save();

            // Sincronizar categorías
            $product->categories()->sync($data->categories);

            return $product;
        });
    }

    protected function storeImage(UploadedFile $image, Product $product): string
    {
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        $extension = $image->getClientOriginalExtension();
        $filename = "{$product->slug}-" . time() . ".{$extension}";
        return $image->storeAs('products', $filename, 'public');
    }

    public function delete(Product $product): bool
    {
        try {
            return DB::transaction(function () use ($product) {
                CarouselItem::where('product_id', $product->id)->delete();
                if ($product->image_url) {
                    $relativePath = Str::after($product->image_url, 'storage/');
                    $relativePath = ltrim($relativePath, '/');
                    if (Storage::disk('public')->exists($relativePath)) {
                        Storage::disk('public')->delete($relativePath);
                    }
                }
                return (bool) $product->delete();
            });
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getSelectableIngredients(): array
    {
        try {
            return DB::table('products')
                        ->whereNotNull('ingredients')
                        ->where('ingredients', '!=', '')
                        ->pluck('ingredients')
                        ->flatMap(fn ($ingredients) => explode(',', $ingredients))
                        ->map(fn ($ingredient) => trim($ingredient))
                        ->filter()
                        ->unique()
                        ->sort()
                        ->values()
                        ->map(fn ($ingredient) => [
                            'id' => $ingredient,
                            'name' => $ingredient,
                        ])
                        ->all();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
