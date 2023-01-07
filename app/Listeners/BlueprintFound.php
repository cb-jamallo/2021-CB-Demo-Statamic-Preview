<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Classes\SchemaManager;
use App\Classes\NavigationManager;
use App\Classes\FileManager;
use App\Classes\FileManagerReplicate;

class BlueprintFound
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (str_contains( $_SERVER['REQUEST_URI'], '/cp/collections/website/entries' ) && str_contains( $event->entry->blueprint, 'website') )
        {

        }
    }

    
}