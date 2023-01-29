<script>
  /* Svelte imports */
  import { onMount, tick } from 'svelte';
  import { page } from '$app/stores';
  
  /* Component imports */
  //.....

  /* Global Stores */
  
  /** @type {import('./$types').LayoutData} */
  export let data;
  
  const pageRouteId = $page.route.id;
  const pageName = ( pageRouteId === null ) 
  	? 'error'
  	:  ( pageRouteId === null )
  		? 'home' 
  		: pageRouteId;
  
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