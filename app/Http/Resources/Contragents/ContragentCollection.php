<?php

namespace App\Http\Resources\Contragents;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Contragents\ContragentResource;

class ContragentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => ContragentResource::collection($this->collection),
        ];
    }
    
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'status_code' => 200,
            'message' => null
        ];
    }
}
