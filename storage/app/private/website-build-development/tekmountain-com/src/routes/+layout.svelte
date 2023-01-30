<script>
  /* Svelte imports */
  import { onMount, afterUpdate, tick } from 'svelte';
  import { page } from '$app/stores';
  
  /* Component imports */
  import TekMountainLogo from "$lib/components/tekmountain-logo.svelte";
  import NavAHref from "$lib/components/nav-ahref.svelte";
  import NavMenuMain from "$lib/components/nav-menu-main.svelte";

  import TTPLSignup from "$lib/components/ttpl-sign-up.svelte";

  /* Global Stores */
  
  /** @type {import('./$types').LayoutData} */
  export let data;
  
  const pageRouteId = $page.route.id;
  const pageName = ( pageRouteId === null ) 
  	? 'error'
  	:  ( pageRouteId === null )
  		? 'home' 
  		: pageRouteId.replace('/', '');
  
	/* Component JS */
	let swiperInstances = [];
	let swiperInstanceList = null;

	const swiperInstanceWhatDrivesUs = ( _ARGS ) =>
	{

	}

	const swiperInstanceListInit = () =>
	{
	  swiperInstanceList = document.querySelectorAll('.swiper'); 

	  swiperInstanceList.forEach( ( _swiper, _swiperIndex ) =>
								 {

		swiperInstanceListResize( 
		  swiperInstanceListConfig(
			_swiper, 
			JSON.parse( _swiper.getAttribute('data-swiper' ) )
		  )
		);

	  });
	}

	const swiperInstanceListResize = ( _ARGS ) => 
	{
	  let swiper = _ARGS.swiper;
	  let swiperInstance = _ARGS.swiperInstance;
	  let swiperConfig = _ARGS.swiperConfig;
	  let swiperParent = swiper.parentNode;

	  let swiperParentWidth = () =>
	  { 
		if ( !swiperConfig?.destroy )
		{
		  console.log(`${swiper.getBoundingClientRect().width}`  )
		  swiper.style.width = `${swiper.getBoundingClientRect().width}px`;
		}
		else
		{
		  swiper.firstChild.classList.remove('swiper-wrapper');
		  swiper.style.width = 'auto';
		  swiperInstance.destroy( true, true );
		}
	  }

	  window.addEventListener( 'resize', ( _resize ) => {

		swiperParentWidth();

	  });

	  swiperParentWidth();

	  return _ARGS;
	}

	const swiperInstanceListConfig = ( _swiper, _swiperConfig ) =>
	{
	  console.log( _swiper, _swiperConfig)
	  let swiper = _swiper;
	  let swiperId = _swiperConfig.id;
	  let swiperConfig = _swiperConfig;

	  if ( window.outerWidth <= 767 )
	  {

		swiperConfig = swiperConfig.mobile.config;

		if ( swiperConfig.scrollbar === true )
		{
		  swiperConfig.scrollbar = false;
		  swiper.querySelector( '.swiper-scrollbar' )?.remove();
		}
	  }
	  else
	  { 

		swiperConfig = swiperConfig.desktop.config;

		if ( swiperConfig.scrollbar === true )
		{
		  delete( swiperConfig.scrollbar );
		  swiperConfig.scrollbar = { el: ".swiper-scrollbar", draggable: true, hide: false }; 
		}

	  }

	  swiperConfig.a11y = true;
	  swiperConfig.keyboardControl = true;
	  swiperConfig.grabCursor = true;

	  let swiperInstance = new Swiper( swiper, swiperConfig );
	  // swiperInstance.on('slideChange', function () {
	  //   console.log('slide changed');
	  // });
	  swiperInstances.push( swiperInstance );

	  return {
		swiper: swiper,
		swiperId: swiperId,
		swiperInstance: swiperInstance, 
		swiperConfig: swiperConfig
	  }

	}
	
	let ttpl = false;
  
	onMount(async () => {
	  // #Await...
	  await tick();

	  //$page.data = data
	  $Store.ttpl = ( window.location.href.includes( 'ttpl-study' ) );

	});

	afterUpdate(async () => {
	  //
	  tick();

	  swiperInstanceListInit();
	  window.swiperInstances = swiperInstances;

	  $Store.disqus = ( window.location.pathname.includes('/insights/') && window.location.pathname !== '/insights/' && window.location.pathname !== '/insights' );

	});
  
</script>



<svelte:head>

  <!-- Preconnects -->
  <link rel="preconnect" href="https://use.typekit.net/cxm7vfw.css" />  
  <link rel="preconnect" href="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js" />
  <link rel='preconnect' href="https://unpkg.com" />
  
  <!-- Preload: Styles -->
  <link rel="preload" as="style" href="https://use.typekit.net/cxm7vfw.css" />
  <link rel="preload" as="style" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

  <!-- Preload: Scripts -->
  <link rel="preload" as="script" href="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js" />
  <link rel="preload" as="script" href="https://unpkg.com/swiper/swiper-bundle.min.js" />
  
  <!-- Stylesheets: 3rd-Party -->
  <link rel="stylesheet" href="https://use.typekit.net/cxm7vfw.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

  <!-- Scripts: 3rd-Party -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <script defer src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

</svelte:head>

<header class='header' tabindex='0'>

    {#if $Store.headerLogo }
    <NavAHref class='logo' href='/' target='_self'>
        <TekMountainLogo logoDirection='horizontal' logoType='normal' logoAlt='Navigation home page. TekMountain Logo.' />
    </NavAHref>
    {/if}
    <NavMenuMain class='nav-main' />
</header>

<main id="main" class='main main-{ pageName }'>
    <slot />
    {#if $Store.disqus }
        <section tabindex="0" class="grid margin-bottom-6--sm margin-top-6--sm margin-top-4--lg  margin-bottom-4--lg">
            <div id='disqus_thread' class="padding-x-4--sm padding-x-4--lg"></div>
        </section>
        <script>

            const sitePageEmbedUrl = (window.location.hostname === 'sveltekit.tekmountain.com') 
            ? 'https://dev-tekmountain-com.disqus.com/embed.js' 
            : (window.location.hostname === 'test.tekmountain.com') 
                ? 'https://test-tekmountain-com.disqus.com/embed.js'
                : 'https://tekmountain-com.disqus.com/embed.js'
            const sitePageUrl = window.location.href;
            const sitePageId = window.location.href.replace(/http\:\/\//g, '');
            const sitePageTitle = (document.querySelector('title')) ? document.querySelector('title').innerText : window.location.pathname;
            console.log(`disqus tracking sitePageEmbedUrl ${sitePageEmbedUrl}`);
            console.log(`disqus tracking sitePageUrl ${sitePageUrl}`);
            console.log(`disqus tracking sitePageId ${sitePageId}`);
            console.log(`disqus tracking sitePageTitle ${sitePageTitle}`);

            /**
             *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
             *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
            
            var disqus_config = function () {
                this.page.url = sitePageUrl;  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = sitePageId; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                this.page.title = sitePageTitle;
            };
            
            (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = sitePageEmbedUrl;
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
            })();

        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    {/if}
</main>

<footer class='footer' tabindex='0'>

</footer>

{#if $Store.ttpl }
<TTPLSignup />
{/if}

<style global lang="scss">

  @import "$lib/css/font.css";
  @import "$lib/css/reset.css";
  @import "$lib/css/variable.css";
  @import "$lib/css/typography.css";
  @import "$lib/css/button.css";
  @import "$lib/css/block.css";
  @import "$lib/css/grid.css";
  @import "$lib/css/global.css";
  @import "$lib/css/ttpl-sign-up.css";
  
  /*
  body { background-size: 100% auto; background-image: url('/lib/images/onionskin-hero-desktop.png'); background-repeat: no-repeat; }
  */
  
</style>