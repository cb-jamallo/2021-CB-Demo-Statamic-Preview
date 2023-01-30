<script>

	/* SVELTE/KIT IMPORTS */
	import { tick, onMount } from 'svelte';

	/* CUSTOM IMPORTS */

	/* CUSTOM JS */
	export let logoDirection = 'horizontal'; // horizontal | vertical
	export let logoType = 'normal'; // normal | reversed
	export let logoAlt = 'TekMountain logo mark and logo type'; // normal | reversed


	onMount(() =>
			{
	  tick();

	});
  
</script>

{#if logoDirection === 'horizontal' }
    {#if logoType === 'normal' }
        <img src='/lib/image/tekmountain-logo-horizontal-color.svg' {...$$restProps} alt='{logoAlt}' />
    {:else}
        <img src='/lib/image/tekmountain-logo-horizontal-reversed.svg'  {...$$restProps} alt='{logoAlt}' />
    {/if}
{:else}
    {#if logoType === 'normal' }
        <img src='/lib/image/tekmountain-logo-vertical-color.svg'  {...$$restProps} alt='{logoAlt}' />
    {:else}
        <img src='/lib/image/tekmountain-logo-vertical-reversed.svg' {...$$restProps} alt='{logoAlt}' />
    {/if}
{/if}


<style lang='postcss'></style>