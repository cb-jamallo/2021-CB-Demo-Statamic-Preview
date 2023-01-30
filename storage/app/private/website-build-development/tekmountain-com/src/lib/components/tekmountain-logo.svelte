<script>

    /**
     * Import Svelte Components
    */
    

    /**
    * Import Svelte Core JS
    */
    
    import { tick, onMount } from 'svelte';
    // import { base, assets } from '$app/paths';
    // import { getStores, navigating, page, session, updated } from '$app/stores';
    // import { page } from '@sveltejs/kit/app/stores.js' SSR REQUIRED FOR THIS TO FUNCTION

    /**
    * Import Custom JS
    */
    
    /**
    * Export Custom JS
    */
    export let logoDirection = 'horizontal'; // horizontal | vertical
    export let logoType = 'normal'; // normal | reversed
    export let logoAlt = 'TekMountain logo mark and logo type'; // normal | reversed
    

    onMount(() =>
    {
        // Perf delay tick.
        tick();
        
    });
</script>

{#if logoDirection === 'horizontal' }
    {#if logoType === 'normal' }
        <img src='/lib/images/tekmountain-logo-horizontal-color.svg' {...$$restProps} alt='{logoAlt}' />
    {:else}
        <img src='/lib/images/tekmountain-logo-horizontal-reversed.svg'  {...$$restProps} alt='{logoAlt}' />
    {/if}
{:else}
    {#if logoType === 'normal' }
        <img src='/lib/images/tekmountain-logo-vertical-color.svg'  {...$$restProps} alt='{logoAlt}' />
    {:else}
        <img src='/lib/images/tekmountain-logo-vertical-reversed.svg' {...$$restProps} alt='{logoAlt}' />
    {/if}
{/if}


<style lang='postcss'></style>