<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category->name,
            'brand' => $this->brand->name,
            'price' => (float) $this->price,
            'formatted_price' => 'Rp ' . number_format($this->price, 2, ',', '.'),
            'stock' => $this->stock,
            'specifications' => $this->specifications,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
        ];
    }
}
