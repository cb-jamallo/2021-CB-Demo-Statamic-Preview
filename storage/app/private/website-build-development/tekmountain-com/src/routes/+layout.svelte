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
  		: pageRouteId.replace('/', '');
  
  onMount(async () => {
	// #Await...
	await tick();
	
	//$page.data = data
  
  });
</script>


<svelte:head>
</svelte:head>

<header class='header' tabindex='0'>
</header>

<main id="main" class='main main-{ pageName }'>
  Hello World!!!
  <slot />
</main>