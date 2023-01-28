<script>
  /* Svelte imports */
  import { onMount, tick } from 'svelte';
  import { page } from '$app/stores';
  
  /* Component imports */
  //...

  /* Global Stores */
  /** @type {import('./$types').LayoutData} */
  //export let data;
  
  let websitePageClass = 'home';

  onMount(async () => {
	// #Await...
	await tick();

	//const response = await fetch( '/lib/data/websiteBuild.json' );
  	//const responseJson = await res.json();
	//console.log( responseJson );
  });
</script>


<svelte:head>
</svelte:head>

Debug page....
{@debg websitePageClass}
{@debug $page}
{@debug page}
<main id="main" class='main main-{ websitePageClass }'>
  <slot />
</main>