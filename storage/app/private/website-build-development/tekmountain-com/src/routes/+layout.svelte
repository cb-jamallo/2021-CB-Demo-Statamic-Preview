<script>
  /* Svelte imports */
  import { onMount, tick } from 'svelte';
  import { page } from '$app/stores';
  
  /* Component imports */
  //.....

  /* Global Stores */
  
  /** @type {import('./$types').LayoutData} */
  export let data;
  
  export let pagePathname = page.url.pathname;
  export let pagePathnameParts = page.url.pathname.split( '/' );
  
  export let pageName = pagePathnameParts[ pagePathnameParts.length -1 ];
  
  onMount(async () => {
	// #Await...
	await tick();
	
	console.log( data );
	console.log( $page );
  
  });
</script>


<svelte:head>
</svelte:head>

<main id="main" class='main main-{ pageName }'>
  Hello World!!!
  <slot />
</main>