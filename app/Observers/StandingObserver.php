<?php

namespace App\Observers;

use App\Models\Standing;

class StandingObserver
{
    /**
     * Handle the Standing "created" event.
     *
     * @param  \App\Models\Standing  $standing
     * @return void
     */
    public function created(Standing $standing)
    {
        $points = ($standing->win * 3) + $standing->draw;
        $standing->points = $points;
        $standing->save();
    }

    /**
     * Handle the Standing "updated" event.
     *
     * @param  \App\Models\Standing  $standing
     * @return void
     */
    public function updated(Standing $standing)
    {
        $points = ($standing->win * 3) + $standing->draw;
        $standing->points = $points;
        $standing->save();
        
    }

    /**
     * Handle the Standing "deleted" event.
     *
     * @param  \App\Models\Standing  $standing
     * @return void
     */
    public function deleted(Standing $standing)
    {
        //
    }

    /**
     * Handle the Standing "restored" event.
     *
     * @param  \App\Models\Standing  $standing
     * @return void
     */
    public function restored(Standing $standing)
    {
        //
    }

    /**
     * Handle the Standing "force deleted" event.
     *
     * @param  \App\Models\Standing  $standing
     * @return void
     */
    public function forceDeleted(Standing $standing)
    {
        //
    }
}
