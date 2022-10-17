<?php

namespace App\Observers;

use App\Models\ReadyToFight;
use App\Services\FightService;

class ReadyToFightObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  ReadyToFight $readyToFight
     * @return void
     */
    public function created(ReadyToFight $readyToFight): void
    {
//        dd(auth()->user()->profile);
//        $winsAndDefeats = FightService::calcWinsAndDefeats(auth()->user()->profile);
//        $readyToFight->updateQuietly([
//            'wins' => $winsAndDefeats['wins'],
//            'defeats' => $winsAndDefeats['defeats'],
//        ]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  ReadyToFight $readyToFight
     * @return void
     */
    public function updated(ReadyToFight $readyToFight): void
    {
//        $winsAndDefeats = FightService::calcWinsAndDefeats(auth()->user()->profile);
//        $readyToFight->updateQuietly([
//            'wins' => $winsAndDefeats['wins'],
//            'defeats' => $winsAndDefeats['defeats'],
//        ]);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  ReadyToFight $readyToFight
     * @return void
     */
    public function deleted(ReadyToFight $readyToFight): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  ReadyToFight $readyToFight
     * @return void
     */
    public function restored(ReadyToFight $readyToFight): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  ReadyToFight $readyToFight
     * @return void
     */
    public function forceDeleted(ReadyToFight $readyToFight): void
    {
        //
    }
}
