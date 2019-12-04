<?php

namespace App\Listeners\Model;

use App\Events\Model\UpdatingEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Activity;

class UpdatingListener {

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
    public function handle(UpdatingEvent $event) {
        
        $diff = $this->getDiff($event->model);
//        $diffTranslation = $this->getDiff($event->modelTranslation);

//        $mergeChanges = array_merge_recursive($diff, $diffTranslation);

        if (!$diff['before'] && !$diff['after']) {
            return true;
        }

        return Activity::create([
                    'user_id' => \Auth::user()->id,
                    'content_id' => $event->model->id,
                    'content_type' => get_class($event->model),
                    'action' => 'change',
                    'before' => json_encode($diff['before']),
                    'after' => json_encode($diff['after'])
        ]);
    }

    protected function getDiff($model) {
        $changed = $model->getDirty();

        $before = array_intersect_key($model->fresh()->toArray(), $changed);
        $after = $changed;

        return compact('before', 'after');
    }

}
