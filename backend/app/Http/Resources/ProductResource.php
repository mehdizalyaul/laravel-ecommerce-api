<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => number_format($this->price, 2),
            'stock' => $this->stock,
            'image_url' => $this->image_url ? asset('storage/' . $this->image_url) : null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
