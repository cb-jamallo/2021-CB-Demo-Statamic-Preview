<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Classes\SchemaManager;
use App\Classes\NavigationManager;
use App\Classes\FileManager;
use App\Classes\FileManagerReplicate;

class EntrySaved
{


    private $schemaReset = false;

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
    public function handle( $event)
    {
        if (str_contains( $_SERVER['REQUEST_URI'],  '/cp/collections/website/entries' ) && str_contains( $event->entry->blueprint, 'website') )
        {
            
        }

        // MANUALLY GET PATH by running an echo $PATH in the project - HUGE PAIN IN THE ARSE!
        // ALSO ENSURE PERMISSIONS ARE 777 for Read,Write,Exec....
        //$get_v_node = exec('PATH=/usr/local/bin node -v 2>&1 &');
        //$get_v_npm = exec('PATH=/usr/local/bin npm -v 2>&1 &');
        // WORKS - #1 Path to global npm, call npm @cd path then 'run build;'
        //$get_v_npm2 = exec('PATH=/usr/local/bin && npm cd /Users/jamallo/Documents/CB-Web-Testing/2021-CB-Demo-Statamic/statamic-cms-dev-test/Website-Static run build 2>&1 &');
        
        // $exex_path = 'PATH=/usr/local/lib/node_modules/npm/node_modules/npm-lifecycle/node-gyp-bin:/Users/jamallo/Documents/CB-Web-Testing/2021-CB-Demo-Statamic/statamic-cms-dev-test/Website-Static/node_modules/.bin:/usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin:/Users/jamallo/.composer/vendor/bin:/Users/jamallo/.composer/vendor/bin;';
        // $exec_dir = 'cd /Users/jamallo/Documents/CB-Web-Testing/2021-CB-Demo-Statamic/statamic-cms-dev-test/Website-Static';
        // $exec_cmd = '&& npm run build 2>&1 &'; // append 2>&1 & to wait for command to complete.
        // $comm = exec($exex_path . $exec_dir . $exec_cmd);


    }
}

/* WORKS
exec('cd /Users/jamallo/Documents/CB-Web-Testing/2021-CB-Demo-Statamic/statamic-cms-dev-test/Website-Static/test.sh > /Users/jamallo/Documents/CB-Web-Testing/2021-CB-Demo-Statamic/statamic-cms-dev-test/Website-Static/test.log; PATH=/usr/local/bin; npm -v; 2>&1', $out, $err);
*/

// SEMI-WORKS
// exec('cd /Users/jamallo/Documents/CB-Web-Testing/2021-CB-Demo-Statamic/statamic-cms-dev-test/Website-Static; PATH=/usr/local/bin; npm run build; 2>&1', $out, $err)
// shell_exec('cd /Users/jamallo/Documents/CB-Web-Testing/2021-CB-Demo-Statamic/statamic-cms-dev-test/Website-Static/ && ls; 2>&1');