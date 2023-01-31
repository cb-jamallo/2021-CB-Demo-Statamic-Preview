<script>
  
    'use strict';

    /**
    * Import Svelte Core JS
    */

    import { tick, onMount, afterUpdate } from 'svelte';

    /**
     * Import Svelte Components
     */


    /**
      * Import Custom JS
    */
    
    /**
      * Export Custom JS
    */

    export let active = false;

    onMount(async () => 
    {
        /* AWAIT */
	  	tick();
        
    });

    afterUpdate(async () => 
    {
        /* AWAIT */
        tick();
    
    });

</script>


<svelte:head>
    <!-- <script src="/lib/script/modal-subscribe.js"></script> -->
</svelte:head>