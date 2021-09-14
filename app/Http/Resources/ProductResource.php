<?php


namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "current_page" => $this->currentPage(),
            'data' => $this->getData($this->items()),
            "per_page" => $this->perPage(),
            "total" => $this->total(),
        ];
    }

    public function getData($items) {
        return collect($items)->map(function($item) {
            return $item;
        });
    }
}

// 854k 
