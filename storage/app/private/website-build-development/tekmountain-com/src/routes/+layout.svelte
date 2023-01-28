<script>
  /* Svelte imports */
  import { onMount, tick } from 'svelte';
  import { page } from '$app/stores';
  
  console.log( $page )
  
  /* Component imports */
  //.....

  /* Global Stores */
  /** @type {import('./$types').LayoutData} */
  //export let data;
  
  let websitePageClass = 'home';

  onMount(async () => {
	// #Await...
	await tick();
	
	console.log( $$props )
	console.log( $page )
	console.log( {"id":"8fe0f1f3-c0b7-4b5e-9483-a18722504c5d","title":"Home","slug":"","uri":"","enabled":true} )
	const response = await fetch( '/lib/data/websiteBuild.json' );
  	const responseJson = await response.json();
	console.log( responseJson );
  
  });
</script>


<svelte:head>
</svelte:head>

<main id="main" class='main main-{ websitePageClass }'>
  <slot />
</main>