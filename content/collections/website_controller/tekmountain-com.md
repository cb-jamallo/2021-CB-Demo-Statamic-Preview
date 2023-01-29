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
    name: 'Component TTPL'
    collection:
      -
        uid: ttpl-sign-up
        name: ttpl-sign-up
        ext: svelte
        content:
          code: |-
            <script>
              
                'use strict';

                /**
                * Import Svelte Core JS
                */

                import { tick, onMount, afterUpdate } from 'svelte';

                /**
                 * Import Svelte Components
                 */


                /**
                  * Import Custom JS
                */
                
                /**
                  * Export Custom JS
                */
                let formBanner = null;
                let formModal = null;
                let formModalCloseBtn = null;
                let form = null;
                let formLoader = null;
                let formSubmit = null;
                let formThankYou = null;
                let formError = null;


                const formBannerAnimate = () => 
                {
                    
                    let blocks = [ 
                        document.querySelector('.banner .header'),
                        document.querySelector('.banner .body'),
                        document.querySelector('.banner-content')
                    ];
                    
                    let blocksLoop = 0;

                    // Slide-up banner
                    anime({
                        targets: [formBanner],
                        opacity: [0, 1],
                        delay: 1750,
                        duration: 250,
                        loop: false,
                        begin: ( _anim ) =>
                        {
                            if ( window.outerWidth <= 767 ) blocks[1].style.opacity = 0;
                            _anim.animatables[0].target.classList.remove('sr-only');
                        },
                        complete: ( _anim ) =>
                        {
                            if ( window.outerWidth <= 767 )
                            {
                                let loop1 = anime({
                                    targets: [blocks[0]],
                                    delay: 2000,
                                    opacity: [1, 0],
                                    duration: 1200,
                                    endDelay: 2250,
                                    direction: 'alternate',
                                    loop: true,
                                    easing: 'easeInOutSine'
                                });

                                let loop2 = anime({
                                    targets: [blocks[1]],
                                    delay: 2000,
                                    opacity: [0, 1],
                                    duration: 1200,
                                    endDelay: 2250,
                                    direction: 'alternate',
                                    loop: true,
                                    begin: ( _anim ) => {

                                        anime({
                                            targets: [blocks[2]],
                                            delay: -250,
                                            opacity: [0, 1],
                                            marginBottom: ['-16.367vw', '16.067vw'], 
                                            duration: 750,
                                            easing: 'easeInOutSine'
                                        });
                                    },
                                    loopComplete: () => { 
                                        blocksLoop++;
                                        if ( blocksLoop > 4 )
                                        {
                                            loop1.pause;
                                            loop2.pause;
                                            anime({
                                                targets: [blocks[2]],
                                                delay: 0,
                                                marginBottom: '-20vw',
                                                duration: 500,
                                                loop: false,
                                                easing: 'easeInOutSine'
                                            });
                                        }
                                    },
                                    easing: 'easeInOutSine'
                                });
                            }
                        },
                        easing: 'easeInOutSine'
                    });

                };

                /** Form modal open */
                const formModalOpen = () => {

                    formModal.classList.add('active');

                    anime({
                        targets: [formModal],
                        delay: 0,
                        opacity: [0, 1],
                        translateY: ['100vh', '0vh'],
                        duration: 250,
                        easing: 'easeInOutSine',
                        begin: ( _anim ) => {
                            formModal.classList.add('active');
                        }
                    });

                };

                /** Form modal close */
                const formModalClose = () => {

                    anime({
                        targets: [formModal],
                        delay: 0,
                        opacity: [1, 0],
                        translateY: ['1vh', '100vh'],
                        duration: 250,
                        easing: 'easeInOutSine',
                        complete: ( _anim ) => {
                            formModal.classList.remove('active');
                        }
                    });
                };

                /** Form serialization */
                const formDataSerialize = ( _form ) =>
                {
                    let formDataSerialized = {};
                    for (let [key, value] of new FormData( _form ) )
                    {
                        if (formDataSerialized[key] !== undefined)
                        {
                            if (!Array.isArray(formDataSerialized[key]))
                            {
                                formDataSerialized[key] = [formDataSerialized[key]];
                            }

                            formDataSerialized[key].push(value);
                        } else
                        {
                            formDataSerialized[key] = value;
                        }
                    }

                    return formDataSerialized;
                }

                const init = () =>
                {
                    formBanner = document.querySelector('.banner');
                    formModal = document.querySelector('.modal');
                    formModalCloseBtn = document.querySelector('.modal-close-btn');
                    form = document.querySelector('.modal-form-subscribe');
                    formLoader = document.querySelector('.modal-form-loader');
                    formSubmit = document.querySelector('.modal-form-submit');
                    formThankYou = document.querySelector('.modal-form-thank-you');
                    formError = document.querySelector('.modal-form-error');

                    /** Enable form submit */
                    form.addEventListener('submit', ( _event ) =>
                    {
                        _event.preventDefault();
                        _event.stopPropagation();
                    
                        // Submit Gate Test: Honeypot as inputis empty.
                        if ( document.querySelector('input[name=_confirm]').value !== '' ) return;
                    
                        // Submit Gate Test:  Honeypot as checked.
                        if ( document.querySelector('input[name=_confirm2]').checked ) return;
                    
                        formLoader.classList.remove('hidden');
                        formSubmit.value = '';
                        
                        let formData = formDataSerialize( _event.target );
                            formData.site = 'tekmountain.com'
                            formData.form = 'TekMountain Newsletter Signup';
                            formData.url = window.location.href;
                        
                        //fetch('https://submit-form.com/Y6utqnzM', // Test Form
                        fetch('https://submit-form.com/zv3SOHms', // Live Form
                        {
                            method: 'post',
                            headers: {
                                'Content-type': 'application/json; charset=UTF-8'
                            },
                            body: JSON.stringify( formData )
                        }).then(function(response)
                        {
                            return response.json();
                        }).then(function(data)
                        {
                            form.classList.add('hidden'); 
                            
                            if ( data?.name === formData?.name )
                            {
                                formThankYou.classList.remove('hidden');
                            }
                            else
                            {
                                formError.classList.remove('hidden');
                            }
                        });
                    
                        return false;
                    });
                    
                    /** Enable form submit ability after minimal input */
                    let formEnable = ( _event ) =>
                    {   

                        // Submit Gate Test: Ensure proper user event types triggered to test required validity
                        if ( _event.type !== 'pointerdown' && ( _event.type !== 'keydown' && _event?.key?.toLowerCase() !== 'tab' ) ) return;
                        
                        console.log( 'banner', _event.type, formSubmit, formBanner )
                    
                        // Submit Gate Test: Required fields validated for enabling submit button
                        if ( !document.querySelector('input[name=name]').checkValidity() ||
                            !document.querySelector('input[name=email]').checkValidity() ||
                            !document.querySelector('input[name=company]').checkValidity() ) return;
                        
                        formSubmit.removeAttribute("disabled");
                    }
                    
                    form.addEventListener( 'pointerdown', formEnable, false);
                    form.addEventListener( 'keydown', formEnable, false);
                    
                    /** Automate honeypot add after delay... */
                    let formDelay = setTimeout( () =>
                    {
                        const honeypot = document.createElement("input");
                            honeypot.setAttribute('type', 'checkbox');
                            honeypot.setAttribute('name', '_confirm2');
                            honeypot.setAttribute('style', 'display:none');
                            honeypot.setAttribute('autocomplete', 'off');
                        
                        form.appendChild( honeypot );
                    
                        clearTimeout( formDelay );
                    
                    }, 2500);
                    
                    /** Open form */
                    formBanner.addEventListener( 'pointerdown', ( _event ) => {
                        formModalOpen();
                    });
                    
                    /** Close form */
                    formModalCloseBtn.addEventListener( 'pointerdown', ( _event ) => {
                        formModalClose();
                    });
                    
                    formBannerAnimate();

                };
                
                onMount(async () => 
                {
                    //
                    tick();
                    
                    init();
                });

                afterUpdate(async () => 
                {
                    //
                    tick();
                
                });

            </script>
             
             <div class='banner sr-only position-fixed z-200 grid grid-stacked'>
                <button class='banner-cta z-2 place-self-end-center--sm place-self-end-end--lg'>
                    <span class='banner-cta-txt'>Join Our Newsletter</span>
                    <!-- <span class='banner-cta-icon'>...</span> -->
                </button>
                <div class='banner-content grid grid-stacked z-1 place-self-center-start--lg'>
                    <h5 class='header z-1'>Get <span class='highlight'>TTPL Study <br class='br--sm' />updates</span> in your inbox.</h5>
                    <p class='body z-1'>
                        TekMountain updates subscribers <br class='br--sm' />on what's new every few weeks.
                    </p>
                </div>
            </div>


            <div class='modal position-fixed z-1000 z-inset-0 modal-newsletter-subscribe'>
                <div class='modal-close position-absolute z-2 z-right-0'>
                    <button class='modal-close-btn'>
                        <span class='modal-close-btn-txt sr-only'>Close</span>
                        <span class='modal-close-btn-icon'><img src='/lib/images/ttpl-close-icon.svg' alt='Close "x" icon' /></span>
                    </button>
                </div>
                <div class='modal-wrapper position-absolute z-1 z-inset-0 grid'>
                    <div class='modal-content grid grid-2--lg place-self-center-center'>
                        <div class='place-self-center-center--sm place-self-center-start--lg'>
                            <img class='header-logo' src='/lib/images/tekmountain-logo.svg' alt='TekMountain, Brand Logo Mark and Type'/>
                            <h1 class='header'><span>Newsletter</span> Signup</h1>
                            <p>
                                Get <span class='highlight'>TTPL Study updates</span> in your inbox.
                                <br />TekMountain updates subscribers <br />on what's new every few weeks.
                            </p>
                        </div>
                        <div class='place-self-center-center--sm place-self-center-end--lg'>
                            <div class='modal-content-divider'></div>
                            <form class='modal-form-subscribe'>
                                <div class='field grid grid-stacked'>
                                    <label class='z-2 place-self-end-center' for='name'>( Name )</label>
                                    <input class='z-1' id='name' name='name' type='text' placeholder='Name*' autocomplete="off" pattern={'\\S{1,}'} required>
                                </div>
                                <div class='field grid grid-stacked'>
                                    <label class='z-2 place-self-end-center' for='name'>( Email )</label>
                                    <input class='z-1' id='email' name='email' type='email' placeholder='Email*' autocomplete="off" pattern={'\\S{2,}\\@{1}\\{2,}.{1}\\S{2,}'} required>
                                </div>
                                <div class='field grid grid-stacked'>
                                    <label class='z-2 place-self-end-center' for='company'>( Company )</label>
                                    <input class='z-1' id='company' name='company' type='text' placeholder='Company*' autocomplete="off" pattern={'\\S{1,}'} required>
                                </div>
                                <div class='field grid grid-stacked'>
                                    <div class='modal-form-loader z-2 z-1 place-self-center-center hidden'></div>
                                    <input class='modal-form-submit' id='submit' name='submit' type='submit' value='Join Now' disabled>
                                </div>
                                <input type="input" name="_confirm" style="display:none" autocomplete="off">
                                <input type="hidden" name="_redirect" value="false" />
                            </form>
                            <p class='modal-form-thank-you hidden'>Thank you!<br />You're now subscribed.</p>
                            <p class='modal-form-error hidden'>We're sorry.<br />There seems to be a technical problem.<br />Please try back again later.</p>
                        </div>

                    </div>
                </div>
                <div class='modal-background'></div>
            </div>
          mode: htmlmixed
        type: item
        enabled: true
        path: /src/lib/components
    type: item
    enabled: true
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
            	  <link rel='canonical' href='[[[websiteBuild.domain.host.base]]]'>
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
updated_at: 1675033021
---
