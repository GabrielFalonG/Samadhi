<?php

namespace App\DTOs\Products;

use Illuminate\Http\UploadedFile;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProductSaveData
{
    public function __construct(
        public readonly ?int $productId,
        public readonly string $title,
        public readonly string $slug,
        public readonly ?string $description,
        public readonly ?string $long_description,
        public readonly float $price,
        public readonly bool $active,
        public readonly array $categories,
        public readonly ?string $ingredients,
        public readonly UploadedFile|TemporaryUploadedFile|null $image = null,
    ) {
    }

    public function isCreate(): bool
    {
        return $this->productId === null;
    }

    public function isUpdate(): bool
    {
        return $this->productId !== null;
    }

    public function toArray(): array
    {
        return [
            'productId'   => $this->productId,
            'title'       => $this->title,
            'description' => $this->description,
            'price'       => $this->price,
            'active'      => $this->active,
            'image'       => $this->image,
            'categories'  => $this->categories,
        ];
    }
}
