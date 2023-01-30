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
      code: '<title>TekMountain Home</title>'
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
            
          /**
          * Import Svelte Core JS
          */
          
          import { tick, onMount, afterUpdate } from 'svelte';

          import { StoreEnvVars } from "$lib/components/_stores/store-env-vars";
          import { TemplateParseTitle } from "$lib/components/_stores/template-functions";
          // import { page } from '@sveltejs/kit/app/stores.js' SSR REQUIRED FOR THIS TO FUNCTION

          /**
           * Import Svelte Components
          */


          /**
          * Import Custom JS
          */
          
          /**
          * Export Custom JS
          */

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

          onMount(async () => 
          {
              //
              tick();
          });

          afterUpdate(async () => 
          {
              //
              tick();

              let temp = setInterval( () => {

                if ( window.swiperInstances );
                clearInterval(temp);
                swiperInitWhatDrivesUs(  window.swiperInstances[0] );

              }, 10);
              
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


        <!--
        <section tabindex="0" class="grid margin-bottom-12--sm margin-top-12--sm margin-top-8--lg margin-bottom-8--lg">
            <div class="padding-x-4--sm padding-x-6--lg text-align-center--lg">
              <h3 class="h3">Leadership<br class="br--sm"> &amp; Partnership</h3>
              <p>Get to know us and our partners.</p>
            </div>
            <div class="swiper swiper-full swiper-full-4up" data-swiper={JSON.stringify({ 
              'mobile': { 'config' : { 'direction':'horizontal','loop':false,'autoHeight':true,'slidesPerView':1.2,'spaceBetween':10,'scrollbar':false } },
              'desktop': { 'config' : { 'destroy':true } }
            })}>
              <div class="swiper-wrapper grid--lg grid-3--lg grid-col-gap-1--lg grid-row-gap-5--lg padding-x-4--lg margin-top-3--sm padding-bottom-9--sm margin-top-2--lg padding-bottom-4--lg">
                <figure class="bio swiper-slide flip grid grid-stacked">
                  <figcaption class="bio-figcaption place-self-start-start z-3">
                    <span class="bio-full-name">Robyn Begley</span>
                    <span class="bio-credentials">DNP, RN, NEA-BC, FAAN</span>
                    <a class="bio-org-link" href="https://www.aonl.org/about/leadership-team/chief-executive-officer" target="_blank">AONL.org</a>
                  </figcaption>
                  <div class="flip-front z-2">
                    <picture>
                      <img src="/lib/images/home/leadership-bios/leadership-bio-robyn-begley.jpg" alt="">
                    </picture>
                  </div>
                  <div class="flip-back z-1 grid">
                    <div class="place-self-center-center">
                      <p class="bio-title">CEO of the American Organization of Nursing Leadership (AONL)</p>
                      <p class="bio-title">Chief Nursing Officer, SVP Workforce, American Hospital Association (AHA)</p>
                    </div>
                  </div>
                </figure>
                <figure class="bio swiper-slide flip grid grid-stacked">
                  <figcaption class="bio-figcaption place-self-start-start z-3">
                    <span class="bio-full-name">Donna Meyer</span>
                    <span class="bio-credentials">MSN, RN, ANEF, FAADN, FAAN</span>
                    <a class="bio-org-link" href="https://oadn.org/people/donna-meyer/" target="_blank">OADN.org</a>
                  </figcaption>
                  <div class="flip-front z-2">
                    <picture>
                      <img src="/lib/images/home/leadership-bios/leadership-bio-donna-meyer.jpg" alt="">
                    </picture>
                  </div>
                  <div class="flip-back z-1 grid">
                    <div class="place-self-center-center">
                      <p class="bio-title">CEO of the Organization of Associate Degree Nursing (OADN)</p>
                    </div>
                  </div>
                </figure>
                <figure class="bio swiper-slide flip grid grid-stacked">
                  <figcaption class="bio-figcaption place-self-start-start z-3">
                    <span class="bio-full-name">Dr. Deborah Trautman</span>
                    <span class="bio-credentials">PhD, RN, FAAN</span>
                    <a class="bio-org-link" href="https://www.aacnnursing.org/News-Information/Spokesperson-Bios/Deborah-Trautman" target="_blank">AACNNURSING.org</a>
                  </figcaption>
                  <div class="flip-front z-2">
                    <picture>
                      <img src="/lib/images/home/leadership-bios/leadership-bio-deborah-trautman.jpg" alt="">
                    </picture>
                  </div>
                  <div class="flip-back z-1 grid">
                    <div class="place-self-center-center">
                      <p class="bio-title">President and CEO of the American Association of Colleges of Nursing (AACN)</p>
                    </div>
                  </div>
                </figure>
                <figure class="bio swiper-slide flip grid grid-stacked">
                  <figcaption class="bio-figcaption place-self-start-start z-3">
                    <span class="bio-full-name">Pamela Thompson</span>
                    <span class="bio-credentials">MS, RN, CENP, FAAN</span>
                    <a class="bio-org-link" href="https://www.linkedin.com/in/pamthompsonrn" target="_blank">AONL.org</a>
                  </figcaption>
                  <div class="flip-front z-2">
                    <picture>
                      <img src="/lib/images/home/leadership-bios/leadership-bio-pamela-thompson.jpg" alt="">
                    </picture>
                  </div>
                  <div class="flip-back z-1 grid">
                    <div class="place-self-center-center">
                      <p class="bio-title">Retired, CEO Emeritus of the American Organization for Nursing Leadership (AONL)</p>
                    </div>
                  </div>
                </figure>
                <figure class="bio swiper-slide flip grid grid-stacked">
                  <figcaption class="bio-figcaption place-self-start-start z-3">
                    <span class="bio-full-name">Dr. Amy Garcia</span>
                    <span class="bio-credentials">DNP, MSN, RN</span>
                    <a class="bio-org-link" href="https://www.kumc.edu/agarcia5.html" target="_blank">KUMC.edu</a>
                  </figcaption>
                  <div class="flip-front z-2">
                    <picture>
                      <img src="/lib/images/home/leadership-bios/leadership-bio-amy-garcia.jpg" alt="">
                    </picture>
                  </div>
                  <div class="flip-back z-1 grid">
                    <div class="place-self-center-center">
                      <p class="bio-title">Associate Clinical Professor and Director of Practice at the University of Kansas School of Nursing</p>
                      <p class="bio-title">Principal Investigator,<br> TTPL Study</p>
                    </div>
                  </div>
                </figure>
                <figure class="bio swiper-slide flip grid grid-stacked">
                  <figcaption class="bio-figcaption place-self-start-start z-3">
                    <span class="bio-full-name">Dr. Nelda Godfrey</span>
                    <span class="bio-credentials">PhD, RN, ACNS-BC, FAAN, ANEFF</span>
                    <a class="bio-org-link" href="https://www.kumc.edu/ngodfrey.html" target="_blank">KUMC.edu</a>
                  </figcaption>
                  <div class="flip-front z-2">
                    <picture>
                      <img src="/lib/images/home/leadership-bios/leadership-bio-nelda-godfrey.jpg" alt="">
                    </picture>
                  </div>
                  <div class="flip-back z-1 grid">
                    <div class="place-self-center-center">
                      <p class="bio-title">Associate Dean for Innovative Partnerships and Practice at the University of Kansas School of Nursing</p>
                      <p class="bio-title">Professor, University of Kansas School of Nursing.</p>
                      <p class="bio-title">Co-Investigator,<br> TTPL Study</p>
                    </div>
                  </div>
                </figure>
                <figure class="bio swiper-slide flip flip-none grid grid-stacked">
                    <figcaption class="bio-figcaption place-self-start-start z-3">
                        <span class="bio-full-name">Brett Martin</span>
                    </figcaption>
                    <div class="flip-front z-2">
                        <picture>
                        <img src="/lib/images/home/leadership-bios/leadership-bio-brett-martin.jpg" alt="">
                        </picture>
                    </div>
                </figure>
                <figure class="bio swiper-slide flip flip-none grid grid-stacked">
                    <figcaption class="bio-figcaption place-self-start-start z-3">
                        <span class="bio-full-name">Greg Larnder</span>
                    </figcaption>
                    <div class="flip-front z-2">
                        <picture>
                        <img src="/lib/images/home/leadership-bios/leadership-bio-greg-larnder.jpg" alt="">
                        </picture>
                    </div>
                </figure>
                <figure class="bio swiper-slide flip flip-none grid grid-stacked">
                    <figcaption class="bio-figcaption place-self-start-start z-3">
                        <span class="bio-full-name">Mike Flack</span>
                    </figcaption>
                    <div class="flip-front z-2">
                        <picture>
                        <img src="/lib/images/home/leadership-bios/leadership-bio-mike-flack.jpg" alt="">
                        </picture>
                    </div>
                </figure>
              </div>
            </div>
        </section>
        -->

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
replicate:
  - 'null'
local-image:
  -
    uid: image
    file: tekmountain-com/image/AdobeStock_233158786_Preview.jpeg
    type: item
    enabled: true
  -
    uid: image2
    file: tekmountain-com/image/AdobeStock_291317597_Preview.jpeg
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
updated_by: 3fcfe9a1-6362-444c-8d55-030541dd2f8d
updated_at: 1675041854
---
