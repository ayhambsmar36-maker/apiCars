<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->images->each(fn($img) => logger($img->url));
        return [
            'id'=>$this->id,
            'name'=> $this->name,
            'description'=>$this->description,
            'model'=>$this->model,
            "year"=>$this->year,
            'price'=>$this->price,
            "engine"=>$this->engine,
            'type_transmission'=>$this->trans->type,
            "type_fuel"=>$this->fuel->type,
            'brand'=>$this->brand->name,
            "images"=>ImageResource::collection($this->images)

        ];
    }
}
