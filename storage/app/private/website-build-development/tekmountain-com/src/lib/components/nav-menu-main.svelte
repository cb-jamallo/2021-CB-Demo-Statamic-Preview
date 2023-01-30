<script>

    /* SVELTE/KIT IMPORTS */
    import { tick, onMount, afterUpdate } from 'svelte';
    import { page } from '$app/stores';

	/* CUSTOM IMPORTS */
  
  	/* CUSTOM JS */
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
        
        /* 
		navMainResize();
        window.dispatchEvent(new Event('resize'));
		*/
    }

    const navMainResize = () =>
    {
        window.addEventListener('resize', ( _event ) => 
        {
            /*
			if ( window.outerWidth <= 768) return navMainMobile();
            return navMainInitDesktop();
			*/
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

                /*
				if ( parent.classList.contains('expanded') )
                {
				*/
                    parentLink.setAttribute('aria-expanded', String(parent.classList.contains('expanded')));
                    parentButton.setAttribute('aria-expanded', String(parent.classList.contains('expanded')));
                /*
				} 
                else 
                {
                   parentLink.setAttribute('aria-expanded', 'false');
                   parentButton.setAttribute('aria-expanded', 'false');
                }
				*/
                _event.preventDefault();
                _event.stopPropagation();

            });
        });
    }

    let navMainActive = () => {
        
        let navMainActiveClass = 'nav-main-a-active';
        let navMainPath =  $page.url.pathname;
        let navMainPathParts = $page.url.pathname.split('/').filter( _n => _n );
        let navMainPathParts1 = navMainPathParts[0];

        
        const menuLinks = document.querySelectorAll('.nav-main-a');

              menuLinks.forEach( ( _link, _index ) => {

                if ( ( navMainPath === '/' && _index === 0) || navMainPathParts1?.includes( _link.innerText.toLowerCase().split(' ').join('-') ) ) 
                {
                    _link.classList.add( navMainActiveClass );
                }
                else
                {
                    _link.classList.remove( navMainActiveClass );
                }

              });
    }

    onMount(async () => {
        
        tick();

        navMainInit();
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