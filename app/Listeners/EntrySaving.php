<?php

namespace App\Listeners;

// Laravel Classes
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

// Statamic Classes

// Custom Classes
use App\Classes\SchemaClass;
use App\Classes\SchemaReplicateWebsiteControllerClass;
use App\Classes\SchemaReplicateWebsiteClass;
use App\Classes\ToastClass;

class EntrySaving
{

    private const ERROR_SCHEMA_WEBSITE = 'Failed build for Website %s';
    private const ERROR_SCHEMA_WEBSITE_CONTROLLER = 'Failed build for WebsiteController %s';

    private $schemaClass = null;

    private $schema = null;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {   
       
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle( $event )
    {
        
        // Handle Schema Initialization
        $schemaClass = new SchemaClass(array(
            'event' => $event,
        ));

        // Handle Published WebsiteControllers 
        if (str_contains( $_SERVER['REQUEST_URI'], '/cp/collections/website_controller/entries' ) && 
            str_contains( $event->entry->blueprint, 'website_controller' ) &&
            $event->entry->published())
        {

            try {

                // Handle Messages to FE
                ToastClass::reset();
                
                // Handle Schema Parsing
                $schema = $schemaClass->initWebsiteController(); // returns ->schema

                // Handle Schema Replication
                $schemaClass->initWebsiteControllerReplicate();

                // Handle Schema Reset
                $schemaClass->initWebsiteControllerReset();

                ToastClass::report(array(
                    'toastMessage' => 'Build Completed Successfully: ' . number_format( $schemaClass->perfStopwatchFinal, 3, '.', '') . 'ms',
                    'toastDuration' => 4000
                ));

            }
            catch(\Exception $_error)
            {

                $errorMessage = sprintf( 
                    $this::ERROR_SCHEMA_WEBSITE_CONTROLLER,
                    $event->entry->slug(),
                );

                ToastClass::report(array(
                    'toastMessage' => 'Build Error: ' . number_format( $schemaClass->perfStopwatchFinal, 3, '.', '') . 'ms' . ' :: ' . $errorMessage,
                    'toastType' => 'error',
                    'toastDuration' => 4000
                ));

            }

        }

        // Handle Published Website
        if (str_contains( $_SERVER['REQUEST_URI'],  '/cp/collections/website/entries' ) && 
            str_contains( $event->entry->blueprint, 'website' ) &&
            $event->entry->published())
        {

            try {
                
                // Track new messages
                ToastClass::reset();

                // Handle Schema Parsing
                $schema = $schemaClass->initWebsite(); // returns ->schema
                
                // Handle Schema Reset
                $schemaClass->initWebsiteReplicate();

                // Handle Schema Reset
                $schemaClass->initWebsiteReset();

                // Report new messages
                ToastClass::report(array(
                    'toastMessage' => 'Build Completed Successfully: ' . number_format( $schemaClass->perfStopwatchFinal, 3, '.', '') . 'ms',
                    'toastDuration' => 4000
                ));

            }
            catch(\Exception $_error)
            {

                $errorMessage = sprintf( 
                    $this::ERROR_SCHEMA_WEBSITE,
                    $event->entry->slug(),
                );

                ToastClass::log(array(
                    'toastType' => 'error',
                    'toastMessage' => $errorMessage,
                    'toastDuration' => 4000
                ));

            }
        }

    }
}