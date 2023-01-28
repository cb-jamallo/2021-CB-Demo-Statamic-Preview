<script>
  /** @type {import('./$types').LayoutData} */
  export let data;
  
  /* Svelte imports */
  import { onMount, tick } from 'svelte';
  import { page } from '$app/stores';
  
  /* Component imports */
  //...

  /* Global Stores */
  
  let websitePageClass = 'home';

  onMount(async () => {
	// #Await...
	await tick();

	console.log( data );

  });
</script>


<svelte:head>
</svelte:head>

<main id="main" class='main main-{ websitePageClass }'>
  <slot />
</main>