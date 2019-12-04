<?php

namespace App\Http\Resources\Events;

use Illuminate\Http\Resources\Json\Resource;

class EventCollection extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ['name' => $this->name];
    }
}
