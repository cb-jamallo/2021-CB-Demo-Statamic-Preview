---
id: ccc0db71-e906-4743-bac8-0996ec068287
blueprint: website_controller
title: tekmountain.com
development-host:
  -
    base: tekmountain-com-dev.netlify.app
    protocol: https
    version: v-1-0-0
    package: _website-controller-host-packages/sveltekit-static-adapter-v-1-0-0-rc.zip
    sitemap:
      -
        uid: sitemap
        path: src/static
        frequency: monthly
        priority: '05'
        type: item
        enabled: true
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
    uid: env-development
    name: .
    ext: env-development
    content:
      code: |-
        # NODE VARS..

        # VITE VARS
        VITE_ENV=development
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
        	  <link rel='canonical' href='[websiteController.domain.host.base]'>
        	  %sveltekit.head%
        	</head>
        	<body>
        	  	Yahtzee!!!
        		%sveltekit.body%
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
        export const ssr = false;
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

          /* Component imports */
          //...

          /* Global Stores */
          const websiteNavigation = [websiteBuild.navigation.json];
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
    enabled: true
updated_by: 3fcfe9a1-6362-444c-8d55-030541dd2f8d
updated_at: 1673246951
---
