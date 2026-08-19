<?php

namespace App\DTO;

use Illuminate\Http\UploadedFile;

class ProductDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $name,
        public ?string $slug,
        public ?string $description,
        public string|UploadedFile|null $image_url,
        public bool $active,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            slug: $data['slug'] ?? null,
            description: $data['description'] ?? null,
            image_url: $data['image_url'] ?? null,
            active: $data['active'] ?? false,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'active' => $this->active,
        ];
    }   
}