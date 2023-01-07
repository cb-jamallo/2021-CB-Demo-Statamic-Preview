<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// CB : Listen to EntrySaving
use App\Listeners\EntrySaving as EntrySaving;
use Statamic\Events\EntrySaving as StatamicEventsEntrySaving;

// CB : Listen to EntrySaved
use App\Listeners\EntrySaved as EntrySaved;
use Statamic\Events\EntrySaved as StatamicEventsEntrySaved;

// CB : Listen to BlueprintFound
use App\Listeners\BlueprintFound as BlueprintFound;
use Statamic\Events\BlueprintFound as StatamicEventsBlueprintFound;

// CB : Listen to ResponseCreated
use App\Listeners\ResponseCreated as ResponseCreated;
use Statamic\Events\ResponseCreated as StatamicEventsResponseCreated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        StatamicEventsEntrySaving::class => [
            EntrySaving::class,
        ],
        StatamicEventsEntrySaved::class => [
            EntrySaved::class,
        ],
        StatamicEventsBlueprintFound::class => [
            BlueprintFound::class,
        ],
        StatamicEventsResponseCreated::class => [
            ResponseCreated::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
