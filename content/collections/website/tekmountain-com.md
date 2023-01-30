---
id: 8fe0f1f3-c0b7-4b5e-9483-a18722504c5d
blueprint: website
title: Tekmountain.com
title_alias: Home
development-template:
  -
    uid: default
    path: src/routes
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
      code: null
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
      code: |-
        <script>
        	'use strict';

            /* SVELTE/KIT IMPORTS */
        	import { tick, onMount, afterUpdate } from 'svelte';
            
        	/* CUSTOM IMPORTS */
        	import Store from '$lib/components/_stores/store';
          	import { StoreEnvVars } from "$lib/components/_stores/store-env-vars";
          	import { TemplateParseTitle } from "$lib/components/_stores/template-functions";
          
          	/* CUSTOM JS */
        	 
        	onMount(async () => {	
        	  	tick();
        	}); 
          
        	afterUpdate(async () => 
        	{
        		tick();
        		
        		/*
        		let temp = setInterval( () => {
        			if ( window.swiperInstances );
            			clearInterval(temp);
            			swiperInitWhatDrivesUs(  window.swiperInstances[0] );
        		}, 10);
        		*/
          	});
          
        </script>

        <svelte:head>
          <title>{ TemplateParseTitle( `TekMountain` ) }</title>
          <meta name='description' content='...' />
        </svelte:head>


        <section tabindex="0" class="section-1 grid grid-stacked">
            <div class="z-2 grid place-self-center-center--sm place-self-start-center--lg padding-x-4--sm padding-x-4--lg">
                <h1 class="h1 z-1 ">
                    <span class="h1-small">We see people</span>
                    <span>Differently</span>
                </h1>
                <p class="hp"><span>Including 70% of the Nation's Nursing Students.</span></p>
                <!-- <p class="hp"><span>We Know What 70% of the Nation's Emerging Nurses are Thinking.</span></p> -->
                <!-- <a class="z-2 place-self-end-center margin-top-2--lg" href="/what-we-do"><button class="button-primary--lg" tabindex="-1">Learn More</button></a> -->
            </div>
            <div class="z-1">
            <picture class="picture-object-fit-cover z-1">
                <source srcset="/lib/images/home/hero/home-hero-collage-mobile.jpg, /lib/images/home/hero/home-hero-collage-mobile@2x.jpg 2x" media="(max-width: 767px)">
                <source srcset="/lib/images/home/hero/home-hero-collage-desktop.jpg, /lib/images/home/hero/home-hero-collage-desktop@2x.jpg 2x" media="(min-width: 768px)">
                <img src="/lib/images/home/hero/home-hero-collage-mobile.jpg" alt="Collage of diverse nursing student portraits">
            </picture>
            </div>
        </section>

        <section tabindex="0" class="section-blue grid grid-stacked margin-top-4--sm margin-top-4--lg">
          <div class="z-1 place-self-start-center">
            <div class="section-leader-gray place-self-center-center text-align-center--lg">
              <h2 class="h2">We're Invested and Connected</h2>
              <p class="p">tekMountain is embedded in the important work of deeply understanding and addressing some of healthcare and higher education's most difficult problems.</p>
            </div>   
            <div class="grid grid-3--lg grid-col-gap-2--lg padding-x-4--sm padding-x-4--lg padding-bottom-4--sm padding-bottom-4--lg text-align-left--lg">
              <div class="invested-columns margin-top-4--sm margin-top-4--lg">
                <h3 class="h3 invested-header">Knowledge</h3>
                <p class='invested-copy'>Ask. Listen. Learn. Share. Guide.</p>
                <p class='invested-copy'>It's a proven approach that has led to countless industry firsts. We place the individual at the center of the knowledge ecosystem - both as a contributor and a beneficiary producing guidance and insight that is shared with all stakeholders allowing them to leverage our experience and knowledge. What we think always starts with you.</p>
              </div>
              <div class="margin-top-4--sm margin-top-4--lg">
                <h3 class="h3 invested-header">Network</h3>
                <p class='invested-copy'>Being vested in the industries, communities, and individuals we serve has a profound impact on solving real problems. We rely upon our large footprint and deep roots to help all stakeholders become an influential voice in our collective future. That network is the difference between seeing change happen and leading it.</p>
              </div>
              <div class="margin-top-4--sm margin-top-4--lg">
                <h3 class="h3 invested-header">Insights</h3>
                <p class='invested-copy'>Data analytics is the voice of our network. It separates truth from opinion, and cuts through the clutter to reveal clarity. 360-degree insight is the result of industry-wide, data-led intelligence that connects data and connects the dots.</p>
              </div>
            </div>
          </div>
        </section>
      mode: htmlmixed
    type: item
    enabled: true
replicate: 'null'
local-image:
  -
    uid: image
    type: item
    enabled: true
  -
    uid: image2
    type: item
    enabled: true
local-template:
  -
    uid: default
    path: src/routes
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
      code: '<title>TekMountain.com | [websiteController.domain.title]</title>'
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
      code: 'Welcome to TekMountain....'
      mode: htmlmixed
    type: item
    enabled: true
development-image:
  -
    uid: home-hero-collage-desktop-1x
    file: tekmountain-com/image/home/hero/home-hero-collage-desktop.jpg
    type: item
    enabled: true
  -
    uid: home-hero-collage-desktop-2x
    file: tekmountain-com/image/home/hero/home-hero-collage-desktop@2x.jpg
    type: item
    enabled: true
  -
    uid: home-hero-collage-mobile-1x
    file: tekmountain-com/image/home/hero/home-hero-collage-mobile.jpg
    type: item
    enabled: true
  -
    uid: home-hero-collage-mobile-2x
    file: tekmountain-com/image/home/hero/home-hero-collage-mobile@2x.jpg
    type: item
    enabled: true
  -
    uid: icon-carousel-arrow-right
    file: tekmountain-com/image/home/industries-we-serve/icon-carousel-arrow-right.svg
    type: item
    enabled: true
  -
    uid: tekmountain-associations-desktop-1x
    file: tekmountain-com/image/home/industries-we-serve/tekmountain-associations-desktop.jpg
    type: item
    enabled: true
  -
    uid: tekmountain-associations-desktop-2x
    file: tekmountain-com/image/home/industries-we-serve/tekmountain-associations-desktop@2x.jpg
    type: item
    enabled: true
target: 'null'
updated_by: 3fcfe9a1-6362-444c-8d55-030541dd2f8d
updated_at: 1675051856
---
