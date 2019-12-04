<?php

namespace App\Listeners\Model;

use App\Events\Model\CreatingEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Activity;

class CreatingListener {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdatingEvent  $event
     * @return void
     */
    public function handle(CreatingEvent $event) {
        return Activity::create([
                    'user_id' => \Auth::user()->id,
                    'content_id' => $event->model->id,
                    'content_type' => get_class($event->model),
                    'action' => 'create',
                    'before' => json_encode([]),
                    'after' => json_encode(['id' => $event->model->id])
        ]);
    }

}
