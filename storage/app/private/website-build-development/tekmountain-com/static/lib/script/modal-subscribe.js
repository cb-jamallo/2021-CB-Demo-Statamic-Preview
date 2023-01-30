'use struct';


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
    console.log('banner animation called', formBanner.classList);
    let blocks = [ 
        document.querySelector('.banner .header'),
        document.querySelector('.banner .body'),
        document.querySelector('.banner-content')
    ];
    
    let blocksLoop = 0;

    /*
	Slide-up banner
    */
  	anime({
        targets: [formBanner],
        opacity: [0, 1],
        delay: 1750,
        duration: 250,
        loop: false,
        begin: ( _anim ) =>
        {
            if ( window.outerWidth <= 767 ) blocks[1].style.opacity = 0;
            console.log('begin banner animation....', formBanner.classList);
            formBanner.classList.remove('.sr-only'); 
            console.log('begin banner animation....', formBanner.classList);
        },
        complete: ( _anim ) =>
        {
            formBanner.style.opacity = .5;
            formBanner.classList.remove('sr-only'); 
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

/** 
Form modal open 
*/
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

/** 
Form modal close 
*/
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

/** 
Form serialization 
*/
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

document.addEventListener('DOMContentLoaded', () =>
{
    formBanner = document.querySelector('.banner');
    
    formModal = document.querySelector('.modal');
    formModalCloseBtn = document.querySelector('.modal-close-btn');

    form = document.querySelector('.modal-form-subscribe');
    formLoader = document.querySelector('.modal-form-loader');
    formSubmit = document.querySelector('.modal-form-submit');
    formThankYou = document.querySelector('.modal-form-thank-you');
    formError = document.querySelector('.modal-form-error');

    /** 
	Enable form submit 
	*/
    form.addEventListener('submit', ( _event ) =>
    {
        _event.preventDefault();
        _event.stopPropagation();
    
        /*
		Submit Gate Test: Honeypot as inputis empty.
		*/
        if ( document.querySelector('input[name=_confirm]').value !== '' ) return;
    
        /*
		Submit Gate Test:  Honeypot as checked.
        */
	  	if ( document.querySelector('input[name=_confirm2]').checked ) return;
    
        formLoader.classList.remove('hidden');
        formSubmit.value = '';
        
        let formData = formDataSerialize( _event.target );
            formData.site = 'tekmountain.com'
            formData.form = 'TekMountain Newsletter Signup';
            formData.url = window.location.href;
        
        /* fetch('https://submit-form.com/Y6utqnzM', // Test Form */
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
    
    /* Enable form submit ability after minimal input */
    let formEnable = ( _event ) =>
    {   

        /* Submit Gate Test: Ensure proper user event types triggered to test required validity */
        if ( _event.type !== 'pointerdown' && ( _event.type !== 'keydown' && _event?.key?.toLowerCase() !== 'tab' ) ) return;
        
        console.log( 'banner', _event.type, formSubmit, formBanner )
    
        /* Submit Gate Test: Required fields validated for enabling submit button */
        if ( !document.querySelector('input[name=name]').checkValidity() ||
             !document.querySelector('input[name=email]').checkValidity() ||
             !document.querySelector('input[name=company]').checkValidity() ) return;
        
        formSubmit.removeAttribute("disabled");
    }
    
    form.addEventListener( 'pointerdown', formEnable, false);
    form.addEventListener( 'keydown', formEnable, false);
    
    /* Automate honeypot add after delay... */
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

});