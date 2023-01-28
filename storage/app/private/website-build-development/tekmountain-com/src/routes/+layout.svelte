<script>
  /* Svelte imports */
  import { onMount, tick } from 'svelte';
  import { page } from '$app/stores';
  
  console.log( page );
  console.log( $page )
  
  /* Component imports */
  //...

  /* Global Stores */
  /** @type {import('./$types').LayoutData} */
  //export let data;
  
  let websitePageClass = 'home';

  onMount(async () => {
	// #Await...
	await tick();
	
	console.log( page );
	console.log( $page )
	//const response = await fetch( '/lib/data/websiteBuild.json' );
  	//const responseJson = await res.json();
	//console.log( responseJson );
  });
</script>


<svelte:head>
</svelte:head>

<main id="main" class='main main-{ websitePageClass }'>
  <slot />
</main>