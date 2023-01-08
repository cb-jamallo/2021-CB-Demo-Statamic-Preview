---
id: 877f5383-5090-41b0-9046-577e20632717
blueprint: website_controller
title: TekMountain.com
protocol: https
development-host:
  -
    base: local.tekmountain.com
    version: v-1-0-0
    package: _website-controller-host-packages/sveltekit-static-adapter-v-1-0-0-rc.zip
    type: item
    enabled: true
    protocol: https
    sitemap:
      -
        active: true
        uid: sitemap
        path: /static
        frequency: monthly
        priority: '05'
        type: item
        enabled: true
    robotTxt:
      -
        active: true
        uid: robots
        path: /static
        content:
          code: |-
            User-agent: *
            Allow: /

            Sitemap: [websiteBuild.environment.host.canonical]/sitemap.xml
          mode: htmlmixed
        type: item
        enabled: true
    humanTxt:
      -
        active: true
        uid: human
        path: /static
        content:
          code: |-
            # Example: https://humanstxt.org/Standard.html
            Webmaster: Joe Mallory
            Email: jamallo@castlebranch.com
            Site: [websiteBuild.environment.host.canonical]
            Location: Wilmington, North Carolina, USA.
          mode: shell
        type: item
        enabled: true
    securityTxt:
      -
        active: true
        uid: security
        path: /static
        content:
          code: |-
            # Example: https://securityTxt.org
            Contact: mailto: security.[websiteBuild.environment.host.canonical].com
            Expires: 2042-01-01T05:00:00.000Z
          mode: htmlmixed
        type: item
        enabled: true
development-link:
  -
    uid: favicon
    content: '<link rel="icon" href="/static/lib/image/favicon.png" />'
    type: item
    enabled: true
  -
    uid: disabled-test
    content: '<link rel=''test'' href=''test'' />'
    type: item
    enabled: false
development-meta:
  -
    uid: charset
    content: '<meta name=''charset'' content=''utf-8''>'
    type: item
    enabled: true
  -
    uid: viewport
    content: '<meta name=''viewport'' content=''width=device-width, initial-scale=1.0''>'
    type: item
    enabled: true
  -
    uid: robots
    content: '<meta name=''robots'' content=''noindex,nofollow''>'
    type: item
    enabled: true
  -
    uid: description
    content: '<meta name=''description'' content=''Tekmountain...''>'
    type: item
    enabled: true
development-template:
  -
    uid: default
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
      mode: htmlmixed
    script:
      code: null
      mode: htmlmixed
    body:
      code: '[website.template.body]'
      mode: htmlmixed
    type: item
    enabled: true
    path: /src/routes
development-misc:
  -
    uid: App
    as: html
    content:
      code: |-
        <!DOCTYPE html>
        <html lang="en">
        	<head>
        		<meta charset="utf-8" />
        		<link rel="icon" href="%sveltekit.assets%/favicon.png" />
        		<meta name="viewport" content="width=device-width" />
        		%sveltekit.head%
        	</head>
        	<body>
        		<div>%sveltekit.body%</div>
        	</body>
        </html>
      mode: htmlmixed
    type: item
    enabled: true
target: 'null'
development-code:
  -
    uid: app-html
    name: app
    as: html
    component: false
    content:
      code: |-
        <!DOCTYPE html>
        <html lang="en">
        	<head>
        	  <title>TekMountain.com</title>
        	  <base href='[websiteBuild.environment.host.base]'>
          	  <link rel='canonical' href='[websiteBuild.environment.host.canonical]'>
        	  %sveltekit.head%
        	</head>
        	<body>
        		%sveltekit.body%
        	</body>
        </html>
      mode: htmlmixed
    type: item
    enabled: true
    ext: html
  -
    uid: htaccess
    path: /static
    name: .
    ext: htaccess
    content:
      code: |-
        # ---------------------
        # Handle Rewrites
        # ---------------------
        RewriteEngine on
        ErrorDocument 404 /404.html
      mode: shell
    type: item
    enabled: true
  -
    uid: +error-svelte
    path: /src/routes
    name: +error
    ext: svelte
    component: false
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
    name: +layout
    ext: js
    component: false
    content:
      code: |-
        export const prerender = true;
        export const ssr = false;
      mode: htmlmixed
    type: item
    enabled: true
    path: /src/routes
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
development-script:
  -
    uid: test-script-1
    type: item
    enabled: true
    file: tekmountain-com/script/test-script-1.js
  -
    uid: test-script-2
    file: tekmountain-com/script/test-script-2.js
    type: item
    enabled: true
  -
    uid: test-script-child-1
    file: tekmountain-com/script/child/test-script-child-1.js
    type: item
    enabled: false
development-document:
  -
    uid: test-document
    file: tekmountain-com/document/TekMountainWebsite-Confluence-Export-Plan-Write-up.pdf
    type: item
    enabled: true
development-style:
  -
    uid: test-style-1
    file: tekmountain-com/style/test-style-1.scss
    type: item
    enabled: true
  -
    uid: test-style-2
    file: tekmountain-com/style/test-style-2.scss
    type: item
    enabled: true
replicate: 'null'
updated_by: 3fcfe9a1-6362-444c-8d55-030541dd2f8d
updated_at: 1673007034
---
