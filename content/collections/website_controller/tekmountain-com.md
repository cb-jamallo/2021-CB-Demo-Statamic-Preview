---
id: ccc0db71-e906-4743-bac8-0996ec068287
blueprint: website_controller
title: tekmountain.com
development-host:
  -
    base: tekmountain-com-dev.netlify.app
    protocol: https
    version: v-1-0-0
    package: _website-controller-host-packages/sveltekit-adapter-netlify-v-1-0-0-rc.zip
    sitemap:
      -
        uid: sitemap
        path: /static
        frequency: monthly
        priority: '05'
        type: item
        enabled: true
    type: item
    enabled: true
    robotTxt:
      -
        uid: robots
        path: /static
        content:
          code: |-
            User-agent: *
            Allow: *
          mode: shell
        type: item
        enabled: true
development-template:
  -
    uid: default
    path: /src/routes
    name: +page
    ext: svelte
    doctype:
      code: null
      mode: htmlmixed
    html:
      code: null
      mode: htmlmixed
    head:
      code: null
      mode: htmlmixed
    title:
      code: Tekmountain.com
      mode: htmlmixed
    link:
      code: null
      mode: htmlmixed
    meta:
      code: null
      mode: htmlmixed
    style:
      code: null
      mode: css
    script:
      code: null
      mode: javascript
    body:
      code: null
      mode: htmlmixed
    type: item
    enabled: true
development-code:
  -
    group: true
    uid: t1
    path: /static
    name: Core
    ext: html
    content:
      code: t
      mode: htmlmixed
    collection:
      -
        uid: env-development
        name: .
        ext: env.development
        content:
          code: |-
            # NODE VARS
            NODE_ENV=development

            # VITE VARS
            VITE_ENV=development
            VITE_SITE_TITLE=Castle Branch
            VITE_SITE_TITLE_SEPARATOR=|
          mode: htmlmixed
        type: item
        enabled: true
      -
        uid: app-html
        name: app
        ext: html
        content:
          code: |-
            <!DOCTYPE html>
            <html lang="en">
            	<head>
            	  <title>TekMountain.com</title>
            	  <link rel='canonical' href='[websiteBuild.domain.host.base]'>
            	  %sveltekit.head%
            	</head>
            	<body>
            	  	<div style="display: contents">
            	  		%sveltekit.body%
            	  	</div>
            	</body>
            </html>
          mode: htmlmixed
        type: item
        enabled: true
      -
        uid: +error-svelte
        path: /src/routes
        name: +error
        ext: svelte
        content:
          code: |-
            <script>
               import { page } from '$app/stores';
            </script>

            {@html JSON.stringify( $page )}
            {$page.status}: {$page.error.message}
          mode: htmlmixed
        type: item
        enabled: true
      -
        uid: +layout-js
        path: /src/routes
        name: +layout
        ext: js
        content:
          code: |-
            export const prerender = true;
            export const trailingSlash = 'always';
            export const ssr = false;

            /** @type {import('./$types').LayoutLoad} */
            export async function load({ fetch, params, url }) 
            {
                let data = null;
                let dataWebsiteReport = null;
              	let dataWebsiteControllerReport = null;
                let dataWebsiteBuildReport = null;
              	let dataWebsiteBuildNavigation = null;
              	
              	if ( url.searchParams.get('websiteReport')  === 'true' )
            	{ 
            		data = await fetch( '/lib/data/website/websiteReport.js' );
              		dataWebsiteReport = await data.json();
            	}
              	
                if ( url.searchParams?.get('websiteControllerReport') === 'true' )
            	{ 
            		data = await fetch( '/lib/data/website/websiteControllerReport.js' );
              		dataWebsiteControllerReport = await data.json();
            	}
              
              	if ( url.searchParams?.get('websiteBuildReport') === 'true' )
            	{ 
            		data = await fetch( '/lib/data/website/websiteBuildReport.js' );
              		dataWebsiteBuildReport = await data.json();
            	}
              
              	data = await fetch( '/lib/data/website/websiteBuildNavigation.js' );
              	dataWebsiteBuildNavigation = await data.json();
                
              	return { 
            	  dataWebsiteReport,
            	  dataWebsiteControllerReport,
            	  dataWebsiteBuildReport,
            	  dataWebsiteBuildNavigation,
            	};
              
            }
          mode: javascript
        type: item
        enabled: true
      -
        uid: +layout-svelte
        path: /src/routes
        name: +layout
        ext: svelte
        content:
          code: |-
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
          mode: htmlmixed
        type: item
        enabled: true
    type: item
    enabled: true
  -
    name: 'Component Stores'
    collection:
      -
        uid: store-js
        path: /src/lib/components/_stores
        name: store
        ext: js
        content:
          code: |-
            import { writable } from 'svelte/store';

            let Store = writable({

                headerLogo: true,
                ttpl: true,
                disqus: false

            });

            export default Store;
          mode: htmlmixed
        type: item
        enabled: true
      -
        uid: store-env-vars
        path: /src/lib/components/_stores
        name: store-env-vars
        ext: js
        content:
          code: |-
            export const StoreEnvVars = 
            {
                siteTitle: import.meta.env.VITE_SITE_TITLE,
                siteTitleSeparator: import.meta.env.VITE_SITE_TITLE_SEPARATOR,
            }
          mode: htmlmixed
        type: item
        enabled: true
    type: item
    enabled: true
  -
    name: 'Component Nav'
    collection:
      -
        uid: nav-ahref
        path: /src/lib/components
        name: nav-href
        ext: svelte
        content:
          code: |-
            <a {...$$restProps}>
             <slot></slot>
            </a>

            <style lang='postcss'></style>
          mode: htmlmixed
        type: item
        enabled: true
      -
        uid: nav-button
        path: /src/lib/components
        name: nav-button
        ext: svelte
        content:
          code: |-
            <button>
                <slot></slot>
            </button>

            <style lang='postcss'></style>
          mode: htmlmixed
        type: item
        enabled: true
      -
        uid: nav-menu
        path: /src/lib/components
        name: nav-menu-main
        ext: svelte
        content:
          code: |-
            <script>

                /**
                 * Import Svelte Components
                */
                

                /**
                * Import Svelte Core JS
                */
                
                import { tick, onMount, afterUpdate } from 'svelte';
                // import { base, assets } from '$app/paths';
                import { page } from '$app/stores'; // getStores, navigating, session, updated

                /**
                * Import Custom JS
                */
                
                /**
                * Export Custom JS
                */

                /*
                    NAVIGATION
                */

                let navMain = null;
                let navMainUl = null;
                let navMainButton = null;
                let navMainButtonClose = null;
                
                const navMainInit = () =>
                {

                    navMain = document.querySelector('.nav-main');
                    navMainUl = document.querySelector('.nav-main-ul');
                    navMainButton = document.querySelector('.nav-main-button');
                    navMainButtonClose = document.querySelector('.nav-main-button-close');

                    navMainInitMobile();
                    navMainInitDesktop();
                    
                    // navMainResize();
                    // window.dispatchEvent(new Event('resize'));
                }

                const navMainResize = () =>
                {
                    window.addEventListener('resize', ( _event ) => 
                    {
                        // if ( window.outerWidth <= 768) return navMainMobile();
                        
                        // return navMainInitDesktop();
                    });
                }

                const navMainInitMobile = () =>
                {

                    navMainButtonClose.addEventListener('pointerdown', (_event) =>
                    {
                        navMain.classList.toggle('nav-main-open');
                        navMain.classList.add('nav-main-close');
                        navMain.setAttribute('aria-expanded', 'false');
                        navMainButton.classList.toggle('hidden');
                        navMainButtonClose.classList.toggle('hidden');
                    });

                    navMainButton.addEventListener('pointerdown', (_event) =>
                    {
                        navMain.classList.toggle('nav-main-open');

                        if (!navMain.classList.contains('nav-main-open')) 
                        {
                            navMain.classList.add('nav-main-close');
                            navMainButton.setAttribute('aria-expanded', 'false');
                        }
                        else
                        {
                            navMain.classList.remove('nav-main-close');
                            navMainButton.setAttribute('aria-expanded', 'true');
                            navMainButton.classList.toggle('hidden');
                            navMainButtonClose.classList.toggle('hidden');
                        }

                    });
                
                }

                const navMainInitDesktop = () =>
                {
                    const menuItems = document.querySelectorAll('.nav-main-ul li.submenu');
                    
                    menuItems.forEach( ( _element, _elementIndex ) =>
                    {
                        var ahref =  _element.querySelector('a');
                        var button = `<button><span><span class="sr-only">show submenu for ${ahref.text}</span></span></button>`;

                        ahref.insertAdjacentHTML('afterend', button);
                        
                         _element.querySelector('button').addEventListener("hover",  ( _event ) =>
                        {
                            const parent = _event.target.parentNode.parentNode.parentNode;
                            const parentLink = parent.querySelector('a');
                            const parentButton = parent.querySelector('button'); console.log(parentButton)

                            parent.classList.toggle('expanded');

                            // if ( parent.classList.contains('expanded') )
                            // { 
                                parentLink.setAttribute('aria-expanded', String(parent.classList.contains('expanded')));
                                parentButton.setAttribute('aria-expanded', String(parent.classList.contains('expanded')));
                            // } 
                            // else 
                            // {
                            //     parentLink.setAttribute('aria-expanded', 'false');
                            //     parentButton.setAttribute('aria-expanded', 'false');
                            // }

                            _event.preventDefault();
                            _event.stopPropagation();

                        });
                    });
                }

                let navMainActive = () => {
                    
                    let navMainActiveClass = 'nav-main-a-active';
                    let navMainPath =  $page.url.pathname;
                    let navMainPathParts = $page.url.pathname.split('/').filter( _n => _n ); // remove empty items...
                    let navMainPathParts1 = navMainPathParts[0];

                    
                    const menuLinks = document.querySelectorAll('.nav-main-a');

                          menuLinks.forEach( ( _link, _index ) => {

                            if ( ( navMainPath === '/' && _index === 0) || navMainPathParts1?.includes( _link.innerText.toLowerCase().split(' ').join('-') ) ) 
                            {
                                // Set new...
                                _link.classList.add( navMainActiveClass );
                            }
                            else
                            {
                                // Clear all...
                                _link.classList.remove( navMainActiveClass );
                            }

                          });
                }

                onMount(async () => {
                    
                    // Perf delay tick.
                    tick();

                    navMainInit();
                    //console.log($base);
                    //console.log($navigating);
                    //console.log($page);
                    //console.log($session);
                    //console.log($updated);
                });

                afterUpdate( async() => {

                    tick();

                    navMainActive();
                
                });
            </script>

            <!-- @html{process.env.NODE_ENV} -->

            <nav class='nav-main nav-main-open' {...$$restProps} role="navigation" aria-label="Main Navigation">
                <a href='#main' class='nav-main-skip-link sr-only'>Skip Menu Items</a>
                <ul id='nav-main' class='nav-main-ul'>
                    <li class='nav-main-li'><a class='nav-main-a' href='/' target='_self'>Who We Are</a></li>
                    <li class='nav-main-li'><a class='nav-main-a' href='/what-we-do' target='_self'>What We Do</a></li>
                    <li class='nav-main-li'><a class='nav-main-a' href='/why-we-do-it' target='_self'>Why We Do It</a></li>
                    <li class='nav-main-li'><a class='nav-main-a' href='/insights' target='_self'>Insight</a></li>
                    <!-- <li class='nav-main-li'><a class='nav-main-a' href='/press' target='_self'>Press</a></li> -->
                    
                    <!--<li class="nav-main-li submenu">
                        <a href="/ttpl-study/sub" aria-haspopup="true" aria-expanded="false">
                            Sub
                        </a>
                        <ul>
                            <li><a href="/">...page</a></li>
                            <li><a href="/">...page</a></li>
                        </ul>
                    </li>  -->
                </ul>
            </nav>

            <button class='nav-main-button-close hidden'>
                <img class='nav-main-close-img' src='/lib/images/ttpl-close-icon.svg' alt='Close Button Iconographic' />
            </button>
            <button class='nav-main-button' aria-expanded="false" aria-controls='nav-main'>
                <span class='sr-only'>Menu</span>
                <img src='/lib/images/ttpl-menu-icon-mobile-blue-light.svg' alt='Menu Icon' />
            </button>


            <!-- 
            <li class="submenu">
                <a href="/ttpl-study/sub" aria-haspopup="true" aria-expanded="false">
                    Sub
                </a>
                <ul>
                    <li><a href="/">...page</a></li>
                    <li><a href="/">...page</a></li>
                </ul>
            </li> 
            -->

            <style lang='postcss'>
               
            </style>
          mode: htmlmixed
        type: item
        enabled: true
    type: item
    enabled: true
local-host:
  -
    base: tekmountain-com-local.netlify.app
    protocol: https
    version: v-1-0-0
    package: _website-controller-host-packages/sveltekit-adapter-netlify-v-1-0-0-rc.zip
    sitemap:
      -
        uid: sitemap
        path: static
        frequency: monthly
        priority: '05'
        type: item
        enabled: true
    type: item
    enabled: true
local-template:
  -
    uid: default
    path: /src/routes
    name: +page
    ext: svelte
    doctype:
      code: null
      mode: htmlmixed
    html:
      code: null
      mode: htmlmixed
    head:
      code: null
      mode: htmlmixed
    title:
      code: 'Tekmountain.com, Welcome!'
      mode: htmlmixed
    link:
      code: null
      mode: htmlmixed
    meta:
      code: null
      mode: htmlmixed
    style:
      code: null
      mode: css
    script:
      code: null
      mode: javascript
    body:
      code: null
      mode: htmlmixed
    type: item
    enabled: true
local-code:
  -
    uid: htaccess
    name: .
    ext: htaccess
    content:
      code: |-
        # ---------------------
        # Handle Rewrites
        # ---------------------
        RewriteEngine on
        ErrorDocument 404 /404.html
      mode: htmlmixed
    type: item
    enabled: false
  -
    uid: env-local
    name: .
    ext: env.local
    content:
      code: |-
        # NODE VARS..

        # VITE VARS
        VITE_ENV=local
      mode: htmlmixed
    type: item
    enabled: true
    path: src/../
  -
    uid: app-html
    name: app
    ext: html
    content:
      code: |-
        <!DOCTYPE html>
        <html lang="en">
        	<head>
        	  <title>TekMountain.com</title>
        	  <link rel='canonical' href='[websiteBuild.domain.host.base]'>
        	  %sveltekit.head%
        	</head>
        	<body>
        	  	<div style="display: contents;">
        	  	    %sveltekit.body%
                </div>
        	</body>
        </html>
      mode: htmlmixed
    type: item
    enabled: true
  -
    uid: +error-svelte
    path: /src/routes
    name: +error
    ext: svelte
    content:
      code: |-
        <script>
           import { page } from '$app/stores';
        </script>

        {@html JSON.stringify( $page )}
        {$page.status}: {$page.error.message}
      mode: htmlmixed
    type: item
    enabled: true
  -
    uid: +layout-js
    path: /src/routes
    name: +layout
    ext: js
    content:
      code: |-
        export const prerender = true;
        export const trailingSlash = 'always';
        export const ssr = false;


        export async function load( fetch, params, route, url, parent ) 
        {
          
          const response = await fetch( '/lib/data/websiteBuild.json' );
          const responseJson = await res.json();
         
          return
          {
        	test: responseJson
          };
        }
      mode: javascript
    type: item
    enabled: true
  -
    uid: +layout-svelte
    path: /src/routes
    name: +layout
    ext: svelte
    content:
      code: |-
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
      mode: htmlmixed
    type: item
    enabled: true
run: false
updated_by: 3fcfe9a1-6362-444c-8d55-030541dd2f8d
updated_at: 1675028635
---
