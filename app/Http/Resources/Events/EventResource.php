<?php

namespace App\Http\Resources\Events;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Events\EventExecutorResource;

class EventResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //['type.translatable', 'subtype.translatable', 'executor.user']
        //PostResource::collection($this->whenLoaded('posts'))
        
        return [
            'id' => $this->id,
            'eventtypeid' => $this->events_types_id,
            'eventsubtypeid' => $this->events_subtypes_id,
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'startdate' => $this->start_date,
            'enddate' => $this->end_date,
            'eventtypename' => $this->type->translatable->name,
            'eventtypeicon' => $this->type->icon,
            'eventsubtypename' => $this->subtype->translatable->name,
            'executor' => EventExecutorResource::collection($this->executor)
        ];
    }
}
