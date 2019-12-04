<?php

namespace App\Http\Resources\Contragents;

use Illuminate\Http\Resources\Json\Resource;

class ContragentTypeResource extends Resource {

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'type' => $this->translatable->name,
            'color' => $this->color->color,
        ];
    }

}
