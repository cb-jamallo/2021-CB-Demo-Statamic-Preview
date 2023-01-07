<script>
  
  /* Svelte imports */
  import { onMount, tick } from 'svelte';
  
  /* Component imports */
  //...
  
  /* Global Stores */
  const websiteNavigation = {"id":"644131f9-1ab3-4e5a-bb06-7c6170657621","title":"Home","slug":"","uri":"","enabled":true,"children":[{"id":"6134a0ca-717e-4251-8d41-d93319d3d010","title":"Child Page","slug":"child-page","uri":"/child-page","enabled":true,"breadcrumb":[{"id":"644131f9-1ab3-4e5a-bb06-7c6170657621","title":"Home","slug":"","uri":""}],"children":[{"id":"e25d3846-1644-4294-9bab-fbe693a12b04","title":"Grandchild Page","slug":"grandchild-page","uri":"/child-page/grandchild-page","enabled":true,"breadcrumb":[{"id":"644131f9-1ab3-4e5a-bb06-7c6170657621","title":"Home","slug":"","uri":""},{"id":"6134a0ca-717e-4251-8d41-d93319d3d010","title":"Child Page","slug":"child-page","uri":"/child-page"}]}]}]};
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

<main id="main" class='main {websitePageClass}'>
  <slot />
</main>