<?php

namespace App\Http\Resources\Events;

use Illuminate\Http\Resources\Json\Resource;

class EventExecutorResource extends Resource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'executorid' => $this->executor_id,
            'username' => $this->user->name,
            'usercolor' => $this->user->color,
        ];
    }

}
