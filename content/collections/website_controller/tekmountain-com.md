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
      code: ESPN.com
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
  -
    name: CSS
    collection:
      -
        uid: variable
        path: /src/lib/css
        name: variable
        ext: css
        content:
          code: |-
            :root
            {
                
                /*
                    ----------------------------------------------------
                    FAMILY
                    ----------------------------------------------------
                */

                --type-family: 'forma-djr-micro', sans-serif;;
                --type-family-header: 'industry', sans-serif;

                /*
                    ----------------------------------------------------
                    WEIGHT
                    ----------------------------------------------------
                */

                --type-weight-exrta-thin: 100;
                --type-weight-thin: 200;
                --type-weight-light: 300;
                --type-weight-normal: 400;
                --type-weight-medium: 500;
                --type-weight-demi: 600;
                --type-weight-bold: 700;
                --type-weight-extra-bold: 800;
                --type-weight-black: 900;

                /*
                    ----------------------------------------------------
                    STYLE
                    ----------------------------------------------------
                */

                --type-style-normal: normal;
                --type-style-oblique: oblique;
                --type-style-italic: italic;
                
                /*
                    ----------------------------------------------------
                    SIZE & LINE-HEIGHT
                    ----------------------------------------------------
                */

                --type-size: 3.738vw;
                --type-line-height: 1.5;
                
                --type-size-h1: calc(12.75vw + 1px);
                --type-size-h1-small: calc(5.15vw + 1px);
                --type-line-height-h1-small: 1.25;
                --type-size-h1-small-lower: calc(5.15vw + 1px);
                --type-line-height-h1-small-lower: 1.25;
                --type-line-height-h1: .7365;
                --type-size-h1-margin: 0;

                --type-size-hp: calc(4.85vw + 1px);
                --type-line-height-hp: .7365;

                --type-size-h1-alt: calc(12.85vw + 1px);
                --type-size-line-height-h1-alt: .275;
                --type-size-h1-alt-margin: 16vw 0 0;
                --type-size-h1-alt-padding: 0;

                --type-size-h1-small-alt: calc(3.25vw + 1px);
                --type-size-h1-small-line-height: .275;
                --type-size-h1-small-alt-margin: 16vw 0 0;
                --type-size-h1-small-alt-padding: 0;

                --type-size-h1-alt-divider-width: 3vw;
                --type-size-h1-alt-divider-height: .35vw;
                --type-size-h1-alt-divider-margin: 6.75vw 0 0;

                --type-size-hp-alt: calc(4.85vw + 1px);
                --type-weight-hp-alt: var(--type-weight-medium);
                --type-line-height-hp-alt: 1.15;
                --type-size-hp-alt-margin: 4vw 0 0;
                --type-size-hp-alt-padding: 0;

                
                --type-size-h2: calc(9.45vw + 1px);
                --type-line-height-h2: 1.15;

                --type-size-h3: calc(7.243vw + 1px);
                --type-line-height-h3: 1.15;

                --type-size-h4: calc(6.075vw + 1px);
                --type-line-height-h4: 1.15;

                --type-size-h5: calc(5.75vw + 1px);
                --type-line-height-h5: 1;

                --type-size-h6: calc(5vw + 1px);
                --type-line-height-h6: 1;

                /*
                    ----------------------------------------------------
                    GAP
                    ----------------------------------------------------
                */

                --type-column-gap: 4vw;

                /*
                    ----------------------------------------------------
                    Colors
                    ----------------------------------------------------
                */

                --color-white: #FFF;
                --color-black: #000;

                --color-blue-dark: #02395B;
                --color-blue-light: #4BBEEC;

                /* --color-gray-bright: #E4E4E4; */
                --color-gray-bright: #F6F6F7;
                --color-gray-light: #BCBCBC;
                --color-gray-medium: #8D8D8D;
                --color-gray-dark: #747474;
                --color-gray-cool-dark: #5D6772;

                --color-green: #7AC64E;
                --color-orange: #FF9F31;

                /*
                    ----------------------------------------------------
                    SPACING
                    ----------------------------------------------------
                */

                --spacing-base: 2vw; /* var(--spacing-8--lg); */

            }

            @media only screen and (min-width: 768px)
            {

                :root
                {

                    /*
                        ----------------------------------------------------
                        SIZE & LINE-HEIGHT
                        ----------------------------------------------------
                    */
                    
                    --type-size: 1.667vw;
                    --type-line-height: 1.35;

                    --type-size--lg: 2.367vw;
                    --type-line-height--lg: 3.75vw;


                    --type-size-h1: calc(12.75vw + 1px);
                    --type-line-height-h1: .7365;
                    --type-size-h1-margin: 0;

                    --type-size-h1-small: calc(5.15vw + 1px);
                    --type-line-height-h1-small: 1.2;

                    --type-size-hp: calc(5.5vw + 1px);
                    --type-line-height-hp: .7365;

                    --type-size-h1-alt: calc(6.85vw + 1px);
                    --type-size-line-height-h1-alt: .275;
                    --type-size-h1-alt-margin: 16vw 0 0;
                    --type-size-h1-alt-padding: 0;

                    --type-size-h1-small-alt: calc(3.25vw + 1px);
                    --type-size-h1-small-line-height: .275;
                    --type-size-h1-small-alt-margin: 16vw 0 0;
                    --type-size-h1-small-alt-padding: 0;

                    --type-size-h1-alt-divider-width: 3vw;
                    --type-size-h1-alt-divider-height: .175vw;
                    --type-size-h1-alt-divider-margin: 3.75vw auto 0;

                    --type-size-hp-alt: calc(2.85vw + 1px);
                    --type-weight-hp-alt: var(--type-weight-medium);
                    --type-line-height-hp-alt: 1;
                    --type-size-hp-alt-margin: 2.75vw 0 0;
                    --type-size-hp-alt-padding: 0 var(--spacing-4x);


                    --type-size-h2: calc(4.271vw + 1px);
                    --type-line-height-h2: 1.375;


                    --type-size-h3: calc(2.646vw + 1px);
                    --type-line-height-h3: 1.175;


                    --type-size-h4: calc(2.046vw + 1px);
                    --type-line-height-h4: 1.175;

                    --type-size-h5: calc(1.65vw + 1px);
                    --type-line-height-h5: 1;

                    --type-size-h6: calc(1.35vw + 1px);
                    --type-line-height-h6: 1;


                    /*
                        ----------------------------------------------------
                        GAP
                        ----------------------------------------------------
                    */

                    --type-column-gap: 4vw;

                    /*
                        ----------------------------------------------------
                        SPACING
                        ----------------------------------------------------
                    */
                    
                    --spacing-base: 2vw; /* var(--spacing-8--lg); */
                }
            }

            :root
            {
                --spacing-0x: 0vw;
                --spacing-1x: calc(var(--spacing-base) + 1px);
                --spacing-2x: calc(calc(var(--spacing-base) * 2) + 1px);
                --spacing-3x: calc(calc(var(--spacing-base) * 3) + 1px);
                --spacing-4x: calc(calc(var(--spacing-base) * 4) + 1px);
                --spacing-5x: calc(calc(var(--spacing-base) * 5) + 1px);
                --spacing-6x: calc(calc(var(--spacing-base) * 6) + 1px);
                --spacing-7x: calc(calc(var(--spacing-base) * 7) + 1px);
                --spacing-8x: calc(calc(var(--spacing-base) * 8) + 1px);
                --spacing-9x: calc(calc(var(--spacing-base) * 9) + 1px);
                --spacing-10x: calc(calc(var(--spacing-base) * 10) + 1px);
                --spacing-11x: calc(calc(var(--spacing-base) * 11) + 1px);
                --spacing-12x: calc(calc(var(--spacing-base) * 12) + 1px);
                --spacing-13x: calc(calc(var(--spacing-base) * 13) + 1px);
                --spacing-14x: calc(calc(var(--spacing-base) * 14) + 1px);
                --spacing-15x: calc(calc(var(--spacing-base) * 15) + 1px);
                --spacing-16x: calc(calc(var(--spacing-base) * 16) + 1px);
                --spacing-17x: calc(calc(var(--spacing-base) * 17) + 1px);
                --spacing-18x: calc(calc(var(--spacing-base) * 18) + 1px);
                --spacing-19x: calc(calc(var(--spacing-base) * 19) + 1px);
                --spacing-20x: calc(calc(var(--spacing-base) * 20) + 1px);
                --spacing-21x: calc(calc(var(--spacing-base) * 21) + 1px);
                --spacing-22x: calc(calc(var(--spacing-base) * 22) + 1px);
                --spacing-23x: calc(calc(var(--spacing-base) * 23) + 1px);
                --spacing-24x: calc(calc(var(--spacing-base) * 24) + 1px);
            }
          mode: css
        type: item
        enabled: true
      -
        uid: font
        path: /src/lib/css
        name: font
        ext: css
        content:
          code: |-
            /* ADOBE FONTS LOADED IN PRE-FETCH */
            @font-face{
              font-family:"Gotham-Book";
              src:url("../fonts/Gotham-Book.otf") format("opentype")
            }
            @font-face{
              font-family:"Gotham-Light";
              src:url("../fonts/Gotham-Light.otf") format("opentype")
            }
            @font-face{
              font-family:"Gotham-Medium";
              src:url("../fonts/Gotham-Medium.otf") format("opentype")
            }
            @font-face{
              font-family:"Gotham-Medium-Italic";
              src:url("../fonts/Gotham-MediumItalic.otf") format("opentype")
            }



            /* GOOGLE FONTS */
            /* cyrillic-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51TjASc3CsTYl4BOQ3o.woff2) format('woff2');
              unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
            }
            /* cyrillic */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51TjASc-CsTYl4BOQ3o.woff2) format('woff2');
              unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* greek-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51TjASc2CsTYl4BOQ3o.woff2) format('woff2');
              unicode-range: U+1F00-1FFF;
            }
            /* greek */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51TjASc5CsTYl4BOQ3o.woff2) format('woff2');
              unicode-range: U+0370-03FF;
            }
            /* vietnamese */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51TjASc1CsTYl4BOQ3o.woff2) format('woff2');
              unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
            }
            /* latin-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51TjASc0CsTYl4BOQ3o.woff2) format('woff2');
              unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51TjASc6CsTYl4BO.woff2) format('woff2');
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51S7ACc3CsTYl4BOQ3o.woff2) format('woff2');
              unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
            }
            /* cyrillic */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51S7ACc-CsTYl4BOQ3o.woff2) format('woff2');
              unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* greek-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51S7ACc2CsTYl4BOQ3o.woff2) format('woff2');
              unicode-range: U+1F00-1FFF;
            }
            /* greek */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51S7ACc5CsTYl4BOQ3o.woff2) format('woff2');
              unicode-range: U+0370-03FF;
            }
            /* vietnamese */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51S7ACc1CsTYl4BOQ3o.woff2) format('woff2');
              unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
            }
            /* latin-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51S7ACc0CsTYl4BOQ3o.woff2) format('woff2');
              unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
              font-family: 'Roboto';
              font-style: italic;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOjCnqEu92Fr1Mu51S7ACc6CsTYl4BO.woff2) format('woff2');
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmSU5fCRc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
            }
            /* cyrillic */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmSU5fABc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* greek-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmSU5fCBc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+1F00-1FFF;
            }
            /* greek */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmSU5fBxc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0370-03FF;
            }
            /* vietnamese */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmSU5fCxc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
            }
            /* latin-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmSU5fChc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 300;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmSU5fBBc4AMP6lQ.woff2) format('woff2');
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 400;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOmCnqEu92Fr1Mu72xKKTU1Kvnz.woff2) format('woff2');
              unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
            }
            /* cyrillic */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 400;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOmCnqEu92Fr1Mu5mxKKTU1Kvnz.woff2) format('woff2');
              unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* greek-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 400;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOmCnqEu92Fr1Mu7mxKKTU1Kvnz.woff2) format('woff2');
              unicode-range: U+1F00-1FFF;
            }
            /* greek */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 400;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOmCnqEu92Fr1Mu4WxKKTU1Kvnz.woff2) format('woff2');
              unicode-range: U+0370-03FF;
            }
            /* vietnamese */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 400;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOmCnqEu92Fr1Mu7WxKKTU1Kvnz.woff2) format('woff2');
              unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
            }
            /* latin-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 400;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOmCnqEu92Fr1Mu7GxKKTU1Kvnz.woff2) format('woff2');
              unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 400;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOmCnqEu92Fr1Mu4mxKKTU1Kg.woff2) format('woff2');
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmEU9fCRc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
            }
            /* cyrillic */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmEU9fABc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* greek-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmEU9fCBc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+1F00-1FFF;
            }
            /* greek */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmEU9fBxc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0370-03FF;
            }
            /* vietnamese */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmEU9fCxc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
            }
            /* latin-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmEU9fChc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 500;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmEU9fBBc4AMP6lQ.woff2) format('woff2');
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* cyrillic-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 700;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmWUlfCRc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
            }
            /* cyrillic */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 700;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmWUlfABc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }
            /* greek-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 700;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmWUlfCBc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+1F00-1FFF;
            }
            /* greek */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 700;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmWUlfBxc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0370-03FF;
            }
            /* vietnamese */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 700;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmWUlfCxc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
            }
            /* latin-ext */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 700;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmWUlfChc4AMP6lbBP.woff2) format('woff2');
              unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
              font-family: 'Roboto';
              font-style: normal;
              font-weight: 700;
              src: url(https://fonts.gstatic.com/s/roboto/v29/KFOlCnqEu92Fr1MmWUlfBBc4AMP6lQ.woff2) format('woff2');
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
          mode: css
        type: item
        enabled: true
      -
        uid: reset
        path: /src/lib/css
        name: reset
        ext: css
        content:
          code: |-
            /* PX to VW: https://web-development.space/tools/px-to-vw/ */

            /* Box sizing rules */
            *,
            *::before,
            *::after
            {
              box-sizing: border-box;
            }

            /* Remove default border, margin, padding */
            *
            {
              border: 0;
              margin: 0;
              padding: 0;
            }

            /* Remove list styles on ul, ol elements with a class attribute */
            ul, ol { list-style: none; }

            /* A elements that don't have a class get default styles */
            a:not([class]) { text-decoration-skip-ink: auto; }  
            a { text-decoration: none; }

            /* Make images easier to work with */
            img { max-width: 100%; width: 100%; height: auto; }

            /* Get rid of extra spacing */
            picture { display: flex; width: 100%; height: auto; }
            picture img { width: 100%; height: auto; }

            .picture-object-fit-cover { display: flex; width: 100%; height: 100%; }
            .picture-object-fit-cover img,
            img.img-object-fit-cover { width: 100%; height: 100%; object-fit: cover; object-position: center; }

            /* Inherit fonts for inputs and buttons */
            a, span, input, button, textarea, select { font: inherit; }

            /* Remove all animations and transitions for people that prefer not to see them */
            @media (prefers-reduced-motion: reduce)
            {
              * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
              }
            }

            /* Set core body defaults */
            body
            {
              scroll-behavior: smooth;
              text-rendering: optimizeSpeed;
            }
          mode: css
        type: item
        enabled: true
      -
        uid: typography
        path: /src/lib/css
        name: typography
        ext: css
        content:
          code: |-
            /* 
                -------------------------------------------------
                ELEMENTS: BASE
                -------------------------------------------------
            */

            body { font-size: var(--type-size); font-weight: var(--type-weight-light); line-height: var(--type-line-height); } 

            /*
                -------------------------------------------------
                ELEMENTS: H SIZES:
                -------------------------------------------------
            */

            .h1, .h2, .h3, .h4, .h5, .h6 { font-family: var(--type-family-header);}

            .h1 { font-size: var(--type-size-h1); line-height: var(--type-line-height-h1); font-weight: var(--type-weight-bold); text-transform: uppercase; }
            .h1-alt { font-size: var(--type-size-h1-alt); line-height: var(--type-line-height-h1-alt); font-weight: var(--type-weight-bold); text-transform: uppercase; }

            .h2 { font-size: var(--type-size-h2); line-height: var(--type-line-height-h2); font-weight: var(--type-weight-bold); text-transform: uppercase; }

            .h3 { font-size: var(--type-size-h3); line-height: var(--type-line-height-h3); font-weight: var(--type-weight-medium); text-transform: uppercase; }

            .h4 { font-size: var(--type-size-h4); line-height: var(--type-line-height-h4); font-weight: var(--type-weight-medium); text-transform: uppercase; }

            .h5 { font-size: var(--type-size-h5); line-height: var(--type-line-height-h5); font-weight: var(--type-weight-medium); text-transform: uppercase; }

            .h6 { font-size: var(--type-size-h6); line-height: var(--type-line-height-h6); font-weight: var(--type-weight-medium); text-transform: uppercase; }

            /*
                -------------------------------------------------
                ELEMENT: LINK
                -------------------------------------------------
            */

            a, a:hover, a:focus, a:visited { color: var(--color-blue-light); }

            /*
                -------------------------------------------------
                ELEMENT: STRONG
                -------------------------------------------------
            */

            strong { font-weight: var(--type-weight-medium); }

            /*
                -------------------------------------------------
                ELEMENT: LIST
                -------------------------------------------------
            */

            .li:before { background: url('') no-repeat 0 0; background-position: center center; background-size: 100% auto; content: ''; position: absolute; }

            /*
                ----------------------------------------------------
                ELEMENT: BREAKS
                ----------------------------------------------------
            */
             
            .br--sm,.br--lg { display: none; }

            @media only screen and (min-width: 0px) and (max-width: 767px)
            {
                .br--sm { display: block; }
            }

            @media only screen and (min-width: 768px) and (min-width: 768px)
            {
                .br--lg { display: block; }
            }

            /*
                ----------------------------------------------------
                    ALIGNMENT
                ----------------------------------------------------
            */

            .text-align-start { text-align: start; }
            .text-align-center { text-align: center; }
            .text-align-end { text-align: end; }

            @media only screen and (max-width: 767px)
            {
                .text-align-start--sm { text-align: start; }
                .text-align-center--sm { text-align: center; }
                .text-align-end--sm { text-align: end; }
            }

            @media only screen and (min-width: 768px)
            {
                .text-align-start--lg { text-align: start; }
                .text-align-center--lg { text-align: center; }
                .text-align-end--lg { text-align: end; }
            }



            /*
                ----------------------------------------------------
                SPACING
                ----------------------------------------------------
            */

            .typeset > *:first-child { margin-top: 0; }
            .typeset > *:last-child { margin-bottom: 0; }

            .typeset-2 { columns: 2; column-gap: var(--type-column-gap); orphans: 3; }
            .typeset-3 { columns: 3; column-gap: var(--type-column-gap); orphans: 3; }
            .typeset-4 { columns: 4; column-gap: var(--type-column-gap); orphans: 3; }


            /*
                Mobile
            */
            @media only screen and (max-width: 767px)
            {

                .typeset-2--sm { columns: 2; column-gap: var(--type-column-gap); }
                .typeset-3--sm { columns: 3; column-gap: var(--type-column-gap); }
                .typeset-4--sm { columns: 4; column-gap: var(--type-column-gap); }

                /* Base: Content Block spacing */
                .h1 + :is(h2,h3,h4,h5,h6,.h3,.h4,.h5,.h6,.leader,address,blockquote,dd,dl,dt,fieldset,figcaption,figure,footer,form,header,hr,ol,p,pre,table,tfoot,ul,li)
                {
                    margin-top: 4.15vw;
                }

                .h2 + :is(h2,h3,h4,h5,h6,.h3,.h4,.h5,.h6,.leader,address,blockquote,dd,dl,dt,fieldset,figcaption,figure,footer,form,header,hr,ol,p,pre,table,tfoot,ul,li)
                {
                    margin-top: 3.15vw;
                }

                :is(h2,h3,h4,h5,h6,.h3,.h4,.h5,.h6,.leader,address,blockquote,dd,dl,dt,fieldset,figcaption,figure,footer,form,header,hr,ol,p,pre,table,tfoot,ul,li)
                +
                :is(h2,h3,h4,h5,h6,.h3,.h4,.h5,.h6,.leader,address,blockquote,dd,dl,dt,fieldset,figcaption,figure,footer,form,header,hr,ol,p,pre,table,tfoot,ul,li),
                .p
                {
                    margin-top: 2.75vw;
                }

                .li { display: inline-block; margin-left: 6.346vw; }

                .li:before { width: 4vw; height: 4vw; top: 1vw; left: -6.346vw; }
            }

            @media only screen and (min-width: 768px)
            {

                .typeset-2--lg { columns: 2; column-gap: var(--type-column-gap); }
                .typeset-3--lg { columns: 3; column-gap: var(--type-column-gap); }
                .typeset-4--lg { columns: 4; column-gap: var(--type-column-gap); }

                /* Base: Content Block spacing */
                .h1 + :is(h2,h3,h4,h5,h6,.h2, .h3,.h4,.h5,.h6,.leader,address,blockquote,dd,dl,dt,fieldset,figcaption,figure,footer,form,header,hr,ol,p,pre,table,tfoot,ul,li)
                {
                    margin-top: 2.15vw;
                }

                .h2 + :is(h2,h3,h4,h5,h6,.h2,.h3,.h4,.h5,.h6,.leader,address,blockquote,dd,dl,dt,fieldset,figcaption,figure,footer,form,header,hr,ol,p,pre,table,tfoot,ul,li)
                {
                    margin-top: 1.75vw;
                }

                :is(h2,h3,h4,h5,h6,.h2,.h3,.h4,.h5,.h6,.leader,address,blockquote,dd,dl,dt,fieldset,figcaption,figure,footer,form,header,hr,ol,p,pre,table,tfoot,ul,li)
                +
                :is(h2,h3,h4,h5,h6,.h2,.h3,.h4,.h5,.h6,.leader,address,blockquote,dd,dl,dt,fieldset,figcaption,figure,footer,form,header,hr,ol,p,pre,table,tfoot,ul,li),
                .p
                {
                    margin-top: 1.346vw;
                }

                .li { display: inline-block; margin-left: 3.646vw; }

                .li:before { width: 2vw; height: 2vw; top: 0vw; left: -2.846vw; }
            }
          mode: css
        type: item
        enabled: true
      -
        uid: typography-override
        path: /src/lib/css
        name: typography-override
        ext: css
        content:
          code: |-
            :is(h2,h3,h4,h5,h6.leader,address,blockquote,dd,dl,dt,fieldset,figcaption,figure,footer,form,header,hr,ol,p,pre,table,tfoot,ul,li)
            +
            :is(h2,h3,h4,h5,h6,.leader,address,blockquote,dd,dl,dt,fieldset,figcaption,figure,footer,form,header,hr,ol,p,pre,table,tfoot,ul,li)
            {
                margin-top: 3.75vw;
            }
          mode: css
        type: item
        enabled: true
      -
        uid: block
        path: /src/lib/css
        name: block
        ext: css
        content:
          code: |-
            /*
                ----------------------------------------------------
                Table of Contents:
                ----------------------------------------------------
                    - POSITION:
                    - Z-INSET:
                    - Z-INDEX
                    - WIDTH: %
                    - WIDTH: VW
                    - SPACING: PADDING & MARGIN
            */


            /*
                ----------------------------------------------------
                POSITION:
                ----------------------------------------------------
            */

            * { position: relative; } 

            .position-absolute { position: absolute; }
            .position-relative { position: relative; }
            .position-sticky { position: sticky; }
            .position-fixed { position: fixed; }
            .position-initial { position: initial; }
            .position-inherit { position: inherit; }

            /*
                ----------------------------------------------------
                Z-INSET:
                ----------------------------------------------------
            */

            .z-inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
            .z-inset-x-0 { right: 0; left: 0; }
            .z-inset-y-0 { right: 0; left: 0; }

            .z-top-0 { top: 0; }
            .z-right-0 { right: 0; }
            .z-bottom-0 { right: 0; }
            .z-left-0 { right: 0; }

            /*
                ----------------------------------------------------
                Z-INDEX:
                ----------------------------------------------------
            */

            .z-1 { z-index: 1; }
            .z-2 { z-index: 2; }
            .z-3 { z-index: 3; }
            .z-4 { z-index: 4; }
            .z-5 { z-index: 5; }
            .z-6 { z-index: 6; }
            .z-7 { z-index: 7; }
            .z-8 { z-index: 8; }
            .z-9 { z-index: 9; }
            .z-10 { z-index: 10; }
            .z-20 { z-index: 20; }
            .z-30 { z-index: 30; }
            .z-40 { z-index: 40; }
            .z-50 { z-index: 50; }
            .z-60 { z-index: 60; }
            .z-70 { z-index: 70; }
            .z-80 { z-index: 80; }
            .z-90 { z-index: 90; }
            .z-100 { z-index: 100; }
            .z-200 { z-index: 200; }
            .z-300 { z-index: 300; }
            .z-400 { z-index: 400; }
            .z-500 { z-index: 500; }
            .z-1000 { z-index: 1000; }
            .z-2000 { z-index: 2000; }
            .z-3000 { z-index: 3000; }
            .z-4000 { z-index: 4000; }
            .z-5000 { z-index: 5000; }

            /*
                ----------------------------------------------------
                WIDTH: %
                ----------------------------------------------------
            */

            .w-0 { width: 0; }
            .w-25 { width: 25%; }
            .w-33 { width: 33.333%; }
            .w-50 { width: 50%; }
            .w-66 { width: 66.666%; }
            .w-75 { width: 75%; }
            .w-100 { width: 100%; }

            @media only screen and (max-width: 767px) 
            { 
                .w-0--sm { width: 0; }
                .w-25--sm { width: 25%; }
                .w-33--sm { width: 33.333%; }
                .w-50--sm { width: 50%; }
                .w-66--sm { width: 66.666%; }
                .w-75--sm { width: 75%; }
                .w-100--sm { width: 100%; }
            }

            @media only screen and (min-width: 768px) 
            { 
                .w-0--lg { width: 0; }
                .w-25--lg { width: 25%; }
                .w-33--lg { width: 33.333%; }
                .w-50--lg { width: 50%; }
                .w-66--lg { width: 66.666%; }
                .w-75--lg { width: 75%; }
                .w-100--lg { width: 100%; }
            }
            /*
                ----------------------------------------------------
                WIDTH: VW
                ----------------------------------------------------
            */

            .vw-0 { width: 0; }
            .vw-25 { width: 25vw; }
            .vw-33 { width: 33.333vw; }
            .vw-50 { width: 50vw; }
            .vw-66 { width: 66.666vw; }
            .vw-75 { width: 75vw; }
            .vw-100 { width: 100vw; }


            .vh-100 { height: 100vh; }

            /*
                ----------------------------------------------------
                DISPLAY:
                ----------------------------------------------------
            */

            .display-none { display: none; }
            .display-inline-block { display: inline-block; }
            .display-block { display: block; }

            @media only screen and (max-width: 767px) 
            { 
                .display-none--sm { display: none; }
                .display-inline-block--sm { display: inline-block; }
                .display-block--sm { display: block; }
            }


            @media only screen and (min-width: 768px)
            { 
                .display-none--lg { display: none; }
                .display-inline-block--lg { display: inline-block; }
                .display-block--lg { display: block; } 
            }

            /*
                ----------------------------------------------------
                SPACING
                ----------------------------------------------------
            */


            .padding { padding: var(--spacing); }
            .padding-0 { padding: var(--spacing-0x); }
            .padding-2 { padding: var(--spacing-2x); }
            .padding-3 { padding: var(--spacing-3x); }
            .padding-4 { padding: var(--spacing-4x); }
            .padding-5 { padding: var(--spacing-5x); }
            .padding-6 { padding: var(--spacing-6x); }
            .padding-7 { padding: var(--spacing-7x); }
            .padding-8 { padding: var(--spacing-8x); }
            .padding-9 { padding: var(--spacing-9x); }
            .padding-10 { padding: var(--spacing-10x); }
            .padding-11 { padding: var(--spacing-11x); }
            .padding-12 { padding: var(--spacing-12x); }
            .padding-13 { padding: var(--spacing-13x); }
            .padding-14 { padding: var(--spacing-14x); }
            .padding-15 { padding: var(--spacing-15x); }
            .padding-16 { padding: var(--spacing-16x); }
            .padding-17 { padding: var(--spacing-17x); }
            .padding-18 { padding: var(--spacing-18x); }
            .padding-19 { padding: var(--spacing-19x); }
            .padding-20 { padding: var(--spacing-20x); }
            .padding-21 { padding: var(--spacing-21x); }
            .padding-22 { padding: var(--spacing-22x); }
            .padding-23 { padding: var(--spacing-23x); }
            .padding-24 { padding: var(--spacing-24x); }

            .padding-y-0 { padding-top: var(--spacing-0x); padding-bottom: var(--spacing-0x); }
            .padding-y-1 { padding-top: var(--spacing-1x); padding-bottom: var(--spacing-1x); }
            .padding-y-2 { padding-top: var(--spacing-2x); padding-bottom: var(--spacing-2x); }
            .padding-y-3 { padding-top: var(--spacing-3x); padding-bottom: var(--spacing-3x); }
            .padding-y-4 { padding-top: var(--spacing-4x); padding-bottom: var(--spacing-4x); }
            .padding-y-5 { padding-top: var(--spacing-5x); padding-bottom: var(--spacing-5x); }
            .padding-y-6 { padding-top: var(--spacing-6x); padding-bottom: var(--spacing-6x); }
            .padding-y-7 { padding-top: var(--spacing-7x); padding-bottom: var(--spacing-7x); }
            .padding-y-8 { padding-top: var(--spacing-8x); padding-bottom: var(--spacing-8x); }
            .padding-y-9 { padding-top: var(--spacing-9x); padding-bottom: var(--spacing-9x); }
            .padding-y-10 { padding-top: var(--spacing-10x); padding-bottom: var(--spacing-10x); }
            .padding-y-11 { padding-top: var(--spacing-11x); padding-bottom: var(--spacing-11x); }
            .padding-y-12 { padding-top: var(--spacing-12x); padding-bottom: var(--spacing-12x); }
            .padding-y-13 { padding-top: var(--spacing-13x); padding-bottom: var(--spacing-13x); }
            .padding-y-14 { padding-top: var(--spacing-14x); padding-bottom: var(--spacing-14x); }
            .padding-y-15 { padding-top: var(--spacing-15x); padding-bottom: var(--spacing-15x); }
            .padding-y-16 { padding-top: var(--spacing-16x); padding-bottom: var(--spacing-16x); }
            .padding-y-17 { padding-top: var(--spacing-17x); padding-bottom: var(--spacing-17x); }
            .padding-y-17 { padding-top: var(--spacing-17x); padding-bottom: var(--spacing-17x); }
            .padding-y-18 { padding-top: var(--spacing-18x); padding-bottom: var(--spacing-18x); }
            .padding-y-19 { padding-top: var(--spacing-19x); padding-bottom: var(--spacing-19x); }
            .padding-y-20 { padding-top: var(--spacing-20x); padding-bottom: var(--spacing-20x); }
            .padding-y-21 { padding-top: var(--spacing-21x); padding-bottom: var(--spacing-21x); }
            .padding-y-22 { padding-top: var(--spacing-22x); padding-bottom: var(--spacing-22x); }
            .padding-y-23 { padding-top: var(--spacing-23x); padding-bottom: var(--spacing-23x); }
            .padding-y-24 { padding-top: var(--spacing-24x); padding-bottom: var(--spacing-24x); }

            .padding-x-0 { padding-left: var(--spacing-0x); padding-right: var(--spacing-0x); }
            .padding-x-1 { padding-left: var(--spacing-1x); padding-right: var(--spacing-1x); }
            .padding-x-2 { padding-left: var(--spacing-2x); padding-right: var(--spacing-2x); }
            .padding-x-3 { padding-left: var(--spacing-3x); padding-right: var(--spacing-3x); }
            .padding-x-4 { padding-left: var(--spacing-4x); padding-right: var(--spacing-4x); }
            .padding-x-5 { padding-left: var(--spacing-5x); padding-right: var(--spacing-5x); }
            .padding-x-6 { padding-left: var(--spacing-6x); padding-right: var(--spacing-6x); }
            .padding-x-7 { padding-left: var(--spacing-7x); padding-right: var(--spacing-7x); }
            .padding-x-8 { padding-left: var(--spacing-8x); padding-right: var(--spacing-8x); }
            .padding-x-9 { padding-left: var(--spacing-9x); padding-right: var(--spacing-9x); }
            .padding-x-10 { padding-left: var(--spacing-10x); padding-right: var(--spacing-10x); }
            .padding-x-11 { padding-left: var(--spacing-11x); padding-right: var(--spacing-11x); }
            .padding-x-12 { padding-left: var(--spacing-12x); padding-right: var(--spacing-12x); }
            .padding-x-13 { padding-left: var(--spacing-13x); padding-right: var(--spacing-13x); }
            .padding-x-14 { padding-left: var(--spacing-14x); padding-right: var(--spacing-14x); }
            .padding-x-15 { padding-left: var(--spacing-15x); padding-right: var(--spacing-15x); }
            .padding-x-16 { padding-left: var(--spacing-16x); padding-right: var(--spacing-16x); }
            .padding-x-17 { padding-left: var(--spacing-17x); padding-right: var(--spacing-17x); }
            .padding-x-17 { padding-left: var(--spacing-17x); padding-right: var(--spacing-17x); }
            .padding-x-18 { padding-left: var(--spacing-18x); padding-right: var(--spacing-18x); }
            .padding-x-19 { padding-left: var(--spacing-19x); padding-right: var(--spacing-19x); }
            .padding-x-20 { padding-left: var(--spacing-20x); padding-right: var(--spacing-20x); }
            .padding-x-21 { padding-left: var(--spacing-21x); padding-right: var(--spacing-21x); }
            .padding-x-22 { padding-left: var(--spacing-22x); padding-right: var(--spacing-22x); }
            .padding-x-23 { padding-left: var(--spacing-23x); padding-right: var(--spacing-23x); }
            .padding-x-24 { padding-left: var(--spacing-24x); padding-right: var(--spacing-24x); }

            .padding-left-0 { padding-left: var(--spacing-0x); }
            .padding-left-1 { padding-left: var(--spacing-1x); }
            .padding-left-2 { padding-left: var(--spacing-2x); }
            .padding-left-3 { padding-left: var(--spacing-3x); }
            .padding-left-4 { padding-left: var(--spacing-4x); }
            .padding-left-5 { padding-left: var(--spacing-5x); }
            .padding-left-6 { padding-left: var(--spacing-6x); }
            .padding-left-7 { padding-left: var(--spacing-7x); }
            .padding-left-8 { padding-left: var(--spacing-8x); }
            .padding-left-9 { padding-left: var(--spacing-9x); }
            .padding-left-10 { padding-left: var(--spacing-10x); }
            .padding-left-11 { padding-left: var(--spacing-11x); }
            .padding-left-12 { padding-left: var(--spacing-12x); }
            .padding-left-13 { padding-left: var(--spacing-13x); }
            .padding-left-14 { padding-left: var(--spacing-14x); }
            .padding-left-15 { padding-left: var(--spacing-15x); }
            .padding-left-16 { padding-left: var(--spacing-16x); }
            .padding-left-17 { padding-left: var(--spacing-17x); }
            .padding-left-18 { padding-left: var(--spacing-18x); }
            .padding-left-19 { padding-left: var(--spacing-19x); }
            .padding-left-20 { padding-left: var(--spacing-20x); }
            .padding-left-21 { padding-left: var(--spacing-21x); }
            .padding-left-22 { padding-left: var(--spacing-22x); }
            .padding-left-23 { padding-left: var(--spacing-23x); }
            .padding-left-24 { padding-left: var(--spacing-24x); }

            .padding-right-0 { padding-right: var(--spacing-0x); }
            .padding-right-1 { padding-right: var(--spacing-1x); }
            .padding-right-2 { padding-right: var(--spacing-2x); }
            .padding-right-3 { padding-right: var(--spacing-3x); }
            .padding-right-4 { padding-right: var(--spacing-4x); }
            .padding-right-5 { padding-right: var(--spacing-5x); }
            .padding-right-6 { padding-right: var(--spacing-6x); }
            .padding-right-7 { padding-right: var(--spacing-7x); }
            .padding-right-8 { padding-right: var(--spacing-8x); }
            .padding-right-9 { padding-right: var(--spacing-9x); }
            .padding-right-10 { padding-right: var(--spacing-10x); }
            .padding-right-11 { padding-right: var(--spacing-11x); }
            .padding-right-12 { padding-right: var(--spacing-12x); }
            .padding-right-13 { padding-right: var(--spacing-13x); }
            .padding-right-14 { padding-right: var(--spacing-14x); }
            .padding-right-15 { padding-right: var(--spacing-15x); }
            .padding-right-16 { padding-right: var(--spacing-16x); }
            .padding-right-17 { padding-right: var(--spacing-17x); }
            .padding-right-18 { padding-right: var(--spacing-18x); }
            .padding-right-19 { padding-right: var(--spacing-19x); }
            .padding-right-20 { padding-right: var(--spacing-20x); }
            .padding-right-21 { padding-right: var(--spacing-21x); }
            .padding-right-22 { padding-right: var(--spacing-22x); }
            .padding-right-23 { padding-right: var(--spacing-23x); }
            .padding-right-24 { padding-right: var(--spacing-24x); }

            .padding-top-0 { padding-top: var(--spacing-0x); }
            .padding-top-1 { padding-top: var(--spacing-1x); }
            .padding-top-2 { padding-top: var(--spacing-2x); }
            .padding-top-3 { padding-top: var(--spacing-3x); }
            .padding-top-4 { padding-top: var(--spacing-4x); }
            .padding-top-5 { padding-top: var(--spacing-5x); }
            .padding-top-6 { padding-top: var(--spacing-6x); }
            .padding-top-7 { padding-top: var(--spacing-7x); }
            .padding-top-8 { padding-top: var(--spacing-8x); }
            .padding-top-9 { padding-top: var(--spacing-9x); }
            .padding-top-10 { padding-top: var(--spacing-10x); }
            .padding-top-11 { padding-top: var(--spacing-11x); }
            .padding-top-12 { padding-top: var(--spacing-12x); }
            .padding-top-13 { padding-top: var(--spacing-13x); }
            .padding-top-14 { padding-top: var(--spacing-14x); }
            .padding-top-15 { padding-top: var(--spacing-15x); }
            .padding-top-16 { padding-top: var(--spacing-16x); }
            .padding-top-17 { padding-top: var(--spacing-17x); }
            .padding-top-18 { padding-top: var(--spacing-18x); }
            .padding-top-19 { padding-top: var(--spacing-19x); }
            .padding-top-20 { padding-top: var(--spacing-20x); }
            .padding-top-21 { padding-top: var(--spacing-21x); }
            .padding-top-22 { padding-top: var(--spacing-22x); }
            .padding-top-23 { padding-top: var(--spacing-23x); }
            .padding-top-24 { padding-top: var(--spacing-24x); }

            .padding-bottom-0 { padding-bottom: var(--spacing-0x); }
            .padding-bottom-1 { padding-bottom: var(--spacing-1x); }
            .padding-bottom-2 { padding-bottom: var(--spacing-2x); }
            .padding-bottom-3 { padding-bottom: var(--spacing-3x); }
            .padding-bottom-4 { padding-bottom: var(--spacing-4x); }
            .padding-bottom-5 { padding-bottom: var(--spacing-5x); }
            .padding-bottom-6 { padding-bottom: var(--spacing-6x); }
            .padding-bottom-7 { padding-bottom: var(--spacing-7x); }
            .padding-bottom-8 { padding-bottom: var(--spacing-8x); }
            .padding-bottom-9 { padding-bottom: var(--spacing-9x); }
            .padding-bottom-10 { padding-bottom: var(--spacing-10x); }
            .padding-bottom-11 { padding-bottom: var(--spacing-11x); }
            .padding-bottom-12 { padding-bottom: var(--spacing-12x); }
            .padding-bottom-13 { padding-bottom: var(--spacing-13x); }
            .padding-bottom-14 { padding-bottom: var(--spacing-14x); }
            .padding-bottom-15 { padding-bottom: var(--spacing-15x); }
            .padding-bottom-16 { padding-bottom: var(--spacing-16x); }
            .padding-bottom-17 { padding-bottom: var(--spacing-17x); }
            .padding-bottom-18 { padding-bottom: var(--spacing-18x); }
            .padding-bottom-19 { padding-bottom: var(--spacing-19x); }
            .padding-bottom-20 { padding-bottom: var(--spacing-20x); }
            .padding-bottom-21 { padding-bottom: var(--spacing-21x); }
            .padding-bottom-22 { padding-bottom: var(--spacing-22x); }
            .padding-bottom-23 { padding-bottom: var(--spacing-23x); }
            .padding-bottom-24 { padding-bottom: var(--spacing-24x); }

            .padding-y-collapse { padding-left: 0; padding-right: 0; }
            .padding-x-collapse { padding-top: 0; padding-bottom: 0; }


            .margin { margin: var(--spacing); }
            .margin-0 { margin: var(--spacing-0x); }
            .margin-2 { margin: var(--spacing-2x); }
            .margin-3 { margin: var(--spacing-3x); }
            .margin-4 { margin: var(--spacing-4x); }
            .margin-5 { margin: var(--spacing-5x); }
            .margin-6 { margin: var(--spacing-6x); }
            .margin-7 { margin: var(--spacing-7x); }
            .margin-8 { margin: var(--spacing-8x); }
            .margin-9 { margin: var(--spacing-9x); }
            .margin-10 { margin: var(--spacing-10x); }
            .margin-11 { margin: var(--spacing-11x); }
            .margin-12 { margin: var(--spacing-12x); }
            .margin-13 { margin: var(--spacing-13x); }
            .margin-14 { margin: var(--spacing-14x); }
            .margin-15 { margin: var(--spacing-15x); }
            .margin-16 { margin: var(--spacing-16x); }
            .margin-17 { margin: var(--spacing-17x); }
            .margin-18 { margin: var(--spacing-18x); }
            .margin-19 { margin: var(--spacing-19x); }
            .margin-20 { margin: var(--spacing-20x); }
            .margin-21 { margin: var(--spacing-21x); }
            .margin-22 { margin: var(--spacing-22x); }
            .margin-23 { margin: var(--spacing-23x); }
            .margin-24 { margin: var(--spacing-24x); }

            .margin-left-0 { margin-left: var(--spacing-0x); }
            .margin-left-1 { margin-left: var(--spacing-1x); }
            .margin-left-2 { margin-left: var(--spacing-2x); }
            .margin-left-3 { margin-left: var(--spacing-3x); }
            .margin-left-4 { margin-left: var(--spacing-4x); }
            .margin-left-5 { margin-left: var(--spacing-5x); }
            .margin-left-6 { margin-left: var(--spacing-6x); }
            .margin-left-7 { margin-left: var(--spacing-7x); }
            .margin-left-8 { margin-left: var(--spacing-8x); }
            .margin-left-9 { margin-left: var(--spacing-9x); }
            .margin-left-10 { margin-left: var(--spacing-10x); }
            .margin-left-11 { margin-left: var(--spacing-11x); }
            .margin-left-12 { margin-left: var(--spacing-12x); }
            .margin-left-13 { margin-left: var(--spacing-13x); }
            .margin-left-14 { margin-left: var(--spacing-14x); }
            .margin-left-15 { margin-left: var(--spacing-15x); }
            .margin-left-16 { margin-left: var(--spacing-16x); }
            .margin-left-17 { margin-left: var(--spacing-17x); }
            .margin-left-18 { margin-left: var(--spacing-18x); }
            .margin-left-19 { margin-left: var(--spacing-19x); }
            .margin-left-20 { margin-left: var(--spacing-20x); }
            .margin-left-21 { margin-left: var(--spacing-21x); }
            .margin-left-22 { margin-left: var(--spacing-22x); }
            .margin-left-23 { margin-left: var(--spacing-23x); }
            .margin-left-24 { margin-left: var(--spacing-24x); }

            .margin-right-0 { margin-right: var(--spacing-0x); }
            .margin-right-1 { margin-right: var(--spacing-1x); }
            .margin-right-2 { margin-right: var(--spacing-2x); }
            .margin-right-3 { margin-right: var(--spacing-3x); }
            .margin-right-4 { margin-right: var(--spacing-4x); }
            .margin-right-5 { margin-right: var(--spacing-5x); }
            .margin-right-6 { margin-right: var(--spacing-6x); }
            .margin-right-7 { margin-right: var(--spacing-7x); }
            .margin-right-8 { margin-right: var(--spacing-8x); }
            .margin-right-9 { margin-right: var(--spacing-9x); }
            .margin-right-10 { margin-right: var(--spacing-10x); }
            .margin-right-11 { margin-right: var(--spacing-11x); }
            .margin-right-12 { margin-right: var(--spacing-12x); }
            .margin-right-13 { margin-right: var(--spacing-13x); }
            .margin-right-14 { margin-right: var(--spacing-14x); }
            .margin-right-15 { margin-right: var(--spacing-15x); }
            .margin-right-16 { margin-right: var(--spacing-16x); }
            .margin-right-17 { margin-right: var(--spacing-17x); }
            .margin-right-18 { margin-right: var(--spacing-18x); }
            .margin-right-19 { margin-right: var(--spacing-19x); }
            .margin-right-20 { margin-right: var(--spacing-20x); }
            .margin-right-21 { margin-right: var(--spacing-21x); }
            .margin-right-22 { margin-right: var(--spacing-22x); }
            .margin-right-23 { margin-right: var(--spacing-23x); }
            .margin-right-24 { margin-right: var(--spacing-24x); }

            .margin-top-0 { margin-top: var(--spacing-0x); }
            .margin-top-1 { margin-top: var(--spacing-1x); }
            .margin-top-2 { margin-top: var(--spacing-2x); }
            .margin-top-3 { margin-top: var(--spacing-3x); }
            .margin-top-4 { margin-top: var(--spacing-4x); }
            .margin-top-5 { margin-top: var(--spacing-5x); }
            .margin-top-6 { margin-top: var(--spacing-6x); }
            .margin-top-7 { margin-top: var(--spacing-7x); }
            .margin-top-8 { margin-top: var(--spacing-8x); }
            .margin-top-9 { margin-top: var(--spacing-9x); }
            .margin-top-10 { margin-top: var(--spacing-10x); }
            .margin-top-11 { margin-top: var(--spacing-11x); }
            .margin-top-12 { margin-top: var(--spacing-12x); }
            .margin-top-12 { margin-top: var(--spacing-12x); }
            .margin-top-13 { margin-top: var(--spacing-13x); }
            .margin-top-14 { margin-top: var(--spacing-14x); }
            .margin-top-15 { margin-top: var(--spacing-15x); }
            .margin-top-16 { margin-top: var(--spacing-16x); }
            .margin-top-17 { margin-top: var(--spacing-17x); }
            .margin-top-18 { margin-top: var(--spacing-18x); }
            .margin-top-19 { margin-top: var(--spacing-19x); }
            .margin-top-20 { margin-top: var(--spacing-20x); }
            .margin-top-21 { margin-top: var(--spacing-21x); }
            .margin-top-22 { margin-top: var(--spacing-22x); }
            .margin-top-23 { margin-top: var(--spacing-23x); }
            .margin-top-24 { margin-top: var(--spacing-24x); }

            .margin-bottom-0 { margin-bottom: var(--spacing-0x); }
            .margin-bottom-1 { margin-bottom: var(--spacing-1x); }
            .margin-bottom-2 { margin-bottom: var(--spacing-2x); }
            .margin-bottom-3 { margin-bottom: var(--spacing-3x); }
            .margin-bottom-4 { margin-bottom: var(--spacing-4x); }
            .margin-bottom-5 { margin-bottom: var(--spacing-5x); }
            .margin-bottom-6 { margin-bottom: var(--spacing-6x); }
            .margin-bottom-7 { margin-bottom: var(--spacing-7x); }
            .margin-bottom-8 { margin-bottom: var(--spacing-8x); }
            .margin-bottom-9 { margin-bottom: var(--spacing-9x); }
            .margin-bottom-10 { margin-bottom: var(--spacing-10x); }
            .margin-bottom-11 { margin-bottom: var(--spacing-11x); }
            .margin-bottom-12 { margin-bottom: var(--spacing-12x); }
            .margin-bottom-13 { margin-bottom: var(--spacing-13x); }
            .margin-bottom-14 { margin-bottom: var(--spacing-14x); }
            .margin-bottom-15 { margin-bottom: var(--spacing-15x); }
            .margin-bottom-16 { margin-bottom: var(--spacing-16x); }
            .margin-bottom-17 { margin-bottom: var(--spacing-17x); }
            .margin-bottom-18 { margin-bottom: var(--spacing-18x); }
            .margin-bottom-19 { margin-bottom: var(--spacing-19x); }
            .margin-bottom-20 { margin-bottom: var(--spacing-20x); }
            .margin-bottom-21 { margin-bottom: var(--spacing-21x); }
            .margin-bottom-22 { margin-bottom: var(--spacing-22x); }
            .margin-bottom-23 { margin-bottom: var(--spacing-23x); }
            .margin-bottom-24 { margin-bottom: var(--spacing-24x); }


            .margin-y-collapse { margin-left: 0; margin-right: 0; }
            .margin-x-collapse { margin-top: 0; margin-bottom: 0; }


            @media only screen and (max-width:767px) 
            {

                .padding--sm { padding: var(--spacing); }
                .padding-0--sm { padding: var(--spacing-0x); }
                .padding-2--sm { padding: var(--spacing-2x); }
                .padding-3--sm { padding: var(--spacing-3x); }
                .padding-4--sm { padding: var(--spacing-4x); }
                .padding-5--sm { padding: var(--spacing-5x); }
                .padding-6--sm { padding: var(--spacing-6x); }
                .padding-7--sm { padding: var(--spacing-7x); }
                .padding-8--sm { padding: var(--spacing-8x); }
                .padding-9--sm { padding: var(--spacing-9x); }
                .padding-10--sm { padding: var(--spacing-10x); }
                .padding-11--sm { padding: var(--spacing-11x); }
                .padding-12--sm { padding: var(--spacing-12x); }
                .padding-13--sm { padding: var(--spacing-13x); }
                .padding-14--sm { padding: var(--spacing-14x); }
                .padding-15--sm { padding: var(--spacing-15x); }
                .padding-16--sm { padding: var(--spacing-16x); }
                .padding-17--sm { padding: var(--spacing-17x); }
                .padding-18--sm { padding: var(--spacing-18x); }
                .padding-19--sm { padding: var(--spacing-19x); }
                .padding-20--sm { padding: var(--spacing-20x); }
                .padding-21--sm { padding: var(--spacing-21x); }
                .padding-22--sm { padding: var(--spacing-22x); }
                .padding-23--sm { padding: var(--spacing-23x); }
                .padding-24--sm { padding: var(--spacing-24x); }

                .padding-y-0--sm { padding-top: var(--spacing-0x); padding-bottom: var(--spacing-0x); }
                .padding-y-1--sm { padding-top: var(--spacing-1x); padding-bottom: var(--spacing-1x); }
                .padding-y-2--sm { padding-top: var(--spacing-2x); padding-bottom: var(--spacing-2x); }
                .padding-y-3--sm { padding-top: var(--spacing-3x); padding-bottom: var(--spacing-3x); }
                .padding-y-4--sm { padding-top: var(--spacing-4x); padding-bottom: var(--spacing-4x); }
                .padding-y-5--sm { padding-top: var(--spacing-5x); padding-bottom: var(--spacing-5x); }
                .padding-y-6--sm { padding-top: var(--spacing-6x); padding-bottom: var(--spacing-6x); }
                .padding-y-7--sm { padding-top: var(--spacing-7x); padding-bottom: var(--spacing-7x); }
                .padding-y-8--sm { padding-top: var(--spacing-8x); padding-bottom: var(--spacing-8x); }
                .padding-y-9--sm { padding-top: var(--spacing-9x); padding-bottom: var(--spacing-9x); }
                .padding-y-10--sm { padding-top: var(--spacing-10x); padding-bottom: var(--spacing-10x); }
                .padding-y-11--sm { padding-top: var(--spacing-11x); padding-bottom: var(--spacing-11x); }
                .padding-y-12--sm { padding-top: var(--spacing-12x); padding-bottom: var(--spacing-12x); }
                .padding-y-13--sm { padding-top: var(--spacing-13x); padding-bottom: var(--spacing-13x); }
                .padding-y-14--sm { padding-top: var(--spacing-14x); padding-bottom: var(--spacing-14x); }
                .padding-y-15--sm { padding-top: var(--spacing-15x); padding-bottom: var(--spacing-15x); }
                .padding-y-16--sm { padding-top: var(--spacing-16x); padding-bottom: var(--spacing-16x); }
                .padding-y-17--sm { padding-top: var(--spacing-17x); padding-bottom: var(--spacing-17x); }
                .padding-y-18--sm { padding-top: var(--spacing-18x); padding-bottom: var(--spacing-18x); }
                .padding-y-19--sm { padding-top: var(--spacing-19x); padding-bottom: var(--spacing-19x); }
                .padding-y-20--sm { padding-top: var(--spacing-20x); padding-bottom: var(--spacing-20x); }
                .padding-y-21--sm { padding-top: var(--spacing-21x); padding-bottom: var(--spacing-21x); }
                .padding-y-22--sm { padding-top: var(--spacing-22x); padding-bottom: var(--spacing-22x); }
                .padding-y-23--sm { padding-top: var(--spacing-23x); padding-bottom: var(--spacing-23x); }
                .padding-y-24--sm { padding-top: var(--spacing-24x); padding-bottom: var(--spacing-24x); }

                .padding-x-0--sm { padding-left: var(--spacing-0x); padding-right: var(--spacing-0x); }
                .padding-x-1--sm { padding-left: var(--spacing-1x); padding-right: var(--spacing-1x); }
                .padding-x-2--sm { padding-left: var(--spacing-2x); padding-right: var(--spacing-2x); }
                .padding-x-3--sm { padding-left: var(--spacing-3x); padding-right: var(--spacing-3x); }
                .padding-x-4--sm { padding-left: var(--spacing-4x); padding-right: var(--spacing-4x); }
                .padding-x-5--sm { padding-left: var(--spacing-5x); padding-right: var(--spacing-5x); }
                .padding-x-6--sm { padding-left: var(--spacing-6x); padding-right: var(--spacing-6x); }
                .padding-x-7--sm { padding-left: var(--spacing-7x); padding-right: var(--spacing-7x); }
                .padding-x-8--sm { padding-left: var(--spacing-8x); padding-right: var(--spacing-8x); }
                .padding-x-9--sm { padding-left: var(--spacing-9x); padding-right: var(--spacing-9x); }
                .padding-x-10--sm { padding-left: var(--spacing-10x); padding-right: var(--spacing-10x); }
                .padding-x-11--sm { padding-left: var(--spacing-11x); padding-right: var(--spacing-11x); }
                .padding-x-12--sm { padding-left: var(--spacing-12x); padding-right: var(--spacing-12x); }
                .padding-x-13--sm { padding-left: var(--spacing-13x); padding-right: var(--spacing-13x); }
                .padding-x-14--sm { padding-left: var(--spacing-14x); padding-right: var(--spacing-14x); }
                .padding-x-15--sm { padding-left: var(--spacing-15x); padding-right: var(--spacing-15x); }
                .padding-x-16--sm { padding-left: var(--spacing-16x); padding-right: var(--spacing-16x); }
                .padding-x-17--sm { padding-left: var(--spacing-17x); padding-right: var(--spacing-17x); }
                .padding-x-18--sm { padding-left: var(--spacing-18x); padding-right: var(--spacing-18x); }
                .padding-x-19--sm { padding-left: var(--spacing-19x); padding-right: var(--spacing-19x); }
                .padding-x-20--sm { padding-left: var(--spacing-20x); padding-right: var(--spacing-20x); }
                .padding-x-21--sm { padding-left: var(--spacing-21x); padding-right: var(--spacing-21x); }
                .padding-x-22--sm { padding-left: var(--spacing-22x); padding-right: var(--spacing-22x); }
                .padding-x-23--sm { padding-left: var(--spacing-23x); padding-right: var(--spacing-23x); }
                .padding-x-24--sm { padding-left: var(--spacing-24x); padding-right: var(--spacing-24x); }

                .padding-left-0--sm { padding-left: var(--spacing-0x); }
                .padding-left-1--sm { padding-left: var(--spacing-1x); }
                .padding-left-2--sm { padding-left: var(--spacing-2x); }
                .padding-left-3--sm { padding-left: var(--spacing-3x); }
                .padding-left-4--sm { padding-left: var(--spacing-4x); }
                .padding-left-5--sm { padding-left: var(--spacing-5x); }
                .padding-left-6--sm { padding-left: var(--spacing-6x); }
                .padding-left-7--sm { padding-left: var(--spacing-7x); }
                .padding-left-8--sm { padding-left: var(--spacing-8x); }
                .padding-left-9--sm { padding-left: var(--spacing-9x); }
                .padding-left-10--sm { padding-left: var(--spacing-10x); }
                .padding-left-11--sm { padding-left: var(--spacing-11x); }
                .padding-left-12--sm { padding-left: var(--spacing-12x); }
                .padding-left-13--sm { padding-left: var(--spacing-13x); }
                .padding-left-14--sm { padding-left: var(--spacing-14x); }
                .padding-left-15--sm { padding-left: var(--spacing-15x); }
                .padding-left-16--sm { padding-left: var(--spacing-16x); }
                .padding-left-17--sm { padding-left: var(--spacing-17x); }
                .padding-left-18--sm { padding-left: var(--spacing-18x); }
                .padding-left-19--sm { padding-left: var(--spacing-19x); }
                .padding-left-20--sm { padding-left: var(--spacing-20x); }
                .padding-left-21--sm { padding-left: var(--spacing-21x); }
                .padding-left-22--sm { padding-left: var(--spacing-22x); }
                .padding-left-23--sm { padding-left: var(--spacing-23x); }
                .padding-left-24--sm { padding-left: var(--spacing-24x); }

                .padding-right-0--sm { padding-right: var(--spacing-0x); }
                .padding-right-1--sm { padding-right: var(--spacing-1x); }
                .padding-right-2--sm { padding-right: var(--spacing-2x); }
                .padding-right-3--sm { padding-right: var(--spacing-3x); }
                .padding-right-4--sm { padding-right: var(--spacing-4x); }
                .padding-right-5--sm { padding-right: var(--spacing-5x); }
                .padding-right-6--sm { padding-right: var(--spacing-6x); }
                .padding-right-7--sm { padding-right: var(--spacing-7x); }
                .padding-right-8--sm { padding-right: var(--spacing-8x); }
                .padding-right-9--sm { padding-right: var(--spacing-9x); }
                .padding-right-10--sm { padding-right: var(--spacing-10x); }
                .padding-right-11--sm { padding-right: var(--spacing-11x); }
                .padding-right-12--sm { padding-right: var(--spacing-12x); }
                .padding-right-13--sm { padding-right: var(--spacing-13x); }
                .padding-right-14--sm { padding-right: var(--spacing-14x); }
                .padding-right-15--sm { padding-right: var(--spacing-15x); }
                .padding-right-16--sm { padding-right: var(--spacing-16x); }
                .padding-right-17--sm { padding-right: var(--spacing-17x); }
                .padding-right-18--sm { padding-right: var(--spacing-18x); }
                .padding-right-19--sm { padding-right: var(--spacing-19x); }
                .padding-right-20--sm { padding-right: var(--spacing-20x); }
                .padding-right-21--sm { padding-right: var(--spacing-21x); }
                .padding-right-22--sm { padding-right: var(--spacing-22x); }
                .padding-right-23--sm { padding-right: var(--spacing-23x); }
                .padding-right-24--sm { padding-right: var(--spacing-24x); }

                .padding-top-0--sm { padding-top: var(--spacing-0x); }
                .padding-top-1--sm { padding-top: var(--spacing-1x); }
                .padding-top-2--sm { padding-top: var(--spacing-2x); }
                .padding-top-3--sm { padding-top: var(--spacing-3x); }
                .padding-top-4--sm { padding-top: var(--spacing-4x); }
                .padding-top-5--sm { padding-top: var(--spacing-5x); }
                .padding-top-6--sm { padding-top: var(--spacing-6x); }
                .padding-top-7--sm { padding-top: var(--spacing-7x); }
                .padding-top-8--sm { padding-top: var(--spacing-8x); }
                .padding-top-9--sm { padding-top: var(--spacing-9x); }
                .padding-top-10--sm { padding-top: var(--spacing-10x); }
                .padding-top-11--sm { padding-top: var(--spacing-11x); }
                .padding-top-12--sm { padding-top: var(--spacing-12x); }
                .padding-top-13--sm { padding-top: var(--spacing-13x); }
                .padding-top-14--sm { padding-top: var(--spacing-14x); }
                .padding-top-15--sm { padding-top: var(--spacing-15x); }
                .padding-top-16--sm { padding-top: var(--spacing-16x); }
                .padding-top-17--sm { padding-top: var(--spacing-17x); }
                .padding-top-18--sm { padding-top: var(--spacing-18x); }
                .padding-top-19--sm { padding-top: var(--spacing-19x); }
                .padding-top-20--sm { padding-top: var(--spacing-20x); }
                .padding-top-21--sm { padding-top: var(--spacing-21x); }
                .padding-top-22--sm { padding-top: var(--spacing-22x); }
                .padding-top-23--sm { padding-top: var(--spacing-23x); }
                .padding-top-24--sm { padding-top: var(--spacing-24x); }

                .padding-bottom-0--sm { padding-bottom: var(--spacing-0x); }
                .padding-bottom-1--sm { padding-bottom: var(--spacing-1x); }
                .padding-bottom-2--sm { padding-bottom: var(--spacing-2x); }
                .padding-bottom-3--sm { padding-bottom: var(--spacing-3x); }
                .padding-bottom-4--sm { padding-bottom: var(--spacing-4x); }
                .padding-bottom-5--sm { padding-bottom: var(--spacing-5x); }
                .padding-bottom-6--sm { padding-bottom: var(--spacing-6x); }
                .padding-bottom-7--sm { padding-bottom: var(--spacing-7x); }
                .padding-bottom-8--sm { padding-bottom: var(--spacing-8x); }
                .padding-bottom-9--sm { padding-bottom: var(--spacing-9x); }
                .padding-bottom-10--sm { padding-bottom: var(--spacing-10x); }
                .padding-bottom-11--sm { padding-bottom: var(--spacing-11x); }
                .padding-bottom-12--sm { padding-bottom: var(--spacing-12x); }
                .padding-bottom-13--sm { padding-bottom: var(--spacing-13x); }
                .padding-bottom-14--sm { padding-bottom: var(--spacing-14x); }
                .padding-bottom-15--sm { padding-bottom: var(--spacing-15x); }
                .padding-bottom-16--sm { padding-bottom: var(--spacing-16x); }
                .padding-bottom-17--sm { padding-bottom: var(--spacing-17x); }
                .padding-bottom-18--sm { padding-bottom: var(--spacing-18x); }
                .padding-bottom-19--sm { padding-bottom: var(--spacing-19x); }
                .padding-bottom-20--sm { padding-bottom: var(--spacing-20x); }
                .padding-bottom-21--sm { padding-bottom: var(--spacing-21x); }
                .padding-bottom-22--sm { padding-bottom: var(--spacing-22x); }
                .padding-bottom-23--sm { padding-bottom: var(--spacing-23x); }
                .padding-bottom-24--sm { padding-bottom: var(--spacing-24x); }

                .padding-y-collapse--sm { padding-left: 0; padding-right: 0; }
                .padding-x-collapse--sm { padding-top: 0; padding-bottom: 0; }
                
                .margin-0--sm { margin: var(--spacing-0x); }
                .margin-1--sm { margin: var(--spacing-1x); }
                .margin-2--sm { margin: var(--spacing-2x); }
                .margin-3--sm { margin: var(--spacing-3x); }
                .margin-4--sm { margin: var(--spacing-4x); }
                .margin-5--sm { margin: var(--spacing-5x); }
                .margin-6--sm { margin: var(--spacing-6x); }
                .margin-7--sm { margin: var(--spacing-7x); }
                .margin-8--sm { margin: var(--spacing-8x); }
                .margin-9--sm { margin: var(--spacing-9x); }
                .margin-10--sm { margin: var(--spacing-10x); }
                .margin-11--sm { margin: var(--spacing-11x); }
                .margin-12--sm { margin: var(--spacing-12x); }
                .margin-13--sm { margin: var(--spacing-13x); }
                .margin-14--sm { margin: var(--spacing-14x); }
                .margin-15--sm { margin: var(--spacing-15x); }
                .margin-16--sm { margin: var(--spacing-16x); }
                .margin-17--sm { margin: var(--spacing-17x); }
                .margin-18--sm { margin: var(--spacing-18x); }
                .margin-19--sm { margin: var(--spacing-19x); }
                .margin-20--sm { margin: var(--spacing-20x); }
                .margin-21--sm { margin: var(--spacing-21x); }
                .margin-22--sm { margin: var(--spacing-22x); }
                .margin-23--sm { margin: var(--spacing-23x); }
                .margin-24--sm { margin: var(--spacing-24x); }

                .margin-y-0--sm { margin-top: var(--spacing-0x); margin-bottom: var(--spacing-0x); }
                .margin-y-1--sm { margin-top: var(--spacing-1x); margin-bottom: var(--spacing-1x); }
                .margin-y-2--sm { margin-top: var(--spacing-2x); margin-bottom: var(--spacing-2x); }
                .margin-y-3--sm { margin-top: var(--spacing-3x); margin-bottom: var(--spacing-3x); }
                .margin-y-4--sm { margin-top: var(--spacing-4x); margin-bottom: var(--spacing-4x); }
                .margin-y-5--sm { margin-top: var(--spacing-5x); margin-bottom: var(--spacing-5x); }
                .margin-y-6--sm { margin-top: var(--spacing-6x); margin-bottom: var(--spacing-6x); }
                .margin-y-7--sm { margin-top: var(--spacing-7x); margin-bottom: var(--spacing-7x); }
                .margin-y-8--sm { margin-top: var(--spacing-8x); margin-bottom: var(--spacing-8x); }
                .margin-y-9--sm { margin-top: var(--spacing-9x); margin-bottom: var(--spacing-9x); }
                .margin-y-10--sm { margin-top: var(--spacing-10x); margin-bottom: var(--spacing-10x); }
                .margin-y-11--sm { margin-top: var(--spacing-11x); margin-bottom: var(--spacing-11x); }
                .margin-y-12--sm { margin-top: var(--spacing-12x); margin-bottom: var(--spacing-12x); }
                .margin-y-13--sm { margin-top: var(--spacing-13x); margin-bottom: var(--spacing-13x); }
                .margin-y-14--sm { margin-top: var(--spacing-14x); margin-bottom: var(--spacing-14x); }
                .margin-y-15--sm { margin-top: var(--spacing-15x); margin-bottom: var(--spacing-15x); }
                .margin-y-16--sm { margin-top: var(--spacing-16x); margin-bottom: var(--spacing-16x); }
                .margin-y-17--sm { margin-top: var(--spacing-17x); margin-bottom: var(--spacing-17x); }
                .margin-y-18--sm { margin-top: var(--spacing-18x); margin-bottom: var(--spacing-18x); }
                .margin-y-19--sm { margin-top: var(--spacing-19x); margin-bottom: var(--spacing-19x); }
                .margin-y-20--sm { margin-top: var(--spacing-20x); margin-bottom: var(--spacing-20x); }
                .margin-y-21--sm { margin-top: var(--spacing-21x); margin-bottom: var(--spacing-21x); }
                .margin-y-22--sm { margin-top: var(--spacing-22x); margin-bottom: var(--spacing-22x); }
                .margin-y-23--sm { margin-top: var(--spacing-23x); margin-bottom: var(--spacing-23x); }
                .margin-y-24--sm { margin-top: var(--spacing-24x); margin-bottom: var(--spacing-24x); }

                .margin-x-0--sm { margin-left: var(--spacing-0x); margin-right: var(--spacing-0x); }
                .margin-x-1--sm { margin-left: var(--spacing-1x); margin-right: var(--spacing-1x); }
                .margin-x-2--sm { margin-left: var(--spacing-2x); margin-right: var(--spacing-2x); }
                .margin-x-3--sm { margin-left: var(--spacing-3x); margin-right: var(--spacing-3x); }
                .margin-x-4--sm { margin-left: var(--spacing-4x); margin-right: var(--spacing-4x); }
                .margin-x-5--sm { margin-left: var(--spacing-5x); margin-right: var(--spacing-5x); }
                .margin-x-6--sm { margin-left: var(--spacing-6x); margin-right: var(--spacing-6x); }
                .margin-x-7--sm { margin-left: var(--spacing-7x); margin-right: var(--spacing-7x); }
                .margin-x-8--sm { margin-left: var(--spacing-8x); margin-right: var(--spacing-8x); }
                .margin-x-9--sm { margin-left: var(--spacing-9x); margin-right: var(--spacing-9x); }
                .margin-x-10--sm { margin-left: var(--spacing-10x); margin-right: var(--spacing-10x); }
                .margin-x-11--sm { margin-left: var(--spacing-11x); margin-right: var(--spacing-11x); }
                .margin-x-12--sm { margin-left: var(--spacing-12x); margin-right: var(--spacing-12x); }
                .margin-x-13--sm { margin-left: var(--spacing-13x); margin-right: var(--spacing-13x); }
                .margin-x-14--sm { margin-left: var(--spacing-14x); margin-right: var(--spacing-14x); }
                .margin-x-15--sm { margin-left: var(--spacing-15x); margin-right: var(--spacing-15x); }
                .margin-x-16--sm { margin-left: var(--spacing-16x); margin-right: var(--spacing-16x); }
                .margin-x-17--sm { margin-left: var(--spacing-17x); margin-right: var(--spacing-17x); }
                .margin-x-18--sm { margin-left: var(--spacing-18x); margin-right: var(--spacing-18x); }
                .margin-x-19--sm { margin-left: var(--spacing-19x); margin-right: var(--spacing-19x); }
                .margin-x-20--sm { margin-left: var(--spacing-20x); margin-right: var(--spacing-20x); }
                .margin-x-21--sm { margin-left: var(--spacing-21x); margin-right: var(--spacing-21x); }
                .margin-x-22--sm { margin-left: var(--spacing-22x); margin-right: var(--spacing-22x); }
                .margin-x-23--sm { margin-left: var(--spacing-23x); margin-right: var(--spacing-23x); }
                .margin-x-24--sm { margin-left: var(--spacing-24x); margin-right: var(--spacing-24x); }

                .margin-left-0--sm { margin-left: var(--spacing-0x); }
                .margin-left-1--sm { margin-left: var(--spacing-1x); }
                .margin-left-2--sm { margin-left: var(--spacing-2x); }
                .margin-left-3--sm { margin-left: var(--spacing-3x); }
                .margin-left-4--sm { margin-left: var(--spacing-4x); }
                .margin-left-5--sm { margin-left: var(--spacing-5x); }
                .margin-left-6--sm { margin-left: var(--spacing-6x); }
                .margin-left-7--sm { margin-left: var(--spacing-7x); }
                .margin-left-8--sm { margin-left: var(--spacing-8x); }
                .margin-left-9--sm { margin-left: var(--spacing-9x); }
                .margin-left-10--sm { margin-left: var(--spacing-10x); }
                .margin-left-11--sm { margin-left: var(--spacing-11x); }
                .margin-left-12--sm { margin-left: var(--spacing-12x); }
                .margin-left-13--sm { margin-left: var(--spacing-13x); }
                .margin-left-14--sm { margin-left: var(--spacing-14x); }
                .margin-left-15--sm { margin-left: var(--spacing-15x); }
                .margin-left-16--sm { margin-left: var(--spacing-16x); }
                .margin-left-17--sm { margin-left: var(--spacing-17x); }
                .margin-left-18--sm { margin-left: var(--spacing-18x); }
                .margin-left-19--sm { margin-left: var(--spacing-19x); }
                .margin-left-20--sm { margin-left: var(--spacing-20x); }
                .margin-left-21--sm { margin-left: var(--spacing-21x); }
                .margin-left-22--sm { margin-left: var(--spacing-22x); }
                .margin-left-23--sm { margin-left: var(--spacing-23x); }
                .margin-left-24--sm { margin-left: var(--spacing-24x); }

                .margin-right-0--sm { margin-right: var(--spacing-0x); }
                .margin-right-1--sm { margin-right: var(--spacing-1x); }
                .margin-right-2--sm { margin-right: var(--spacing-2x); }
                .margin-right-3--sm { margin-right: var(--spacing-3x); }
                .margin-right-4--sm { margin-right: var(--spacing-4x); }
                .margin-right-5--sm { margin-right: var(--spacing-5x); }
                .margin-right-6--sm { margin-right: var(--spacing-6x); }
                .margin-right-7--sm { margin-right: var(--spacing-7x); }
                .margin-right-8--sm { margin-right: var(--spacing-8x); }
                .margin-right-9--sm { margin-right: var(--spacing-9x); }
                .margin-right-10--sm { margin-right: var(--spacing-10x); }
                .margin-right-11--sm { margin-right: var(--spacing-11x); }
                .margin-right-12--sm { margin-right: var(--spacing-12x); }
                .margin-right-13--sm { margin-right: var(--spacing-13x); }
                .margin-right-14--sm { margin-right: var(--spacing-14x); }
                .margin-right-15--sm { margin-right: var(--spacing-15x); }
                .margin-right-16--sm { margin-right: var(--spacing-16x); }
                .margin-right-17--sm { margin-right: var(--spacing-17x); }
                .margin-right-18--sm { margin-right: var(--spacing-18x); }
                .margin-right-19--sm { margin-right: var(--spacing-19x); }
                .margin-right-20--sm { margin-right: var(--spacing-20x); }
                .margin-right-21--sm { margin-right: var(--spacing-21x); }
                .margin-right-22--sm { margin-right: var(--spacing-22x); }
                .margin-right-23--sm { margin-right: var(--spacing-23x); }
                .margin-right-24--sm { margin-right: var(--spacing-24x); }

                .margin-top-0--sm { margin-top: var(--spacing-0x); }
                .margin-top-1--sm { margin-top: var(--spacing-1x); }
                .margin-top-2--sm { margin-top: var(--spacing-2x); }
                .margin-top-3--sm { margin-top: var(--spacing-3x); }
                .margin-top-4--sm { margin-top: var(--spacing-4x); }
                .margin-top-5--sm { margin-top: var(--spacing-5x); }
                .margin-top-6--sm { margin-top: var(--spacing-6x); }
                .margin-top-7--sm { margin-top: var(--spacing-7x); }
                .margin-top-8--sm { margin-top: var(--spacing-8x); }
                .margin-top-9--sm { margin-top: var(--spacing-9x); }
                .margin-top-10--sm { margin-top: var(--spacing-10x); }
                .margin-top-11--sm { margin-top: var(--spacing-11x); }
                .margin-top-12--sm { margin-top: var(--spacing-12x); }
                .margin-top-13--sm { margin-top: var(--spacing-13x); }
                .margin-top-14--sm { margin-top: var(--spacing-14x); }
                .margin-top-15--sm { margin-top: var(--spacing-15x); }
                .margin-top-16--sm { margin-top: var(--spacing-16x); }
                .margin-top-17--sm { margin-top: var(--spacing-17x); }
                .margin-top-18--sm { margin-top: var(--spacing-18x); }
                .margin-top-19--sm { margin-top: var(--spacing-19x); }
                .margin-top-20--sm { margin-top: var(--spacing-20x); }
                .margin-top-21--sm { margin-top: var(--spacing-21x); }
                .margin-top-22--sm { margin-top: var(--spacing-22x); }
                .margin-top-23--sm { margin-top: var(--spacing-23x); }
                .margin-top-24--sm { margin-top: var(--spacing-24x); }

                .margin-bottom-0--sm { margin-bottom: var(--spacing-0x); }
                .margin-bottom-1--sm { margin-bottom: var(--spacing-1x); }
                .margin-bottom-2--sm { margin-bottom: var(--spacing-2x); }
                .margin-bottom-3--sm { margin-bottom: var(--spacing-3x); }
                .margin-bottom-4--sm { margin-bottom: var(--spacing-4x); }
                .margin-bottom-5--sm { margin-bottom: var(--spacing-5x); }
                .margin-bottom-6--sm { margin-bottom: var(--spacing-6x); }
                .margin-bottom-7--sm { margin-bottom: var(--spacing-7x); }
                .margin-bottom-8--sm { margin-bottom: var(--spacing-8x); }
                .margin-bottom-9--sm { margin-bottom: var(--spacing-9x); }
                .margin-bottom-10--sm { margin-bottom: var(--spacing-10x); }
                .margin-bottom-11--sm { margin-bottom: var(--spacing-11x); }
                .margin-bottom-12--sm { margin-bottom: var(--spacing-12x); }
                .margin-bottom-13--sm { margin-bottom: var(--spacing-13x); }
                .margin-bottom-14--sm { margin-bottom: var(--spacing-14x); }
                .margin-bottom-15--sm { margin-bottom: var(--spacing-15x); }
                .margin-bottom-16--sm { margin-bottom: var(--spacing-16x); }
                .margin-bottom-17--sm { margin-bottom: var(--spacing-17x); }
                .margin-bottom-18--sm { margin-bottom: var(--spacing-18x); }
                .margin-bottom-19--sm { margin-bottom: var(--spacing-19x); }
                .margin-bottom-20--sm { margin-bottom: var(--spacing-20x); }
                .margin-bottom-21--sm { margin-bottom: var(--spacing-21x); }
                .margin-bottom-22--sm { margin-bottom: var(--spacing-22x); }
                .margin-bottom-23--sm { margin-bottom: var(--spacing-23x); }
                .margin-bottom-24--sm { margin-bottom: var(--spacing-24x); }

                .margin-y-collapse--sm { margin-left: 0; margin-right: 0; }
                .margin-x-collapse--sm { margin-top: 0; margin-bottom: 0; }

            }

            @media only screen and (min-width:768px) 
            {
                .padding--lg { padding: var(--spacing); }
                .padding-0--lg { padding: var(--spacing-0x); }
                .padding-2--lg { padding: var(--spacing-2x); }
                .padding-3--lg { padding: var(--spacing-3x); }
                .padding-4--lg { padding: var(--spacing-4x); }
                .padding-5--lg { padding: var(--spacing-5x); }
                .padding-6--lg { padding: var(--spacing-6x); }
                .padding-7--lg { padding: var(--spacing-7x); }
                .padding-8--lg { padding: var(--spacing-8x); }
                .padding-9--lg { padding: var(--spacing-9x); }
                .padding-10--lg { padding: var(--spacing-10x); }
                .padding-11--lg { padding: var(--spacing-11x); }
                .padding-12--lg { padding: var(--spacing-12x); }
                .padding-13--lg { padding: var(--spacing-13x); }
                .padding-14--lg { padding: var(--spacing-14x); }
                .padding-15--lg { padding: var(--spacing-15x); }
                .padding-16--lg { padding: var(--spacing-16x); }
                .padding-17--lg { padding: var(--spacing-17x); }
                .padding-18--lg { padding: var(--spacing-18x); }
                .padding-19--lg { padding: var(--spacing-19x); }
                .padding-20--lg { padding: var(--spacing-20x); }
                .padding-21--lg { padding: var(--spacing-21x); }
                .padding-22--lg { padding: var(--spacing-22x); }
                .padding-23--lg { padding: var(--spacing-23x); }
                .padding-24--lg { padding: var(--spacing-24x); }

                .padding-y-0--lg { padding-top: var(--spacing-0x); padding-bottom: var(--spacing-0x); }
                .padding-y-1--lg { padding-top: var(--spacing-1x); padding-bottom: var(--spacing-1x); }
                .padding-y-2--lg { padding-top: var(--spacing-2x); padding-bottom: var(--spacing-2x); }
                .padding-y-3--lg { padding-top: var(--spacing-3x); padding-bottom: var(--spacing-3x); }
                .padding-y-4--lg { padding-top: var(--spacing-4x); padding-bottom: var(--spacing-4x); }
                .padding-y-5--lg { padding-top: var(--spacing-5x); padding-bottom: var(--spacing-5x); }
                .padding-y-6--lg { padding-top: var(--spacing-6x); padding-bottom: var(--spacing-6x); }
                .padding-y-7--lg { padding-top: var(--spacing-7x); padding-bottom: var(--spacing-7x); }
                .padding-y-8--lg { padding-top: var(--spacing-8x); padding-bottom: var(--spacing-8x); }
                .padding-y-9--lg { padding-top: var(--spacing-9x); padding-bottom: var(--spacing-9x); }
                .padding-y-10--lg { padding-top: var(--spacing-10x); padding-bottom: var(--spacing-10x); }
                .padding-y-11--lg { padding-top: var(--spacing-11x); padding-bottom: var(--spacing-11x); }
                .padding-y-12--lg { padding-top: var(--spacing-12x); padding-bottom: var(--spacing-12x); }
                .padding-y-13--lg { padding-top: var(--spacing-13x); padding-bottom: var(--spacing-13x); }
                .padding-y-14--lg { padding-top: var(--spacing-14x); padding-bottom: var(--spacing-14x); }
                .padding-y-15--lg { padding-top: var(--spacing-15x); padding-bottom: var(--spacing-15x); }
                .padding-y-16--lg { padding-top: var(--spacing-16x); padding-bottom: var(--spacing-16x); }
                .padding-y-17--lg { padding-top: var(--spacing-17x); padding-bottom: var(--spacing-17x); }
                .padding-y-18--lg { padding-top: var(--spacing-18x); padding-bottom: var(--spacing-18x); }
                .padding-y-19--lg { padding-top: var(--spacing-19x); padding-bottom: var(--spacing-19x); }
                .padding-y-20--lg { padding-top: var(--spacing-20x); padding-bottom: var(--spacing-20x); }
                .padding-y-21--lg { padding-top: var(--spacing-21x); padding-bottom: var(--spacing-21x); }
                .padding-y-22--lg { padding-top: var(--spacing-22x); padding-bottom: var(--spacing-22x); }
                .padding-y-23--lg { padding-top: var(--spacing-23x); padding-bottom: var(--spacing-23x); }
                .padding-y-24--lg { padding-top: var(--spacing-24x); padding-bottom: var(--spacing-24x); }

                .padding-x-0--lg { padding-left: var(--spacing-0x); padding-right: var(--spacing-0x); }
                .padding-x-1--lg { padding-left: var(--spacing-1x); padding-right: var(--spacing-1x); }
                .padding-x-2--lg { padding-left: var(--spacing-2x); padding-right: var(--spacing-2x); }
                .padding-x-3--lg { padding-left: var(--spacing-3x); padding-right: var(--spacing-3x); }
                .padding-x-4--lg { padding-left: var(--spacing-4x); padding-right: var(--spacing-4x); }
                .padding-x-5--lg { padding-left: var(--spacing-5x); padding-right: var(--spacing-5x); }
                .padding-x-6--lg { padding-left: var(--spacing-6x); padding-right: var(--spacing-6x); }
                .padding-x-7--lg { padding-left: var(--spacing-7x); padding-right: var(--spacing-7x); }
                .padding-x-8--lg { padding-left: var(--spacing-8x); padding-right: var(--spacing-8x); }
                .padding-x-9--lg { padding-left: var(--spacing-9x); padding-right: var(--spacing-9x); }
                .padding-x-10--lg { padding-left: var(--spacing-10x); padding-right: var(--spacing-10x); }
                .padding-x-11--lg { padding-left: var(--spacing-11x); padding-right: var(--spacing-11x); }
                .padding-x-12--lg { padding-left: var(--spacing-12x); padding-right: var(--spacing-12x); }
                .padding-x-13--lg { padding-left: var(--spacing-13x); padding-right: var(--spacing-13x); }
                .padding-x-14--lg { padding-left: var(--spacing-14x); padding-right: var(--spacing-14x); }
                .padding-x-15--lg { padding-left: var(--spacing-15x); padding-right: var(--spacing-15x); }
                .padding-x-16--lg { padding-left: var(--spacing-16x); padding-right: var(--spacing-16x); }
                .padding-x-17--lg { padding-left: var(--spacing-17x); padding-right: var(--spacing-17x); }
                .padding-x-18--lg { padding-left: var(--spacing-18x); padding-right: var(--spacing-18x); }
                .padding-x-19--lg { padding-left: var(--spacing-19x); padding-right: var(--spacing-19x); }
                .padding-x-20--lg { padding-left: var(--spacing-20x); padding-right: var(--spacing-20x); }
                .padding-x-21--lg { padding-left: var(--spacing-21x); padding-right: var(--spacing-21x); }
                .padding-x-22--lg { padding-left: var(--spacing-22x); padding-right: var(--spacing-22x); }
                .padding-x-23--lg { padding-left: var(--spacing-23x); padding-right: var(--spacing-23x); }
                .padding-x-24--lg { padding-left: var(--spacing-24x); padding-right: var(--spacing-24x); }

                .padding-left-0--lg { padding-left: var(--spacing-0x); }
                .padding-left-1--lg { padding-left: var(--spacing-1x); }
                .padding-left-2--lg { padding-left: var(--spacing-2x); }
                .padding-left-3--lg { padding-left: var(--spacing-3x); }
                .padding-left-4--lg { padding-left: var(--spacing-4x); }
                .padding-left-5--lg { padding-left: var(--spacing-5x); }
                .padding-left-6--lg { padding-left: var(--spacing-6x); }
                .padding-left-7--lg { padding-left: var(--spacing-7x); }
                .padding-left-8--lg { padding-left: var(--spacing-8x); }
                .padding-left-9--lg { padding-left: var(--spacing-9x); }
                .padding-left-10--lg { padding-left: var(--spacing-10x); }
                .padding-left-11--lg { padding-left: var(--spacing-11x); }
                .padding-left-12--lg { padding-left: var(--spacing-12x); }
                .padding-left-13--sm { padding-left: var(--spacing-13x); }
                .padding-left-14--sm { padding-left: var(--spacing-14x); }
                .padding-left-15--sm { padding-left: var(--spacing-15x); }
                .padding-left-16--sm { padding-left: var(--spacing-16x); }
                .padding-left-17--sm { padding-left: var(--spacing-17x); }
                .padding-left-18--sm { padding-left: var(--spacing-18x); }
                .padding-left-19--sm { padding-left: var(--spacing-19x); }
                .padding-left-20--sm { padding-left: var(--spacing-20x); }
                .padding-left-21--sm { padding-left: var(--spacing-21x); }
                .padding-left-22--sm { padding-left: var(--spacing-22x); }
                .padding-left-23--sm { padding-left: var(--spacing-23x); }
                .padding-left-24--sm { padding-left: var(--spacing-24x); }

                .padding-right-0--lg { padding-right: var(--spacing-0x); }
                .padding-right-1--lg { padding-right: var(--spacing-1x); }
                .padding-right-2--lg { padding-right: var(--spacing-2x); }
                .padding-right-3--lg { padding-right: var(--spacing-3x); }
                .padding-right-4--lg { padding-right: var(--spacing-4x); }
                .padding-right-5--lg { padding-right: var(--spacing-5x); }
                .padding-right-6--lg { padding-right: var(--spacing-6x); }
                .padding-right-7--lg { padding-right: var(--spacing-7x); }
                .padding-right-8--lg { padding-right: var(--spacing-8x); }
                .padding-right-9--lg { padding-right: var(--spacing-9x); }
                .padding-right-10--lg { padding-right: var(--spacing-10x); }
                .padding-right-11--lg { padding-right: var(--spacing-11x); }
                .padding-right-12--lg { padding-right: var(--spacing-12x); }
                .padding-right-13--lg { padding-right: var(--spacing-13x); }
                .padding-right-14--lg { padding-right: var(--spacing-14x); }
                .padding-right-15--lg { padding-right: var(--spacing-15x); }
                .padding-right-16--lg { padding-right: var(--spacing-16x); }
                .padding-right-17--lg { padding-right: var(--spacing-17x); }
                .padding-right-18--lg { padding-right: var(--spacing-18x); }
                .padding-right-19--lg { padding-right: var(--spacing-19x); }
                .padding-right-20--lg { padding-right: var(--spacing-20x); }
                .padding-right-21--lg { padding-right: var(--spacing-21x); }
                .padding-right-22--lg { padding-right: var(--spacing-22x); }
                .padding-right-23--lg { padding-right: var(--spacing-23x); }
                .padding-right-24--lg { padding-right: var(--spacing-24x); }

                .padding-top-0--lg { padding-top: var(--spacing-0x); }
                .padding-top-1--lg { padding-top: var(--spacing-1x); }
                .padding-top-2--lg { padding-top: var(--spacing-2x); }
                .padding-top-3--lg { padding-top: var(--spacing-3x); }
                .padding-top-4--lg { padding-top: var(--spacing-4x); }
                .padding-top-5--lg { padding-top: var(--spacing-5x); }
                .padding-top-6--lg { padding-top: var(--spacing-6x); }
                .padding-top-7--lg { padding-top: var(--spacing-7x); }
                .padding-top-8--lg { padding-top: var(--spacing-8x); }
                .padding-top-9--lg { padding-top: var(--spacing-9x); }
                .padding-top-10--lg { padding-top: var(--spacing-10x); }
                .padding-top-11--lg { padding-top: var(--spacing-11x); }
                .padding-top-12--lg { padding-top: var(--spacing-12x); }
                .padding-top-13--lg { padding-top: var(--spacing-13x); }
                .padding-top-14--lg { padding-top: var(--spacing-14x); }
                .padding-top-15--lg { padding-top: var(--spacing-15x); }
                .padding-top-16--lg { padding-top: var(--spacing-16x); }
                .padding-top-17--lg { padding-top: var(--spacing-17x); }
                .padding-top-18--lg { padding-top: var(--spacing-18x); }
                .padding-top-19--lg { padding-top: var(--spacing-19x); }
                .padding-top-20--lg { padding-top: var(--spacing-20x); }
                .padding-top-21--lg { padding-top: var(--spacing-21x); }
                .padding-top-22--lg { padding-top: var(--spacing-22x); }
                .padding-top-23--lg { padding-top: var(--spacing-23x); }
                .padding-top-24--lg { padding-top: var(--spacing-24x); }

                .padding-bottom-0--lg { padding-bottom: var(--spacing-0x); }
                .padding-bottom-1--lg { padding-bottom: var(--spacing-1x); }
                .padding-bottom-2--lg { padding-bottom: var(--spacing-2x); }
                .padding-bottom-3--lg { padding-bottom: var(--spacing-3x); }
                .padding-bottom-4--lg { padding-bottom: var(--spacing-4x); }
                .padding-bottom-5--lg { padding-bottom: var(--spacing-5x); }
                .padding-bottom-6--lg { padding-bottom: var(--spacing-6x); }
                .padding-bottom-7--lg { padding-bottom: var(--spacing-7x); }
                .padding-bottom-8--lg { padding-bottom: var(--spacing-8x); }
                .padding-bottom-9--lg { padding-bottom: var(--spacing-9x); }
                .padding-bottom-10--lg { padding-bottom: var(--spacing-10x); }
                .padding-bottom-11--lg { padding-bottom: var(--spacing-11x); }
                .padding-bottom-12--lg { padding-bottom: var(--spacing-12x); }
                .padding-bottom-13--lg { padding-bottom: var(--spacing-13x); }
                .padding-bottom-14--lg { padding-bottom: var(--spacing-14x); }
                .padding-bottom-15--lg { padding-bottom: var(--spacing-15x); }
                .padding-bottom-16--lg { padding-bottom: var(--spacing-16x); }
                .padding-bottom-17--lg { padding-bottom: var(--spacing-17x); }
                .padding-bottom-18--lg { padding-bottom: var(--spacing-18x); }
                .padding-bottom-19--lg { padding-bottom: var(--spacing-19x); }
                .padding-bottom-20--lg { padding-bottom: var(--spacing-20x); }
                .padding-bottom-21--lg { padding-bottom: var(--spacing-21x); }
                .padding-bottom-22--lg { padding-bottom: var(--spacing-22x); }
                .padding-bottom-23--lg { padding-bottom: var(--spacing-23x); }
                .padding-bottom-24--lg { padding-bottom: var(--spacing-24x); }

                .padding-y-collapse--lg { padding-left: 0; padding-right: 0; }
                .padding-x-collapse--lg { padding-top: 0; padding-bottom: 0; }


                .margin-0--lg { margin: var(--spacing-0x); }
                .margin-1--lg { margin: var(--spacing-1x); }
                .margin-2--lg { margin: var(--spacing-2x); }
                .margin-3--lg { margin: var(--spacing-3x); }
                .margin-4--lg { margin: var(--spacing-4x); }
                .margin-5--lg { margin: var(--spacing-5x); }
                .margin-6--lg { margin: var(--spacing-6x); }
                .margin-7--lg { margin: var(--spacing-7x); }
                .margin-8--lg { margin: var(--spacing-8x); }
                .margin-9--lg { margin: var(--spacing-9x); }
                .margin-10--lg { margin: var(--spacing-10x); }
                .margin-11--lg { margin: var(--spacing-11x); }
                .margin-12--lg { margin: var(--spacing-12x); }
                .margin-13--lg { margin: var(--spacing-13x); }
                .margin-14--lg { margin: var(--spacing-14x); }
                .margin-15--lg { margin: var(--spacing-15x); }
                .margin-16--lg { margin: var(--spacing-16x); }
                .margin-17--lg { margin: var(--spacing-17x); }
                .margin-18--lg { margin: var(--spacing-18x); }
                .margin-19--lg { margin: var(--spacing-19x); }
                .margin-20--lg { margin: var(--spacing-20x); }
                .margin-21--lg { margin: var(--spacing-21x); }
                .margin-22--lg { margin: var(--spacing-22x); }
                .margin-23--lg { margin: var(--spacing-23x); }
                .margin-24--lg { margin: var(--spacing-24x); }

                .margin-y-0--lg { margin-top: var(--spacing-0x); margin-bottom: var(--spacing-0x); }
                .margin-y-1--lg { margin-top: var(--spacing-1x); margin-bottom: var(--spacing-1x); }
                .margin-y-2--lg { margin-top: var(--spacing-2x); margin-bottom: var(--spacing-2x); }
                .margin-y-3--lg { margin-top: var(--spacing-3x); margin-bottom: var(--spacing-3x); }
                .margin-y-4--lg { margin-top: var(--spacing-4x); margin-bottom: var(--spacing-4x); }
                .margin-y-5--lg { margin-top: var(--spacing-5x); margin-bottom: var(--spacing-5x); }
                .margin-y-6--lg { margin-top: var(--spacing-6x); margin-bottom: var(--spacing-6x); }
                .margin-y-7--lg { margin-top: var(--spacing-7x); margin-bottom: var(--spacing-7x); }
                .margin-y-8--lg { margin-top: var(--spacing-8x); margin-bottom: var(--spacing-8x); }
                .margin-y-9--lg { margin-top: var(--spacing-9x); margin-bottom: var(--spacing-9x); }
                .margin-y-10--lg { margin-top: var(--spacing-10x); margin-bottom: var(--spacing-10x); }
                .margin-y-11--lg { margin-top: var(--spacing-11x); margin-bottom: var(--spacing-11x); }
                .margin-y-12--lg { margin-top: var(--spacing-12x); margin-bottom: var(--spacing-12x); }
                .margin-y-12--lg { margin-left: var(--spacing-12x); margin-right: var(--spacing-12x); }
                .margin-y-13--lg { margin-left: var(--spacing-13x); margin-right: var(--spacing-13x); }
                .margin-y-14--lg { margin-left: var(--spacing-14x); margin-right: var(--spacing-14x); }
                .margin-y-15--lg { margin-left: var(--spacing-15x); margin-right: var(--spacing-15x); }
                .margin-y-16--lg { margin-left: var(--spacing-16x); margin-right: var(--spacing-16x); }
                .margin-y-17--lg { margin-left: var(--spacing-17x); margin-right: var(--spacing-17x); }
                .margin-y-18--lg { margin-left: var(--spacing-18x); margin-right: var(--spacing-18x); }
                .margin-y-19--lg { margin-left: var(--spacing-19x); margin-right: var(--spacing-19x); }
                .margin-y-20--lg { margin-left: var(--spacing-20x); margin-right: var(--spacing-20x); }
                .margin-y-21--lg { margin-left: var(--spacing-21x); margin-right: var(--spacing-21x); }
                .margin-y-22--lg { margin-left: var(--spacing-22x); margin-right: var(--spacing-22x); }
                .margin-y-23--lg { margin-left: var(--spacing-23x); margin-right: var(--spacing-23x); }
                .margin-y-24--lg { margin-left: var(--spacing-24x); margin-right: var(--spacing-24x); }


                .margin-x-0--lg { margin-left: var(--spacing-0x); margin-right: var(--spacing-0x); }
                .margin-x-1--lg { margin-left: var(--spacing-1x); margin-right: var(--spacing-1x); }
                .margin-x-2--lg { margin-left: var(--spacing-2x); margin-right: var(--spacing-2x); }
                .margin-x-3--lg { margin-left: var(--spacing-3x); margin-right: var(--spacing-3x); }
                .margin-x-4--lg { margin-left: var(--spacing-4x); margin-right: var(--spacing-4x); }
                .margin-x-5--lg { margin-left: var(--spacing-5x); margin-right: var(--spacing-5x); }
                .margin-x-6--lg { margin-left: var(--spacing-6x); margin-right: var(--spacing-6x); }
                .margin-x-7--lg { margin-left: var(--spacing-7x); margin-right: var(--spacing-7x); }
                .margin-x-8--lg { margin-left: var(--spacing-8x); margin-right: var(--spacing-8x); }
                .margin-x-9--lg { margin-left: var(--spacing-9x); margin-right: var(--spacing-9x); }
                .margin-x-10--lg { margin-left: var(--spacing-10x); margin-right: var(--spacing-10x); }
                .margin-x-11--lg { margin-left: var(--spacing-11x); margin-right: var(--spacing-11x); }
                .margin-x-12--lg { margin-left: var(--spacing-12x); margin-right: var(--spacing-12x); }
                .margin-x-12--lg { margin-left: var(--spacing-12x); margin-right: var(--spacing-12x); }
                .margin-x-13--lg { margin-left: var(--spacing-13x); margin-right: var(--spacing-13x); }
                .margin-x-14--lg { margin-left: var(--spacing-14x); margin-right: var(--spacing-14x); }
                .margin-x-15--lg { margin-left: var(--spacing-15x); margin-right: var(--spacing-15x); }
                .margin-x-16--lg { margin-left: var(--spacing-16x); margin-right: var(--spacing-16x); }
                .margin-x-17--lg { margin-left: var(--spacing-17x); margin-right: var(--spacing-17x); }
                .margin-x-18--lg { margin-left: var(--spacing-18x); margin-right: var(--spacing-18x); }
                .margin-x-19--lg { margin-left: var(--spacing-19x); margin-right: var(--spacing-19x); }
                .margin-x-20--lg { margin-left: var(--spacing-20x); margin-right: var(--spacing-20x); }
                .margin-x-21--lg { margin-left: var(--spacing-21x); margin-right: var(--spacing-21x); }
                .margin-x-22--lg { margin-left: var(--spacing-22x); margin-right: var(--spacing-22x); }
                .margin-x-23--lg { margin-left: var(--spacing-23x); margin-right: var(--spacing-23x); }
                .margin-x-24--lg { margin-left: var(--spacing-24x); margin-right: var(--spacing-24x); }


                .margin-left-0--lg { margin-left: var(--spacing-0x); }
                .margin-left-1--lg { margin-left: var(--spacing-1x); }
                .margin-left-2--lg { margin-left: var(--spacing-2x); }
                .margin-left-3--lg { margin-left: var(--spacing-3x); }
                .margin-left-4--lg { margin-left: var(--spacing-4x); }
                .margin-left-5--lg { margin-left: var(--spacing-5x); }
                .margin-left-6--lg { margin-left: var(--spacing-6x); }
                .margin-left-7--lg { margin-left: var(--spacing-7x); }
                .margin-left-8--lg { margin-left: var(--spacing-8x); }
                .margin-left-9--lg { margin-left: var(--spacing-9x); }
                .margin-left-10--lg { margin-left: var(--spacing-10x); }
                .margin-left-11--lg { margin-left: var(--spacing-11x); }
                .margin-left-12--lg { margin-left: var(--spacing-12x); }
                .margin-left-13--lg { margin-left: var(--spacing-13x); }
                .margin-left-14--lg { margin-left: var(--spacing-14x); }
                .margin-left-15--lg { margin-left: var(--spacing-15x); }
                .margin-left-16--lg { margin-left: var(--spacing-16x); }
                .margin-left-17--lg { margin-left: var(--spacing-17x); }
                .margin-left-18--lg { margin-left: var(--spacing-18x); }
                .margin-left-19--lg { margin-left: var(--spacing-19x); }
                .margin-left-20--lg { margin-left: var(--spacing-20x); }
                .margin-left-21--lg { margin-left: var(--spacing-21x); }
                .margin-left-22--lg { margin-left: var(--spacing-22x); }
                .margin-left-23--lg { margin-left: var(--spacing-23x); }
                .margin-left-24--lg { margin-left: var(--spacing-24x); }

                .margin-right-0--lg { margin-right: var(--spacing-0x); }
                .margin-right-1--lg { margin-right: var(--spacing-1x); }
                .margin-right-2--lg { margin-right: var(--spacing-2x); }
                .margin-right-3--lg { margin-right: var(--spacing-3x); }
                .margin-right-4--lg { margin-right: var(--spacing-4x); }
                .margin-right-5--lg { margin-right: var(--spacing-5x); }
                .margin-right-6--lg { margin-right: var(--spacing-6x); }
                .margin-right-7--lg { margin-right: var(--spacing-7x); }
                .margin-right-8--lg { margin-right: var(--spacing-8x); }
                .margin-right-9--lg { margin-right: var(--spacing-9x); }
                .margin-right-10--lg { margin-right: var(--spacing-10x); }
                .margin-right-11--lg { margin-right: var(--spacing-11x); }
                .margin-right-12--lg { margin-right: var(--spacing-12x); }
                .margin-right-13--lg { margin-right: var(--spacing-13x); }
                .margin-right-14--lg { margin-right: var(--spacing-14x); }
                .margin-right-15--lg { margin-right: var(--spacing-15x); }
                .margin-right-16--lg { margin-right: var(--spacing-16x); }
                .margin-right-17--lg { margin-right: var(--spacing-17x); }
                .margin-right-18--lg { margin-right: var(--spacing-18x); }
                .margin-right-19--lg { margin-right: var(--spacing-19x); }
                .margin-right-20--lg { margin-right: var(--spacing-20x); }
                .margin-right-21--lg { margin-right: var(--spacing-21x); }
                .margin-right-22--lg { margin-right: var(--spacing-22x); }
                .margin-right-23--lg { margin-right: var(--spacing-23x); }
                .margin-right-24--lg { margin-right: var(--spacing-24x); }

                .margin-top-0--lg { margin-top: var(--spacing-0x); }
                .margin-top-1--lg { margin-top: var(--spacing-1x); }
                .margin-top-2--lg { margin-top: var(--spacing-2x); }
                .margin-top-3--lg { margin-top: var(--spacing-3x); }
                .margin-top-4--lg { margin-top: var(--spacing-4x); }
                .margin-top-5--lg { margin-top: var(--spacing-5x); }
                .margin-top-6--lg { margin-top: var(--spacing-6x); }
                .margin-top-7--lg { margin-top: var(--spacing-7x); }
                .margin-top-8--lg { margin-top: var(--spacing-8x); }
                .margin-top-9--lg { margin-top: var(--spacing-9x); }
                .margin-top-10--lg { margin-top: var(--spacing-10x); }
                .margin-top-11--lg { margin-top: var(--spacing-11x); }
                .margin-top-12--lg { margin-top: var(--spacing-12x); }
                .margin-top-13--lg { margin-top: var(--spacing-13x); }
                .margin-top-14--lg { margin-top: var(--spacing-14x); }
                .margin-top-15--lg { margin-top: var(--spacing-15x); }
                .margin-top-16--lg { margin-top: var(--spacing-16x); }
                .margin-top-17--lg { margin-top: var(--spacing-17x); }
                .margin-top-18--lg { margin-top: var(--spacing-18x); }
                .margin-top-19--lg { margin-top: var(--spacing-19x); }
                .margin-top-20--lg { margin-top: var(--spacing-20x); }
                .margin-top-21--lg { margin-top: var(--spacing-21x); }
                .margin-top-22--lg { margin-top: var(--spacing-22x); }
                .margin-top-23--lg { margin-top: var(--spacing-23x); }
                .margin-top-24--lg { margin-top: var(--spacing-24x); }

                .margin-bottom-0--lg { margin-bottom: var(--spacing-0x); }
                .margin-bottom-1--lg { margin-bottom: var(--spacing-1x); }
                .margin-bottom-2--lg { margin-bottom: var(--spacing-2x); }
                .margin-bottom-3--lg { margin-bottom: var(--spacing-3x); }
                .margin-bottom-4--lg { margin-bottom: var(--spacing-4x); }
                .margin-bottom-5--lg { margin-bottom: var(--spacing-5x); }
                .margin-bottom-6--lg { margin-bottom: var(--spacing-6x); }
                .margin-bottom-7--lg { margin-bottom: var(--spacing-7x); }
                .margin-bottom-8--lg { margin-bottom: var(--spacing-8x); }
                .margin-bottom-9--lg { margin-bottom: var(--spacing-9x); }
                .margin-bottom-10--lg { margin-bottom: var(--spacing-10x); }
                .margin-bottom-11--lg { margin-bottom: var(--spacing-11x); }
                .margin-bottom-12--lg { margin-bottom: var(--spacing-12x); }
                .margin-bottom-13--lg { margin-bottom: var(--spacing-13x); }
                .margin-bottom-14--lg { margin-bottom: var(--spacing-14x); }
                .margin-bottom-15--lg { margin-bottom: var(--spacing-15x); }
                .margin-bottom-16--lg { margin-bottom: var(--spacing-16x); }
                .margin-bottom-17--lg { margin-bottom: var(--spacing-17x); }
                .margin-bottom-18--lg { margin-bottom: var(--spacing-18x); }
                .margin-bottom-19--lg { margin-bottom: var(--spacing-19x); }
                .margin-bottom-20--lg { margin-bottom: var(--spacing-20x); }
                .margin-bottom-21--lg { margin-bottom: var(--spacing-21x); }
                .margin-bottom-22--lg { margin-bottom: var(--spacing-22x); }
                .margin-bottom-23--lg { margin-bottom: var(--spacing-23x); }
                .margin-bottom-24--lg { margin-bottom: var(--spacing-24x); }

                .margin-y-collapse--lg { margin-left: 0; margin-right: 0; }
                .margin-x-collapse--lg { margin-top: 0; margin-bottom: 0; }
            }
          mode: css
        type: item
        enabled: true
      -
        uid: button
        path: /src/lib/css
        name: button
        ext: css
        content:
          code: |-
            :root
            {

                /*
                    ----------------------------------------------------
                    BUTTON : PRIMARY
                    ----------------------------------------------------
                */
                    
                    --button-primary-type-size: var(--type-size);
                    --button-primary-type-weight: var(--type-weight-medium);
                    --button-primary-color: var(--color-white);
                    --button-primary-background-color: var(--color-blue-light);
                    --button-primary-border: none;
                    --button-primary-border-radius: 1.168vw;
                    --button-primary-margin: 0;
                    --button-primary-padding: 1.869vw 3.738vw;


                    --button-primary-alt-color: var(--color-white);
                    --button-primary-alt-background-color: var(--color-blue-light);
                    --button-primary-alt-border: .5vw solid var(--color-white);
                    --button-primary-alt-border-radius: 1.168vw;
                    --button-primary-alt-margin: 0;

                /*
                    ----------------------------------------------------
                    BUTTON : PRIMARY : LG
                    ----------------------------------------------------
                */

                --button-primary-type-size--lg: var(--type-size--lg);
                --button-primary-type-weight--lg: var(--type-weight-bold);
                --button-primary-type-line-height--lg: var(--type-line-height--lg);

                /*
                    ----------------------------------------------------
                    BUTTON : SECONDARY
                    ----------------------------------------------------
                */

            }

            @media only screen and (min-width: 768px)
            {

                :root
                {
                    /*
                        ----------------------------------------------------
                        BUTTON : PRIMARY
                        ----------------------------------------------------
                    */

                    
                    --button-primary-type-size: var(--type-size);
                    --button-primary-border-radius: 0.55vw;
                    --button-primary-padding: .75vw 2vw;

                    --button-primary-alt-type-size: var(--type-size);
                    --button-primary-alt-border: .15vw solid var(--color-white);
                    --button-primary-alt-border-radius: 1.168vw;

                    /*
                        ----------------------------------------------------
                        BUTTON : SECONDARY
                        ----------------------------------------------------
                    */
                }
            }


             .button-primary
            { 
                font-size: var(--button-primary-type-size);
                font-weight: var(--button-primary-type-weight);
                line-height: var(--line-height);
                /* border-radius: var(--button-primary-border-radius); */
                background-color: var(--button-primary-background-color);
                color: var(--button-primary-color);
                padding: var(--button-primary-padding);
                margin: var(--button-primary-margin);
                border: var(--button-primary-border);
            }

            .button-primary--lg
            { 
                font-size: var(--button-primary-type-size--lg);
                font-weight: var(--button-primary-type-weight--lg);
                line-height: var(--button-primary-type-line-height--lg);
                /* border-radius: var(--button-primary-border-radius); */
                background-color: var(--button-primary-background-color);
                color: var(--button-primary-color);
                padding: var(--button-primary-padding);
                margin: var(--button-primary-margin);
                border: var(--button-primary-border);
             }




             .button-primary-alt
             { 
                 font-size: var(--button-primary-type-size);
                 font-weight: var(--button-primary-type-weight);
                 line-height: var(--line-height);
                 border: var(--button-primary-alt-border);
                 /* border-radius: var(--button-primary-alt-border-radius); */
                 background-color: var(--button-primary-alt-background-color);
                 color: var(--button-primary-alt-color);
                 padding: var(--button-primary-padding);
                 margin: var(--button-primary-margin);
             }
          mode: css
        type: item
        enabled: true
      -
        uid: global
        path: /src/lib/css
        name: global
        ext: css
        content:
          code: |-
            /*
                ----------------------------------------------------
                Type: LEADER GRAY
                ----------------------------------------------------
            */

            :root
            {   

                --nav-main-button-display: inline-block;
                --nav-main-button-close-display: inline-block;

                --block-4up-photo-margin-top: inherit;
                --block-width-leader-gray: 92vw; 
                --block-padding-leader-gray: 6.5vw 4vw;
                --block-margin-leader-gray: -.25vw auto;

                --section-blue-divider-width: 1vw;
                --section-blue-divider-height: .25vw;
                --section-blue-divider-margin: 0;

                --ul-type-size: var(--type-size);
                --ul-type-size-diff: .25vw;
                --ul-type-line-height: 1.25;

                --ul-padding: 0 var(--spacing-3x) 0 0;
                --ul-padding-nested: 0 0 0 var(--spacing-6x);

                --ul-bullet-top: 2vw;
                --ul-bullet-left: -3vw;

                --ul-bullet-width: 2vw;
                --ul-bullet-height: 2vw;
                --ul-bullet-padding: .85vw 0 0 .25vw;
                --ul-bullet-size: 2vw 2vw;

                --ul-li-margin: 0 0 var(--spacing-1x) 0;
                --ul-li-padding: calc( var(--spacing-1x) / 8 ) 0 calc( var(--spacing-1x) / 8 ) calc( var(--spacing-1x) / 1.15 );


                --ol-type-size: var(--type-size);
                --ol-type-size-diff: .25vw;
                --ol-type-line-height: 1.25;

                --ol-padding: 0 var(--spacing-3x) 0 var(--spacing-3x);

                --ol-bullet-top: 0vw;
                --ol-bullet-left: -3vw;

                --ol-bullet-width: 6vw;
                --ol-bullet-height: 6vw;
                --ol-bullet-padding: .85vw 0 0 .25vw;

                --ol-li-margin: 0 0 var(--spacing-1x) 0;
                --ol-li-padding: calc( var(--spacing-1x) / 8 ) 0 calc( var(--spacing-1x) / 8 ) calc( var(--spacing-1x) / .4 );

                --flip-front-icon-width: 24vw;
                --flip-front-header: calc(7.243vw + 1px);
                --flip-front-header-line-height: 1.25;
                --flip-front-header-padding: 2vw;
                --flip-back-p-padding: 0 6vw;
                
                --flip-back-p-medium-size: calc(3.25vw + 1px);
                --flip-back-p-medium-line-height: 1.25; 
                --flip-back-strong-medium-size: calc(9vw + 1px);
                --flip-back-strong-medium-line-height: 1.15;

                --flip-back-p-large-size: calc(9.25vw + 1px);
                --flip-back-p-large-line-height: 1.05; 
                --flip-back-strong-large-size: calc(18vw + 1px);
                --flip-back-strong-large-line-height: 1.15;

                --swiper-width: 92vw; 
                --swiper-margin-left: 8vw; 
                --swiper-scrollbar-width: 85vw;

                --swiper-slide-square-max-height: 83.15vw;
            }

            @media only screen and (min-width: 768px)
            {

                :root
                {      
                    
                    --nav-main-button-display: none;
                    --nav-main-button-close-display: none;

                    --block-width-leader-gray: 84vw; 
                    --block-padding-leader-gray: 3.292vw 7.292vw;
                    --block-margin-leader-gray: -.25vw auto;

                    --section-blue-divider-width: 100%;
                    --section-blue-divider-height: .05vw;
                    --section-blue-divider-margin: 0;
                    
                    --ul-type-size: 1.75vw;
                    --ul-type-line-height: 1.5;

                    --ul-padding: 0 3.25vw 0 0;
                    --ul-padding-nested: 0 0 0 3.25vw;

                    --ul-bullet-top: .75vw;
                    --ul-bullet-left: -1vw;
                    --ul-bullet-width: 2vw;
                    --ul-bullet-height: 2vw;
                    --ul-bullet-padding: .20vw 0 0;

                    --ul-bullet-size: 1.15vw 1.15vw;
                    --ul-li-margin: 0 0 1vw 0;
                    --ul-li-padding: calc( var(--spacing-1x) / 6 ) 0 calc( var(--spacing-1x) / 6 ) calc( var(--spacing-2x) / 2 );



                    --ol-type-size: 1.75vw;
                    --ol-type-line-height: 1.5;
                    
                    --ol-padding: 0 3.25vw 0 3.25vw;
                    
                    --ol-bullet-top: 0vw;
                    --ol-bullet-left: -1vw;
                    --ol-bullet-width: 3vw;
                    --ol-bullet-height: 3vw;
                    --ol-bullet-padding: .20vw 0 0;

                    --ol-li-margin: 0 0 1vw 0;
                    --ol-li-padding: calc( var(--spacing-1x) / 6 ) 0 calc( var(--spacing-1x) / 6 ) calc( var(--spacing-2x) / 1.35 );

                    --flip-front-icon-width: 5vw;
                    --flip-front-header: calc(2.646vw + 1px);
                    --flip-front-header-line-height: 1.1;
                    --flip-front-header-padding: 2vw;
                    --flip-back-p-padding: 0 2vw;

                    --flip-back-p-medium-size: calc(1.5vw + 1px);
                    --flip-back-p-medium-line-height: 1.15; 
                    --flip-back-strong-medium-size: calc(3.5vw + 1px);
                    --flip-back-strong-medium-line-height: 1.15;
                    
                    --flip-back-p-large-size: 3.25vw;
                    --flip-back-p-large-line-height: 1.1; 
                    --flip-back-strong-large-size: 6.5vw;
                    --flip-back-strong-large-line-height: 1.1;

                    --swiper-width: 99vw; 
                    --swiper-margin-left: 1vw;
                    --swiper-scrollbar-width: 89vw;

                    --swiper-slide-square-max-height: 38.333vw;
                }
            }




            /*
                ----------------------------------------------------
                Table of Contents:
                ----------------------------------------------------
                    - SCREEN READERS:
                    
                    - HEADER: NAV: LOGO
                    - HEADER: NAV: MENU

            */

                html { overflow-x: hidden; }

                body 
                { 
                    font-family: var(--type-family); 
                    font-weight: var(--type-weight-light); 
                    line-height: var(--type-line-height);
                    color: var(--color-gray-dark);
                    background-color: var(--color-gray-bright);
                }
            /*
                -------------------------------------------------
                SCREEN READERS:
                -------------------------------------------------
            */

                .sr-only { 
                    position: absolute;
                    width: 1px;
                    height: 1px;
                    padding: 0;
                    margin: -1px;
                    overflow: hidden;
                    clip: rect(0, 0, 0, 0);
                    white-space: nowrap;
                    border-width: 0; 
                }

                .no-sr-only {
                    position: static;
                    width: auto;
                    height: auto;
                    padding: 0;
                    margin: 0;
                    overflow: visible;
                    clip: auto;
                    white-space: normal;
                }

                .hidden { display: none !important; }

            /*
                -------------------------------------------------
                MAIN:
                -------------------------------------------------
            */

                /* main { overflow-x: hidden; } */

            /*
            -------------------------------------------------
            HEADER: NAV: Logo
            -------------------------------------------------
            */

                .logo { position: absolute; z-index: 2 }

                @media only screen and (max-width: 767px)
                {
                    .logo { top: 4.75vw; left: 5.25vw; width: 56vw; }
                }

                @media only screen and (min-width: 768px)
                {
                    .logo { top: 2.75vw; left: 5.4vw; width: 29.5vw; }
                }



                /*
                -------------------------------------------------
                HEADER: NAV: Main
                -------------------------------------------------
                */

                .header { position: relative; }

                .nav-main { position: absolute; z-index: 10; }

             
                .nav-main-button { z-index: 11; }
                .nav-main-ul { z-index: 12; }
                .nav-main-button-close { z-index: 13; }

                .nav-main-button { display: var(--nav-main-button-display); }
                .nav-main-button-close { display: var(--nav-main-button-close-display); }  

                .nav-main-a-active { font-weight: var(--type-weight-normal); }

                @media only screen and (max-width: 767px)
                {
                    .nav-main-button,
                    .nav-main-button-close { position: absolute; top: 8.411vw; right: 5.374vw; border: none; background: none; }

                    /* .nav-main-close-button { position: absolute; top: 8vw; right: 5vw; width: 8vw; background: none;  } */
                    /* .nav-main-button img  { width: 100%; height: auto; } */
                    
                    .nav-main { position: fixed; left: 100vw; top: 0; width: 100vw; height: 100vh; display: grid; place-content: center center; background-color: var(--color-blue-dark); animation-duration: .35s; animation-fill-mode: forwards; }
                    .nav-main-close { animation-name: nav-main-close; }
                    .nav-main-open { animation-name: nav-main-open; }

                    .nav-main-ul {  }

                    .nav-main-li { line-height: 1.15; width: 100%; text-align: center; font-family: var(--font-family-header); font-weight: var(--type-weight-light); font-size: 10vw; }

                    .nav-main-a:not(.nav-main-a-active),
                    .nav-main-a:not(.nav-main-a-active):hover,
                    .nav-main-a:not(.nav-main-a-active):focus-visible {
                        color: var(--color-white); 
                        transition: color .2s ease-in;
                        -moz-transition: color .2s ease-in;
                        -o-transition: color .2s ease-in;
                        -webkit-transition: color .2s ease-in;
                    }

                    @keyframes nav-main-open
                    {
                        from {
                            transform: translateX(0%);
                        }

                        to {
                            transform: translateX(-100%);
                        }
                    }

                    @keyframes nav-main-close
                    {
                        from {
                            transform: translateX(-100%);
                        }

                        to {
                            transform: translateX(0%);
                        }
                    }
                }

                @media only screen and (min-width: 768px)
                {
                    .nav-main-menu-button,
                    .nav-main-close-button { display: none; }

                    .nav-main { right: 5.4vw; top: 3.25vw; height: 0px; }

                    .nav-main-li { display: inline-block; }
                    .nav-main-li:hover { cursor: pointer; }

                    .nav-main-li + .nav-main-li { margin-left: .665vw; }
                
                    .nav-main-a:not(.nav-main-a-active),
                    .nav-main-a:not(.nav-main-a-active):focus, 
                    .nav-main-a:not(.nav-main-a-active):visited { color: var(--color-gray-dark); }
                
                    .nav-main-a:not(.nav-main-a-active):hover,
                    .nav-main-a:not(.nav-main-a-active):focus-visible {
                        color: var(--color-blue-light); 
                        transition: color .2s ease-in;
                        -moz-transition: color .2s ease-in;
                        -o-transition: color .2s ease-in;
                        -webkit-transition: color .2s ease-in;
                    }

                    .nav-main-a-active { color: var(--color-blue-light); }
                    
                    .nav-main-a-white { color: #fff !important; }
                    
                    .nav-main-sub { display: none; }

                    /*

                     .nav-main { top: 2.965vw; right: 3.365vw; }

                    .nav-main-a { font-size: calc(1.365vw + 1px); }

                    .nav-main-li:hover .nav-main-sub { display: block; }

                    */
                    

                }

            /*
            -------------------------------------------------
            SECTION: BUTTON 
            -------------------------------------------------
                - w/ GRAY LEADER
            */

            a, button { cursor: pointer; }

            @media only screen and (min-width: 768px)
            {
                button.primary
                { 
                    /* padding: 7.292vw;     */
                }
            }


            /*
            -------------------------------------------------
            ELEMENT: OL, UL
            -------------------------------------------------
            */

            .ul { 
                list-style: none;
                padding: var(--ul-padding);
            }

            .ul .ul { 
                padding: var(--ul-padding-nested);
            }

            .ul li {
                margin: var(--ul-li-margin);
                padding: var(--ul-li-padding);
                position: relative;
            }

            .ul li::before 
            {
                color: var(--color-white);
                font-size: var(--ul-type-size);
                font-weight: var(--type-weight-medium);
                line-height: var(--ul-type-line-height);
                text-align: center;

                position: absolute;
                top: var(--ul-bullet-top);
                left: var(--ul-bullet-left);
                width: var(--ul-bullet-width);
                height: var(--ul-bullet-height);
                padding: var(--ul-bullet-padding);
                background: transparent;
                content: " ";
                background-image: url('/lib/images/icon-ul-arrow.svg');
                background-size: var(--ul-bullet-size);
                background-position: 0 0;
                background-repeat: no-repeat;
            }

            .ul-white li::before 
            {
                color: var(--color-white);
                background-image: url('/lib/images/icon-ul-arrow-white.svg');
            }

            /* .ul-arrow li::before {
                top: var(--ul-arrow-top);
                left: var(--ul-arrow-left);
                width: var(--ul-arrow-width);
                height: var(--ul-arrow-height);
                background-image: url(/lib/images/icon-ul-arrow.svg);
                background-color: transparent;
            } */

            .ol { 
                list-style: none;
                padding: var(--ol-padding);
            }


            .ol li {
                margin: var(--ol-li-margin);
                padding: var(--ol-li-padding);
                position: relative;
            }


            .ol li::before {
                color: var(--color-white);
                font-size: var(--ol-type-size);
                font-weight: var(--type-weight-medium);
                line-height: var(--ol-type-line-height);
                text-align: center;

                position: absolute;
                top: var(--ol-bullet-top);
                left: var(--ol-bullet-left);
                width: var(--ol-bullet-width);
                height: var(--ol-bullet-height);

                padding: var(--ol-bullet-padding);

                background: var(--color-blue-light);
                border-radius: 100%;
            }

            .ol { 
                counter-reset: my-awesome-counter;
            }
            .ol li {
                counter-increment: my-awesome-counter;
            }

            .ol li::before {
                content: counter(my-awesome-counter);
            }
            /*
            -------------------------------------------------
            ELEMENT: BACKGROUND PATTERN
            -------------------------------------------------
            */

                .background-pattern { background-image: url('/lib/images/background-line-angle-white.png'); }

                @media only screen and (max-width: 767px)
                {
                    .background-pattern { margin-left: 8vw; margin-top: -8.5vw; width: 100%; height: 120%; }
                }

                @media only screen and (min-width: 768px)
                {
                    .background-pattern { margin-left: 3.5vw; margin-top: -3.25vw; width: 100%; height: 116%; }
                }


            /*
            -------------------------------------------------
            ELEMENT: SWIPER
            -------------------------------------------------
            */
                /* .swiper { padding: initial; } */
                .swiper-full { width: var(--swiper-width) !important; margin-left: var(--swiper-margin-left) !important; }
                .swiper-flip { overflow-x: hidden; overflow-y: visible; padding: 4vw; }
                .swiper-scrollbar { width: var(--swiper-scrollbar-width) !important; margin: 0 var(--spacing-2x) !important; }
                .swiper-scrollbar-drag { background-color: var(--color-blue-light); }

                #swiper-what-drives-us,
                .swiper-slide-square,
                .swiper-slide-square picture,
                .swiper-slide-square img { 
                    width: var(--swiper-slide-square-max-height) !important; 
                    height: var(--swiper-slide-square-max-height) !important; 
                    max-width: var(--swiper-slide-square-max-height) !important;
                    max-height: var(--swiper-slide-square-max-height) !important; }


            /*
            -------------------------------------------------
            ELEMENT: FLIP
            -------------------------------------------------
            */

                .flip { float: left; perspective: 750px;  } 
                
                .flip:hover:not(.flip-none) .flip-front img { transform: scale(1.35); transition: transform 0.25s; }

                .flip:hover:not(.flip-none) .flip-front { transform: rotateY( -180deg ); transition: transform 0.5s; transition-delay: .125s; }
                
                .flip:hover:not(.flip-none) .flip-back { transform: rotateY( -0deg ); transition: transform 0.5s; transition-delay: .125s; }

                .flip-front:not(.flip-none) img { transform: scale(1); transition: transform 0.25s; }

                .flip-front,
                .flip-back { background-color: var(--color-white); text-align: center; overflow: hidden; backface-visibility: hidden; transition-delay: 0.075s; transition: transform 1s; transform-style: preserve-3d;  }
                
                .flip-front { color: var(--color-white); }
                
                .flip-front-icon { width: var(--flip-front-icon-width); }

                .flip-front-header { color: var(--color-white); font-size: var(--flip-front-header); font-family: var(--type-family-header); font-weight: var(--type-weight-medium); line-height: var(--flip-front-header-line-height); padding: var(--flip-front-header-padding); }

                .flip-back { width: 100%; height: 100%; background-color: var(--color-white); transform: rotateY( 180deg ); }

                .flip-back p,
                .flip-back-p-medium,
                .flip-back-p-large { color: var(--color-gray-light); padding: var(--flip-back-p-padding); }

                .flip-back-p-medium { font-size: var(--flip-back-p-medium-size); font-family: var(--type-family-header); font-weight: var(--type-weight-medium); line-height: var(--flip-back-p-medium-line-height);}
                .flip-back-strong-medium { color: var(--color-blue-light); font-size: var(--flip-back-strong-medium-size); font-family: var(--type-family-header); font-weight: var(--type-weight-bold); line-height: var(--flip-back-strong-medium-line-height);  display: block; }


                .flip-back-p-large { font-size: var(--flip-back-p-large-size); font-family: var(--type-family-header); font-weight: var(--type-weight-medium); line-height: var(--flip-back-p-large-line-height);}
                .flip-back-strong-large { color: var(--color-blue-light); font-size: var(--flip-back-strong-large-size); font-family: var(--type-family-header); font-weight: var(--type-weight-bold); line-height: var(--flip-back-strong-large-line-height);  display: block; } 

            /*
            -------------------------------------------------
            SECTION: BLUE 
            -------------------------------------------------
                - WHITE
                - BLUE
                - BLUE LEADER GRAY
            */

                /* section { border-top: 1px solid pink; border-bottom: 1px solid pink; } */

                .section-white { background-color: var(--color-white); }

                .section-blue { color: white; background-color: var(--color-blue-light); }

                .section-blue + .section-blue::before {
                    content: ' ';
                    display: block;
                    background-color: var(--color-white);
                    width: var(--section-blue-divider-width);
                    height: var(--section-blue-divider-height);
                    margin: var(--section-blue-divider-margin);
                    position: absolute;
                    top: 0;
                    left: 10vw;
                    width: 80vw;
                }

                .section-gray-cool-dark { color: var(--color-white); background-color: var(--color-gray-cool-dark); }

                .section-leader-gray { color: var(--color-gray-dark); background-color: var(--color-gray-bright); width: var(--block-width-leader-gray); margin: var(--block-margin-leader-gray); padding: var(--block-padding-leader-gray); }

            /*
            -------------------------------------------------
            SECTION: 1 (HERO)
            -------------------------------------------------
            */

                :root 
                { 

                    --h1-margin: 14vw 0 0;

                    --h1-span-type-size: calc(12.65vw + 1px);
                    --h1-span-line-height: .6;
                    --h1-span-padding: 4.5vw 1vw 2vw;
                    --h1-span-margin: 0;
                    --h1-span-box-shadow: 1.15vw 0 0 rgba(75,190,236, .85), -1.15vw 0 0 rgba(75,190,236,.85);

                    --h1-small-type-size: calc(7.25vw + 1px);
                    --h1-small-line-height: .3;
                    --h1-small-padding: 4.5vw 1vw .85vw;
                    --h1-small-box-shadow: 1.25vw 0 0 rgba(75,190,236, .85), -.85vw 0 0 rgba(75,190,236,.85);
                    --h1-small-lower-type-size: calc(5vw + 1px);
                    --h1-small-lower-line-height: .3;
                    --h1-small-lower-padding: 1.1vw 1vw 1.85vw;
                    --h1-small-lower-box-shadow: 1.25vw 0 0 rgba(75,190,236, .85), -.85vw 0 0 rgba(75,190,236,.85);

                    --hp-span-type-size: calc(3.85vw + 1px);
                    --hp-span-line-height: 1.25;
                    --hp-span-padding: 0vw 0 1.5vw;
                    --hp-span-margin: 0;
                    --hp-span-box-shadow: 0 0 rgba(75,190,236,.85), 0vw 0 rgba(75,190,236,.85);

                    --h1a-link-margin: 4vw auto 0;
                }

                @media only screen and (min-width: 768px)
                {
                    :root 
                    {
                        --h1-margin: 21vw 0 0;

                        --h1-span-type-size: calc(11vw + 1px);
                        --h1-span-line-height: .6;
                        --h1-span-padding: 3vw 1vw 1.5vw;
                        --h1-span-margin: 0;
                        --h1-span-box-shadow: 1.15vw 0 0 rgba(75,190,236, .85), -1.15vw 0 0 rgba(75,190,236,.85);

                        --h1-small-type-size: calc(5.15vw + 1px);
                        --h1-small-line-height: .3;
                        --h1-small-padding: 3vw 1vw .85vw;
                        --h1-small-box-shadow: 1.25vw 0 0 rgba(75,190,236, .85), -.85vw 0 0 rgba(75,190,236,.85);

                        --hp-span-type-size: calc(2.45vw + 1px);
                        --hp-span-line-height: 1.075;
                        --hp-span-padding: 0.15vw 0 .85vw;
                        --hp-span-margin: 0;
                        --hp-span-box-shadow: 1.15vw 0 rgba(75,190,236,.85), -1.5vw 0 rgba(75,190,236,.85);

                        --h1a-link-margin: 2vw auto 0;
                    }
                }
                
                .section-1 { color: var(--color-white); padding-top: var(--section-1-padding); }

                .section-1 .h1 { 
                    display: grid;
                    place-items: start center;
                    margin: var(--h1-margin);
                }

                .section-1 .h1 > * {
                    position: relative; 
                    display: grid;
                    z-index: 200;
                    background-color: rgba(75,190,236, .85);
                }

                .section-1 .h1:not(.h1-small) > *:not(.h1-small) {
                    font-size: var(--h1-span-type-size);
                    line-height: var(--h1-span-line-height);
                    padding: var(--h1-span-padding);
                    margin: var(--h1-span-margin);
                    box-shadow: var(--h1-span-box-shadow);
                }


                .section-1 .h1 > .h1-small {
                    font-size: var(--h1-small-type-size);
                    line-height: var(--h1-small-line-height);
                    padding: var(--h1-small-padding);
                    box-shadow: var(--h1-small-box-shadow);
                }

                .section-1 .h1 > .h1-small-lower {
                    font-size: var(--h1-small-lower-type-size);
                    line-height: var(--h1-small-lower-line-height);
                    padding: var(--h1-small-lower-padding);
                    box-shadow: var(--h1-small-lower-box-shadow);
                }

                .h1-small > span:nth-child(1)
                {
                    font-size: var(--h1-small-type-size);
                    line-height: var(--h1-small-line-height);
                    padding: var(--h1-small-padding);
                    box-shadow: var(--h1-small-box-shadow);
                }

                .h1-small > span:nth-child(2) {
                    font-size: var(--h1-span-type-size);
                    line-height: var(--h1-span-line-height);
                    padding: var(--h1-span-padding);
                    margin: var(--h1-span-margin);
                    box-shadow: var(--h1-span-box-shadow);
                }

                .h1-small > span:nth-child(3) {
                    font-size: var(--h1-small-lower-type-size);
                    line-height: var(--h1-small-lower-line-height);
                    padding: var(--h1-small-lower-padding);
                    box-shadow: var(--h1-small-lower-box-shadow);
                }

                .section-1 .hp { 
                    text-align: center;
                    display: inline-block;
                    margin: 0 0;
                    padding: 0;
                  }
                  
                .section-1 .hp span { 
                    font-size: var(--hp-span-type-size);
                    display: inline-block;
                    margin: var(--hp-span-margin);
                    padding: var(--hp-span-padding);
                    background-color: #4bbeecd9;
                    box-shadow: var(--hp-span-box-shadow);
                    line-height: var(--hp-span-line-height);
                }

                .section-1 .hp span:first-of-type {  padding-top: 0; }

                .section-1 a {
                    display: inline-block;
                    width: auto;
                    margin: var(--h1a-link-margin);
                }
            /*
            -------------------------------------------------
            SECTION: 2Up
            -------------------------------------------------
            */


                
            /*
            -------------------------------------------------
            SECTION: 4Up-photos
            -------------------------------------------------
            */

                .swiper-full-4up :is(figure) + :is(figure) { display: grid; margin-top: 0 !important; }

                @media only screen and (min-width: 768px)
                {
                    .swiper-full-4up { width: auto !important; margin-left: auto !important; }
                }
          mode: css
        type: item
        enabled: true
      -
        uid: grid
        path: /src/lib/css
        name: grid
        ext: css
        content:
          code: |-
            /* GRID && BREAKPOINTS */

            .grid { display: grid; grid-template-columns: 1fr; }

            .grid-2 { grid-template-columns: repeat(2, 1fr); }
            .grid-3 { grid-template-columns: repeat(3, 1fr); }
            .grid-4 { grid-template-columns: repeat(4, 1fr); }
            .grid-5 { grid-template-columns: repeat(5, 1fr); }
            .grid-6 { grid-template-columns: repeat(6, 1fr); }
            .grid-7 { grid-template-columns: repeat(7, 1fr); }
            .grid-8 { grid-template-columns: repeat(8, 1fr); }
            .grid-9 { grid-template-columns: repeat(9, 1fr); }
            .grid-10 { grid-template-columns: repeat(10, 1fr); }
            .grid-11 { grid-template-columns: repeat(11, 1fr); }
            .grid-12 { grid-template-columns: repeat(12, 1fr); }

            .grid-2-alt > *:nth-child(1) { order: 2; }
            .grid-2-alt > *:nth-child(2) { order: 1; }

            .grid-3-alt > *:nth-child(1) { order: 3; }
            .grid-3-alt > *:nth-child(2) { order: 2; }
            .grid-3-alt > *:nth-child(3) { order: 1; }

            .grid-4-alt > *:nth-child(1) { order: 4; }
            .grid-4-alt > *:nth-child(2) { order: 3; }
            .grid-4-alt > *:nth-child(3) { order: 3; }
            .grid-4-alt > *:nth-child(4) { order: 1; }

            @media only screen and (min-width:0) and (max-width: 767px)
            {
                .grid--sm { display: grid; grid-template-columns: 1fr; }
                .grid-2--sm { grid-template-columns: repeat(2, 1fr); }
                .grid-3--sm { grid-template-columns: repeat(3, 1fr); }
                .grid-4--sm { grid-template-columns: repeat(4, 1fr); }
                .grid-5--sm { grid-template-columns: repeat(5, 1fr); }
                .grid-6--sm { grid-template-columns: repeat(6, 1fr); }
                .grid-7--sm { grid-template-columns: repeat(7, 1fr); }
                .grid-8--sm { grid-template-columns: repeat(8, 1fr); }
                .grid-9--sm { grid-template-columns: repeat(9, 1fr); }
                .grid-10--sm { grid-template-columns: repeat(10, 1fr); }
                .grid-11--sm { grid-template-columns: repeat(12, 1fr); }
                .grid-12--sm { grid-template-columns: repeat(13, 1fr); }

                .grid-2-alt--sm > *:nth-child(1) { order: 2; }
                .grid-2-alt--sm > *:nth-child(2) { order: 1; }

                .grid-3-alt--sm > *:nth-child(1) { order: 3; }
                .grid-3-alt--sm > *:nth-child(2) { order: 2; }
                .grid-3-alt--sm > *:nth-child(3) { order: 1; }

                .grid-4-alt--sm > *:nth-child(1) { order: 4; }
                .grid-4-alt--sm > *:nth-child(2) { order: 3; }
                .grid-4-alt--sm > *:nth-child(3) { order: 2; }
                .grid-4-alt--sm > *:nth-child(4) { order: 1; }
            }

            @media only screen and (min-width: 768px)
            {
                .grid--lg { display: grid; grid-template-columns: 1fr; }
                .grid-2--lg { grid-template-columns: repeat(2, 1fr); }
                .grid-3--lg { grid-template-columns: repeat(3, 1fr); }
                .grid-4--lg { grid-template-columns: repeat(4, 1fr); }
                .grid-5--lg { grid-template-columns: repeat(5, 1fr); }
                .grid-6--lg { grid-template-columns: repeat(6, 1fr); }
                .grid-7--lg { grid-template-columns: repeat(7, 1fr); }
                .grid-8--lg { grid-template-columns: repeat(8, 1fr); }
                .grid-9--lg { grid-template-columns: repeat(9, 1fr); }
                .grid-10--lg { grid-template-columns: repeat(10, 1fr); }
                .grid-11--lg { grid-template-columns: repeat(12, 1fr); }
                .grid-12--lg { grid-template-columns: repeat(13, 1fr); }

                .grid-2-alt--lg > *:nth-child(1) { order: 2; }
                .grid-2-alt--lg > *:nth-child(2) { order: 1; }

                .grid-3-alt--lg > *:nth-child(1) { order: 3; }
                .grid-3-alt--lg > *:nth-child(2) { order: 2; }
                .grid-3-alt--lg > *:nth-child(3) { order: 1; }

                .grid-4-alt--lg > *:nth-child(1) { order: 4; }
                .grid-4-alt--lg > *:nth-child(2) { order: 3; }
                .grid-4-alt--lg > *:nth-child(3) { order: 2; }
                .grid-4-alt--lg > *:nth-child(4) { order: 1; }
            }

            /* GRID : AUTO FLOW */

            .grid-flow-col { grid-auto-flow: column; }
            .grid-flow-row { grid-auto-flow: row; }

            /* GRID : COLUMN GAP */
            .grid-col-gap-1 { grid-column-gap: var(--spacing-1x); }
            .grid-col-gap-2 { grid-column-gap: var(--spacing-2x); }
            .grid-col-gap-3 { grid-column-gap: var(--spacing-3x); }
            .grid-col-gap-4 { grid-column-gap: var(--spacing-4x); }
            .grid-col-gap-5 { grid-column-gap: var(--spacing-5x); }
            .grid-col-gap-6 { grid-column-gap: var(--spacing-6x); }

            /* GRID : COLUMN GAP */
            .grid-row-gap-1 { grid-row-gap: var(--spacing-1x); }
            .grid-row-gap-2 { grid-row-gap: var(--spacing-2x); }
            .grid-row-gap-3 { grid-row-gap: var(--spacing-3x); }
            .grid-row-gap-4 { grid-row-gap: var(--spacing-4x); }
            .grid-row-gap-5 { grid-row-gap: var(--spacing-5x); }
            .grid-row-gap-6 { grid-row-gap: var(--spacing-6x); }

            @media only screen and (max-width:767px)
            { 
                .grid-col-gap-1--sm { grid-column-gap: var(--spacing-1x); }
                .grid-col-gap-2--sm { grid-column-gap: var(--spacing-2x); }
                .grid-col-gap-3--sm { grid-column-gap: var(--spacing-3x); }
                .grid-col-gap-4--sm { grid-column-gap: var(--spacing-4x); }
                .grid-col-gap-5--sm { grid-column-gap: var(--spacing-5x); }
                .grid-col-gap-6--sm { grid-column-gap: var(--spacing-6x); }

                .grid-row-gap-1--sm { grid-row-gap: var(--spacing-1x); }
                .grid-row-gap-2--sm { grid-row-gap: var(--spacing-2x); }
                .grid-row-gap-3--sm { grid-row-gap: var(--spacing-3x); }
                .grid-row-gap-4--sm { grid-row-gap: var(--spacing-4x); }
                .grid-row-gap-5--sm { grid-row-gap: var(--spacing-5x); }
                .grid-row-gap-6--sm { grid-row-gap: var(--spacing-6x); }
            }

            @media only screen and (min-width:768px)
            { 
                .grid-col-gap-1--lg { grid-column-gap: var(--spacing-1x); }
                .grid-col-gap-2--lg { grid-column-gap: var(--spacing-2x); }
                .grid-col-gap-3--lg { grid-column-gap: var(--spacing-3x); }
                .grid-col-gap-4--lg { grid-column-gap: var(--spacing-4x); }
                .grid-col-gap-5--lg { grid-column-gap: var(--spacing-5x); }
                .grid-col-gap-6--lg { grid-column-gap: var(--spacing-6x); }

                .grid-row-gap-1--lg { grid-row-gap: var(--spacing-1x); }
                .grid-row-gap-2--lg { grid-row-gap: var(--spacing-2x); }
                .grid-row-gap-3--lg { grid-row-gap: var(--spacing-3x); }
                .grid-row-gap-4--lg { grid-row-gap: var(--spacing-4x); }
                .grid-row-gap-5--lg { grid-row-gap: var(--spacing-5x); }
                .grid-row-gap-6--lg { grid-row-gap: var(--spacing-6x); }
            }

            /* GRID : COLUMN SPANS */
            .grid-span { grid-column: 1 / -1; }
            .grid-span-2 { grid-column: 1 / span 2; }
            .grid-span-3 { grid-column: 1 / span 3; }
            .grid-span-4 { grid-column: 1 / span 4; }
            .grid-span-5 { grid-column: 1 / span 5; }
            .grid-span-6 { grid-column: 1 / span 6; }
            .grid-span-7 { grid-column: 1 / span 7; }
            .grid-span-8 { grid-column: 1 / span 8; }
            .grid-span-9 { grid-column: 1 / span 9; }
            .grid-span-10 { grid-column: 1 / span 10; }
            .grid-span-11 { grid-column: 1 / span 11; }
            .grid-span-12 { grid-column: 1 / span 12; }

            @media only screen and (min-width:768px)
            { 
                .grid-span--sm { grid-column: 1 / -1; }
                .grid-span-2--sm { grid-column: 1 / span 2; }
                .grid-span-3--sm { grid-column: 1 / span 3; }
                .grid-span-4--sm { grid-column: 1 / span 4; }
                .grid-span-4--sm { grid-column: 1 / span 5; }
                .grid-span-6--sm { grid-column: 1 / span 6; }
                .grid-span-7--sm { grid-column: 1 / span 7; }
                .grid-span-8--sm { grid-column: 1 / span 8; }
                .grid-span-9--sm { grid-column: 1 / span 9; }
                .grid-span-10--sm { grid-column: 1 / span 10; }
                .grid-span-11--sm { grid-column: 1 / span 11; }
                .grid-span-12--sm { grid-column: 1 / span 12; }
            }

            @media only screen and (min-width:768px)
            { 
                .grid-span--lg { grid-column: 1 / -1; }
                .grid-span-2--lg { grid-column: 1 / span 2; }
                .grid-span-3--lg { grid-column: 1 / span 3; }
                .grid-span-4--lg { grid-column: 1 / span 4; }
                .grid-span-4--lg { grid-column: 1 / span 5; }
                .grid-span-6--lg { grid-column: 1 / span 6; }
                .grid-span-7--lg { grid-column: 1 / span 7; }
                .grid-span-8--lg { grid-column: 1 / span 8; }
                .grid-span-9--lg { grid-column: 1 / span 9; }
                .grid-span-10--lg { grid-column: 1 / span 10; }
                .grid-span-11--lg { grid-column: 1 / span 11; }
                .grid-span-12--lg { grid-column: 1 / span 12; }
            }

            /* GRID : COLUMN OVERLAP && BREAKPOINTS */

            .grid-stacked > * { grid-column: 1 / -1; grid-row: 1 / 1; }

            @media only screen and (min-width:0px) and (max-width:767px) { .grid-stacked--sm > * { grid-column: 1 / -1; grid-row: 1 / 1; } }

            @media only screen and (min-width:768px) { .grid-stacked--lg > * { grid-column: 1 / -1; grid-row: 1 / 1; } }


            /* GRID : PLACE-SELF CONTENT ALIGNMENT */

            .place-self-start { place-self: start start; }
            .place-self-start-center { place-self: start center; }
            .place-self-start-end { place-self: start end; }

            .place-self-center-start { place-self: center start; }
            .place-self-center-center { place-self: center center; }
            .place-self-center-end { place-self: center end; }

            .place-self-end-start { place-self: end start; }
            .place-self-end-center { place-self: end center; }
            .place-self-end-end { place-self: end end; }

            @media only screen and (min-width:0px) 
            { 
                .place-self-start--sm { place-self: start start; }
                .place-self-start-center--sm { place-self: start center; }
                .place-self-start-end--sm { place-self: start end; }

                .place-self-center-start--sm { place-self: center start; }
                .place-self-center-center--sm { place-self: center center; }
                .place-self-center-end--sm { place-self: center end; }

                .place-self-end-start--sm { place-self: end start; }
                .place-self-end-center--sm { place-self: end center; }
                .place-self-end-end--sm { place-self: end end; }
            }

            @media only screen and (min-width:768px)
            { 
                .place-self-start--lg { place-self: start start; }
                .place-self-start-center--lg { place-self: start center; }
                .place-self-start-end--lg { place-self: start end; }

                .place-self-center-start--lg { place-self: center start; }
                .place-self-center-center--lg { place-self: center center; }
                .place-self-center-end--lg { place-self: center end; }
                
                .place-self-end-start--lg { place-self: end start; }
                .place-self-end-center--lg { place-self: end center; }
                .place-self-end-end--lg { place-self: end end; }
            }
          mode: css
        type: item
        enabled: true
      -
        uid: insights
        path: /src/lib/css
        name: insights
        content:
          code: |-
            .section-post-references {
                color: var(--color-white);
                background-color: var(--color-gray-cool-dark);
            }

            .section-post-references-ol li::before {
                background: var(--color-blue-light);
            }

            .section-post-references-link,
            .section-post-references-link:link,
            .section-post-references-link:focus,
            .section-post-references-link:visited {
                margin: 0 0;
                color: var(--color-white);
                overflow-wrap: break-word;
            }
          mode: css
        type: item
        enabled: true
        ext: css
      -
        uid: ttpl-sign-up
        path: /src/lib/css
        name: ttpl-sign-up
        ext: css
        content:
          code: |-
            .modal { top: 100vh; background-color: var(--color-white); font-size: 32px; transform: scale(1); }
            .modal.active { top: 0; }

            .modal-close-btn { cursor: pointer; background-color: transparent; }

            .modal-content > div > div { text-align: center; }

            .modal-content .header { font-family: var(--type-family-header); font-weight: var(--type-weight-bold); color: var(--color-blue-light); text-transform: uppercase; }
            .modal-content .header span { font-family: var(--type-family-header); font-weight: var(--type-weight-bold); color: var(--color-blue-dark); text-transform: uppercase; }

            .modal-content p { font-style: var(--type-style-italic); }

            .modal-form-subscribe input { background-color: var(--color-gray-bright);  }

            .modal-form-subscribe input[type*='submit'] { color: var(--color-white); font-weight: var(--type-weight-medium); text-transform: uppercase; background-color: var(--color-blue-light); }
            .modal-form-subscribe input[type*='submit']:disabled { opacity: .5; }

            .modal-form-subscribe label { display: none; }
            .modal-form-subscribe label.active { display: inline-block; }

            .banner { inset: auto 0 0; transform: scale(1); }
            .banner, .banner-content, .banner-cta { cursor: pointer; }
            .banner-content .header, .banner-content p { color: var(--color-blue-dark); text-align: center; }
            .banner-content .header span.highlight { color: var(--color-blue-light); }
            .banner-content .header { font-family: var(--type-family-header); font-weight: var(--type-weight-bold); text-transform: uppercase; }
            .banner-cta { background-color: var(--color-blue-light); }
            .banner-cta-txt { font-weight: var(--type-weight-medium); line-height: .75; color: var(--color-white); text-transform: uppercase; }



            @media only screen and (max-width:767px) 
            { 
                .modal-close { top: 2.367vw; right: 2.367vw; }

                .modal-content { text-align: center; }
                
                .modal-content .header-logo { width: 65vw; margin-bottom: -4.75vw; }
                .modal-content .header { font-size: 21.963vw; line-height: .85; }
                .modal-content .header span { font-size: 12.383vw; }

                .modal-content p { margin-top: 2vw !important; font-size: 3.667vw; line-height: 1.25; }

                .modal-form-subscribe { margin-top: 8.967vw; }
                .modal-form-subscribe label { font-size: 2.967vw; }
                .modal-form-subscribe input { font-size: 3.667vw; width: 77vw; height: 12.3667vw; text-align: center; }
                .modal-form-subscribe .field + .field { margin-top: 2.967vw; }

                .modal-content-divider { display: none; }

                .banner-cta { width: 100vw; height: 16.367vw; }
                .banner-cta-txt { font-size: 6.367vw; line-height: 2.75; }
                .banner-content { width: 100vw; padding: 1.967vw 0 4vw; opacity: 0; background-color: var(--color-white); }

                .banner-content .header { font-size: 5.667vw; line-height: .967; margin-top: 2.667vw; }
                .banner-content .body { font-size: 4.367vw; line-height: 1.167; margin-top: 2.667vw; }

                .modal-form-loader,
                .modal-form-loader:after {
                    border-radius: 50%;
                    width: 6.367vw;
                    height: 6.367vw;
                    font-size: 2.967vw;
                }
            }

            @media only screen and (min-width:768px)
            { 

                .modal-close { top: 1.367vw; right: 1.367vw; }
                .modal-close-btn { background-color: transparent; }

                .modal-content { position: relative; width: 68vw; text-align: center; }
                .modal-content > div:nth-child(1) { width: 40vw; }
                .modal-content > div:nth-child(2) { width: 20vw; }

                .modal-content .header-logo { width: 75%; margin-bottom: -1.25vw; }
                .modal-content .header { font-size: 10.156vw; line-height: .85; }
                .modal-content .header span { font-size: 5.677vw; }

                .modal-content p { margin-top: 1vw !important; font-size: 1.667vw; line-height: 1.25; }

                .modal-form-subscribe label { font-size: .75vw; }
                .modal-form-subscribe input { font-size: 1.367vw; width: 20vw; padding: .667vw 1.367vw; text-align: center; }
                .modal-form-subscribe .field + .field { margin-top: .967vw; }

                .modal-content-divider { position: absolute; top: -2vw; left: -5.5vw; display: inline-block; height: 20vw; border-right: .067vw solid var(--color-gray-bright); }

                .banner { background-color: var(--color-white); }
                .banner-cta { width: 32.367vw; height: 5.067vw; }
                .banner-cta-txt { font-size: 1.967vw; line-height: 2.75; }
                .banner-content { width: 66vw; }

                .banner-content .header { font-size: 2.067vw; line-height: .967; margin-top: 0.367vw; }
                .banner-content .body { font-size: 1.337vw; line-height: 1.167; margin-top: 2.367vw; }

                .modal-form-loader,
                .modal-form-loader:after {
                    border-radius: 50%;
                    width: 2.367vw;
                    height: 2.367vw;
                    font-size: 1.367vw;
                }
            }


            .modal-form-loader {
              position: relative;
              text-indent: -9999em;
              border-top: .25em solid rgba(244,255,255, 0.12);
              border-right: .25em solid rgba(244,255,255, 0.12);
              border-bottom: .25em solid rgba(244,255,255, 0.12);
              border-left: .25em solid #FFFFFF;
              -webkit-transform: translateZ(0);
              -ms-transform: translateZ(0);
              transform: translateZ(0);
              -webkit-animation: loader 1.1s infinite linear;
              animation: loader 1.1s infinite linear;
            }
            @-webkit-keyframes loader {
              0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
              }
              100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
              }
            }
            @keyframes loader {
              0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
              }
              100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
              }
            }
          mode: css
        type: item
        enabled: true
    type: item
    enabled: true
  -
    name: 'Component Store'
    collection:
      -
        uid: store
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
      -
        uid: template-functions
        path: /src/lib/components/_stores
        name: template-functions
        ext: js
        content:
          code: |-
            export const TemplateParseTitle = ( _title ) =>
            {
              return `${_title} | Castle Branch`;
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
        uid: nav-href
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
        uid: nav-menu-main
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

            <style lang='postcss'></style>
          mode: htmlmixed
        type: item
        enabled: true
    type: item
    enabled: true
  -
    name: 'Component Section'
    collection:
      -
        uid: section-blue-leader-gray
        path: /src/lib/components
        name: section-blue-leader-gray
        ext: svelte
        content:
          code: |-
            <!-- @html{JSON.stringify( $$slots )} -->
            <section class='section-blue grid grid-stacked {$$props.sectionClass}' {...$$restProps}>
                <div class='place-self-start-center'>
                    <div class='section-leader-gray place-self-center-center text-align-center'>
                        {#if $$slots['leader-h2']}
                            <h2 class='h2'><slot name="leader-h2"></slot></h2>
                        {/if}
                        {#if $$slots['leader-p-1']}
                            <p class='p'><slot name="leader-p-1"></slot></p>
                        {/if}
                        {#if $$slots['leader-p-2']}
                            <p class='p'><slot name="leader-p-2"></slot></p>
                        {/if}
                        {#if $$slots['leader-p-3']}
                            <p class='p'><slot name="leader-p-3"></slot></p>
                        {/if}
                    </div>   
                    {#if $$slots['default']}
                        <slot>aasas</slot>
                    {/if}
                </div>

                {#if $$slots['background-3']}
                    <div>
                        <slot name="background-3"></slot>
                    </div>
                {/if}

                {#if $$slots['background-2']}
                    <div>
                        <slot name="background-2"></slot>
                    </div>
                {/if}

                {#if $$slots['background-1']}
                    <div>
                        <slot name="background-1"></slot>
                    </div>
                {/if}

            </section>

            <style global class='postcss'></style>
          mode: htmlmixed
        type: item
        enabled: true
      -
        uid: section-blue
        path: /src/lib/components
        name: section-blue
        ext: svelte
        content:
          code: |-
            <script>
                /**
                    * Import Svelte Core JS
                */
                
                import { tick, onMount } from 'svelte';

                /**
                    * Import Svelte Components
                */
                           
                /**
                    * Import Custom JS
                */
                
                /**
                    * Export Custom JS
                */

                onMount(async () => {
                    //
                    tick();
                });

            </script>

            <section class='section-blue {$$restProps.class}'>
                <slot></slot>
            </section>

            <style global class='postcss'></style>
          mode: htmlmixed
        type: item
        enabled: true
      -
        uid: section-gray
        path: /src/lib/components
        name: section-gray
        ext: svelte
        content:
          code: |-
            <script>
                /**
                    * Import Svelte Core JS
                */
                
                import { tick, onMount } from 'svelte';

                /**
                    * Import Svelte Components
                */
                           
                /**
                    * Import Custom JS
                */
                
                /**
                    * Export Custom JS
                */

                
                onMount(async () => {
                    //
                    tick();
                });

            </script>

            <section {...$$props}>
                <slot></slot>
            </section>

            <style global class='postcss'></style>
          mode: htmlmixed
        type: item
        enabled: true
      -
        uid: section-white
        path: /src/lib/components
        name: section-white
        ext: svelte
        content:
          code: |-
            <script>
                /**
                    * Import Svelte Core JS
                */
                
                import { tick, onMount } from 'svelte';

                /**
                    * Import Svelte Components
                */
                           
                /**
                    * Import Custom JS
                */
                
                /**
                    * Export Custom JS
                */

                onMount(async () => {
                    //
                    tick();
                });

            </script>

            <section class='section-white {$$restProps.class}'>
                <slot></slot>
            </section>

            <style global class='postcss'></style>
          mode: htmlmixed
        type: item
        enabled: true
    type: item
    enabled: true
  -
    name: 'Component TTPL'
    collection:
      -
        uid: ttpl-sign-up-modal
        path: /src/lib/components
        name: tpl-sign-up-modal
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

                export let active = false;

                onMount(async () => 
                {
                    //
                    tick();
                    
                });

                afterUpdate(async () => 
                {
                    //
                    tick();
                
                });

            </script>


            <svelte:head>
                <script src="/lib/js/modal-subscribe.js"></script>
            </svelte:head>
          mode: htmlmixed
        type: item
        enabled: true
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
development-font:
  -
    uid: gotham-book
    file: tekmountain-com/font/Gotham-Book.otf
    type: item
    enabled: true
  -
    uid: gotham-medium
    file: tekmountain-com/font/Gotham-Medium.otf
    type: item
    enabled: true
updated_by: 3fcfe9a1-6362-444c-8d55-030541dd2f8d
updated_at: 1675040454
---
