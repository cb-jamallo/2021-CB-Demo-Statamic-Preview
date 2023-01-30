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
          	
        	let swiperInitWhatDrivesUs = ( _swiper ) => {
        		
        		console.log( _swiper.activeIndex )
        	  	const swiperSlideDetails = document.querySelectorAll('.what-drives-us-detail');

        		const swiperSlideDetailHide = () =>
        		{
        			swiperSlideDetails.forEach( ( _item, _itemIndex ) => {
        				_item.style.display = 'none';
        				_item.style.opacity = 0;
        		   	});
        		 }

        	   const swiperSlideDetailShow = ( _i ) =>
        	   {

        			swiperSlideDetails.forEach( ( _item, _itemIndex ) => {

        		   	_item.style.display = 'none';
        		   	_item.style.opacity = 0;

        		   	if ( _itemIndex + 1 === _swiper.activeIndex ||
        			   	_itemIndex + 1 === 1 && _swiper.activeIndex > swiperSlideDetails.length ||
        			   	( _itemIndex + 1 === swiperSlideDetails.length && _swiper.activeIndex === 0 )
        			)
        		   	{
        				_item.style.display = 'initial';
        				_item.style.opacity = 1;
        		   	}
        		 });
        	   }

        	   _swiper.on('slideChange', function ( _slide ) {
        			console.log('slide changed', _swiper.activeIndex );
        		 	swiperSlideDetailShow( _swiper.activeIndex );
        	   });

        	   swiperSlideDetailHide();
        	   swiperSlideDetailShow(1);
        	}
        	 
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
updated_at: 1675051400
---
