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

<section class='section-blue {$$restProps.class}'>
    <slot></slot>
</section>

<style global class='postcss'></style>