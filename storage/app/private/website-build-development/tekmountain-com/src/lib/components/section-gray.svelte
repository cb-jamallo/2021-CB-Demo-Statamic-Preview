<script>
    /**
        * Import Svelte Core JS
    */
    
    import { tick, onMount } from 'svelte';

    /**
        * Import Svelte Components
    */
               
    /**
        * Import Custom JS
    */
    
    /**
        * Export Custom JS
    */

    
    onMount(async () => {
        //
        tick();
    });

</script>

<section {...$$props}>
    <slot></slot>
</section>

<style global class='postcss'></style>