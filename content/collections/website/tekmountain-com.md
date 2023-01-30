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
            import Store from '$lib/components/_stores/store';

        	/* CUSTOM IMPORTS */

            import TekMountainLogo from "$lib/components/tekmountain-logo.svelte";
            import NavAHref from "$lib/components/nav-ahref.svelte";
            import NavMenuMain from "$lib/components/nav-menu-main.svelte";

            import TTPLSignup from "$lib/components/ttpl-sign-up.svelte";
          
          	/* CUSTOM JS */
          
        	let ttpl = false;
          
        	onMount(async () => {	
        	  	tick();
        		$Store.ttpl = ( window.location.href.includes( 'ttpl-study' ) );
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

         
        <section tabindex="0" class="grid grid-2--lg grid-2-alt--sm grid-col-gap-4 padding-x-4 padding-top-12--sm margin-top-8--lg">
          <div class="margin-top-4--sm place-self-center-center">
            <h3 class="h3">What drives us?</h3>
            <div class='grid grid-stacked'>
              <p class="p z-1 what-drives-us-detail">At tekMountain, innovation transforms insight into the breakthrough ideas that drive dynamic change. Progress is measured through meaningful solutions that are influential in real markets &mdash; and delivered at significant scale for critical impact. For us, innovation never stops, because it is never done.</p>
              <p class="p z-2 what-drives-us-detail">People are not commodities. We seek to deeply understand the challenges an opportunities of each individual, working to make certain their dreams, desires, competencies, skills, passions and accomplishments define them on their own terms. By placing a truly unique individual at the center of their professional journey, we are able to address problems through clear solutions that are as unique as they are.</p>
              <p class="p z-3 what-drives-us-detail">Data and insight are the lifeblood of innovation, but they must be collected and used responsibly. Research drive us and leads us. The forces and factors that ignite every new idea, analysis, or development are all born of the same commitment to data and insight. tekMountain insight is freely shared for the common good of the industries we serve.</p>
            </div>
          </div>
          <div class="grid grid-stacked">
            <div class="z-2">
              <div id="swiper-what-drives-us" class="swiper" data-swiper={JSON.stringify({ 
                'id': 'whatDrivesUs',
                'mobile': { 'config' : { 'direction':'horizontal','loop':true,'autoHeight':true,'slidesPerView': 1,'spaceBetween':0,'scrollbar': false, navigation: { nextEl: '.swiper-button-next-unique', prevEl: '.swiper-button-prev-unique' } } },
                'desktop': { 'config' : { 'direction':'horizontal','loop':true,'autoHeight':true,'slidesPerView': 1,'spaceBetween':0,'scrollbar': false, navigation: { nextEl: '.swiper-button-next-unique', prevEl: '.swiper-button-prev-unique' } } }
              })}>
                <div class="swiper-wrapper">
                  <div class="swiper-slide swiper-slide-square">
                     <picture class="picture-object-fit-cover">
                      <source srcset="/lib/images/home/what-drives-us/innovation-mobile.jpg, /lib/images/home/what-drives-us/innovation-mobile@2x.jpg 2x" media="(max-width: 767px)">
                        <source srcset="/lib/images/home/what-drives-us/innovation-desktop.jpg, /lib/images/home/what-drives-us/innovation-desktop@2x.jpg 2x" media="(min-width: 768px)">
                      <img src="/lib/images/home/what-drives-us/innovation-mobile.jpg" alt="">
                    </picture>
                  </div>
                  <div class="swiper-slide swiper-slide-square">
                    <picture class="picture-object-fit-cover">
                      <source srcset="/lib/images/home/what-drives-us/individual-at-the-center-mobile.jpg, /lib/images/home/what-drives-us/individual-at-the-center-mobile@2x.jpg 2x" media="(max-width: 767px)">
                        <source srcset="/lib/images/home/what-drives-us/individual-at-the-center-desktop.jpg, /lib/images/home/what-drives-us/individual-at-the-center-desktop@2x.jpg 2x" media="(min-width: 768px)">
                      <img src="/lib/images/home/what-drives-us/individual-at-the-center-mobile.jpg" alt="">
                    </picture>
                  </div>
                  <div class="swiper-slide swiper-slide-square">
                    <picture class="picture-object-fit-cover">
                      <source srcset="/lib/images/home/what-drives-us/data-insight-mobile.jpg, /lib/images/home/what-drives-us/data-insight-mobile@2x.jpg 2x" media="(max-width: 767px)">
                      <source srcset="/lib/images/home/what-drives-us/data-insight-desktop.jpg, /lib/images/home/what-drives-us/data-insight-desktop@2x.jpg 2x" media="(min-width: 768px)">
                      <img src="/lib/images/home/what-drives-us/data-insight-mobile.jpg" alt="">
                    </picture>
                  </div>
                </div>
                <picture class="swiper-button-prev-unique"><img src='/lib/images/home/what-drives-us/icon-carousel-arrow-left.svg' alt='Carousel previious left control button'></picture>
                <picture class="swiper-button-next-unique"><img src='/lib/images/home/what-drives-us/icon-carousel-arrow-right.svg' alt='Carousel next slide control button'></picture>
              </div>
            </div>
            <div class="background-pattern z-1"></div>
          </div>
        </section>


        <section tabindex="0" class="grid margin-top-12--sm margin-top-8--lg">
          <div class="padding-x-4--sm padding-x-6--lg place-self-start-center text-align-center--lg">
            <h3 class="h3">Industries We Serve</h3>
            <p class="p">Innovation truly works when access to market is significant.</p>
          </div>
          <div class='swiper swiper-full' data-swiper={JSON.stringify({
            'mobile':  { 'config' : { 'direction': 'horizontal', 'loop': false, 'autoHeight': true, 'slidesPerView': 1.2, 'spaceBetween': 10, 'scrollbar': false  } }, 
            'desktop': { 'config' : { 'direction': 'horizontal', 'loop': false, 'autoHeight': true, 'slidesPerView': 3.3, 'spaceBetween': 15, 'scrollbar': true  } }
          })}>
            <div class="swiper-wrapper padding-top-3--sm padding-top-2--lg padding-bottom-1--lg">
              <div class="swiper-slide flip grid grid-stacked">
                <div class="flip-front z-2 grid grid-stacked">
                    <picture class='flip-front-icon z-3 place-self-end-end'>
                        <img src='/lib/images/icon-arrow-flip.svg' />
                    </picture>
                    <h4 class="z-2 flip-front-header place-self-center-center">Healthcare</h4>
                    <picture class="z-1">
                        <source srcset="/lib/images/home/industries-we-serve/tekmountain-healthcare-mobile.jpg, /lib/images/home/industries-we-serve/tekmountain-healthcare-mobile@2x.jpg 2x" media="(max-width: 767px)">
                        <source srcset="/lib/images/home/industries-we-serve/tekmountain-healthcare-desktop.jpg, /lib/images/home/industries-we-serve/tekmountain-healthcare-desktop@2x.jpg 2x" media="(min-width: 768px)">
                        <img src="/lib/images/home/industries-we-serve/tekmountain-healthcare-mobile.jpg" alt="...">
                    </picture>
                </div>
                <div class="flip-back z-1 grid">
                  <p class="flip-back-p-large place-self-center-center">Students performing clinicals at <strong class="flip-back-strong-large">94%</strong> of U.S. hospitals</p>
                </div>
              </div>
              <div class="swiper-slide flip grid grid-stacked">
                <div class="flip-front z-2 grid grid-stacked">
                    <picture class='flip-front-icon z-3 place-self-end-end'>
                        <img src='/lib/images/icon-arrow-flip.svg' />
                    </picture>
                  <h4 class="z-2 flip-front-header place-self-center-center">Higher<br> Education</h4>
                  <picture class="z-1">
                    <source srcset="/lib/images/home/industries-we-serve/tekmountain-highered-mobile.jpg, /lib/images/home/industries-we-serve/tekmountain-highered-mobile@2x.jpg 2x" media="(max-width: 767px)">
                    <source srcset="/lib/images/home/industries-we-serve/tekmountain-highered-desktop.jpg, /lib/images/home/industries-we-serve/tekmountain-highered-desktop@2x.jpg 2x" media="(min-width: 768px)">
                    <img src="/lib/images/home/industries-we-serve/tekmountain-highered-mobile.jpg" alt="...">
                  </picture>
                </div>
                <div class="flip-back z-1 grid">
                  <p class="flip-back-p-large place-self-center-center"><strong class="flip-back-strong-large">18,700</strong> health professions programs</p>
                </div>
              </div>
              <div class="swiper-slide flip grid grid-stacked">
                <div class="flip-front z-2 grid grid-stacked">
                    <picture class='flip-front-icon z-3 place-self-end-end'>
                        <img src='/lib/images/icon-arrow-flip.svg' />
                    </picture>
                  <h4 class="z-2 flip-front-header place-self-center-center">Nursing<br> Students</h4>
                  <picture class="z-1">
                    <source srcset="/lib/images/home/industries-we-serve/tekmountain-students-mobile.jpg, /lib/images/home/industries-we-serve/tekmountain-students-mobile@2x.jpg 2x" media="(max-width: 767px)">
                    <source srcset="/lib/images/home/industries-we-serve/tekmountain-students-desktop.jpg, /lib/images/home/industries-we-serve/tekmountain-students-desktop@2x.jpg 2x" media="(min-width: 768px)">
                    <img src="/lib/images/home/industries-we-serve/tekmountain-students-mobile.jpg" alt="...">
                  </picture>
                </div>
                <div class="flip-back z-1 grid">
                  <p class="flip-back-p-large place-self-center-center"><strong class="flip-back-strong-large">70%</strong> of our Nation's Healthcare Students</p>
                </div>
              </div>
              <div class="swiper-slide flip grid grid-stacked">
                <div class="flip-front z-2 grid grid-stacked">
                    <picture class='flip-front-icon z-3 place-self-end-end'>
                        <img src='/lib/images/icon-arrow-flip.svg' />
                    </picture>
                  <h4 class="z-2 flip-front-header place-self-center-center">Associations</h4>
                  <picture class="z-1">
                    <source srcset="/lib/images/home/industries-we-serve/tekmountain-associations-mobile.jpg, /lib/images/home/industries-we-serve/tekmountain-associations-mobile@2x.jpg 2x" media="(max-width: 767px)">
                    <source srcset="/lib/images/home/industries-we-serve/tekmountain-associations-desktop.jpg, /lib/images/home/industries-we-serve/tekmountain-associations-desktop@2x.jpg 2x" media="(min-width: 768px)">
                    <img src="/lib/images/home/industries-we-serve/tekmountain-associations-mobile.jpg" alt="...">
                  </picture>
                </div>
                <div class="flip-back z-1 grid">
                  <p class="flip-back-p-large place-self-center-center">Well established partnerships with the Nation's most significant associations</p>
                </div>
              </div>
            </div>
            <div class='swiper-scrollbar'></div>
          </div>
        </section>


        <style global lang="scss">

          :root {

            --what-drives-us-swiper-prev-width: 12vw;
            --what-drives-us-swiper-prev-left: 0;
            --what-drives-us-swiper-prev-bottom: 0;
            --what-drives-us-swiper-next-width: 12vw;
            --what-drives-us-swiper-next-left: 13vw;
            --what-drives-us-swiper-next-bottom: 0;

            --invested-copy-type-size: var(--type-size);


            --bio-figcaption-top: 81vw;

            --bio-figcaption-child-padding: .75vw 0 0;

            --bio-full-figcaption-margin: 0;
            --bio-full-figcaption-padding: 0;

            --bio-full-name-type-size: var(--type-size);
            --bio-full-name-type-line-height: 1.1;

            --bio-org-link-type-size: 3.238vw;
            --bio-org-link-type-line-height: 1.1;

            --bio-credentials-type-size: 3.238vw;
            --bio-credentials-type-line-height: 1.1;

            --bio-title-type-size: 3.238vw;
            --bio-title-type-line-height: 1.1;
          }

          @media only screen and (min-width: 768px)
          {
            :root {

                --what-drives-us-swiper-prev-width: 5vw;
                --what-drives-us-swiper-prev-left: 0;
                --what-drives-us-swiper-prev-bottom: 0;
                --what-drives-us-swiper-next-width: 5vw;
                --what-drives-us-swiper-next-left: 5.75vw;
                --what-drives-us-swiper-next-bottom: 0;

                --invested-copy-type-size: 1.5vw;

                --bio-figcaption-top: 28.5vw;

                --bio-figcaption-child-padding: .25vw 0 0;

                --bio-full-figcaption-margin: 0;
                --bio-full-figcaption-padding: 0;

                --bio-full-name-type-size: var(--type-size);
                --bio-full-name-type-line-height: 1.1;

                --bio-credentials-type-size: 1.25vw;
                --bio-credentials-type-line-height: 1.1;

                --bio-org-link-type-size: 1.25vw;
                --bio-org-link-type-line-height: 1.1;

                --bio-title-type-size: 1.25vw;
                --bio-title-type-line-height: 1.1;
            }

          }


          .what-drives-us-detail { display: none; opacity: 0; }

          .swiper-button-prev-unique,
          .swiper-button-next-unique { position: absolute; z-index: 2; bottom: 0; }

          .swiper-button-prev-unique { z-index: 3; width: var(--what-drives-us-swiper-prev-width); left: var(--what-drives-us-swiper-prev-left); bottom: var(--what-drives-us-swiper-prev-bottom); }
          .swiper-button-next-unique { z-index: 2; width: var(--what-drives-us-swiper-next-width); left: var(--what-drives-us-swiper-next-left); bottom: var(--what-drives-us-swiper-next-bottom); }

          
          .invested-copy { font-size: var(--invested-copy-type-size); }

          .bio-figcaption { position: absolute; top: var(--bio-figcaption-top); }
          
          .bio-figcaption > * { display: block; }

          .bio-figcaption > *:not(:nth-child(1)) { padding: var(--bio-figcaption-child-padding); }

          .bio-full-name {

            font-size: var(--bio-full-name-type-size);
            line-height: var(--bio-full-name-type-line-height);
            font-weight: var(--type-weight-medium);
          }

          .bio-credentials {
            font-size: var(--bio-credentials-type-size);
            line-height: var(--bio-credentials-type-line-height);
            font-weight: var(--type-weight-medium);
          }

          .bio-org-link {
            font-size: var(--bio-org-link-type-size);
            line-height: var(--bio-org-link-type-line-height);
            font-weight: var(--bio-org-link-type-weight);
          }

          .bio-title {
            font-size: var(--bio-title-type-size);
            line-height: var(--bio-title-type-line-height);
            font-weight: var(--bio-title-type-weight);
          }
          

        </style>
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
updated_at: 1675049675
---
