<script>

  /* Svelte imports */
  import { onMount, tick } from 'svelte';

  /* Component imports */
  //...

  /* Global Stores */
  const websiteJson = htmlDecode( <script>

  /* Svelte imports */
  import { onMount, tick } from 'svelte';

  /* Component imports */
  //...

  /* Global Stores */
  const websiteJson = htmlDecode( [websiteJson] );
  const websiteNavigation = {"id":"8fe0f1f3-c0b7-4b5e-9483-a18722504c5d","title":"Home","slug":"","uri":"","enabled":true};
  let websitePageClass = 'home';

  onMount(async () =>
		  {
	// #Await...
	await tick();

	console.log( websiteNavigation );

  });
</script>


<svelte:head>
</svelte:head>


<main id="main" class='main { websitePageClass }'>
  {@html JSON.stringify( { websitePageClass } ) }
  <slot />
</main> );
  const websiteNavigation = {"id":"8fe0f1f3-c0b7-4b5e-9483-a18722504c5d","title":"Home","slug":"","uri":"","enabled":true};
  let websitePageClass = 'home';

  onMount(async () =>
		  {
	// #Await...
	await tick();

	console.log( websiteNavigation );

  });
</script>


<svelte:head>
</svelte:head>


<main id="main" class='main { websitePageClass }'>
  {@html JSON.stringify( { websitePageClass } ) }
  <slot />
</main>