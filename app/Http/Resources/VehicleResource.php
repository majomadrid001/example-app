<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $stars = 0;
        foreach ($this->reviews as $review) {
            $stars += $review->stars;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'description' => $this->short_description,
            'ranking' => $this->reviews->count()?round($stars/$this->reviews->count(), 2):0,
            'image' => $this->images->first()->name,
            'price' => $this->price,
            'range' => $this->range,
        ];
    }
}
