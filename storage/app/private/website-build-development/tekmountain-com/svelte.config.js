import adapterAuto from '@sveltejs/adapter-auto';
import adapterStatic from '@sveltejs/adapter-static';
import adapterNetlify from '@sveltejs/adapter-netlify';

let adapter = null;
let adapterKit = null;

if ( process.env.VITE_ENV === 'local' ) 
{
    adapter = adapterStatic;
    adapterKit = {
        adapter: adapter({
            fallback: '404.html'
        }),
	}
}
else
{
    adapter = adapterNetlify;
    adapterKit = {
        adapter: adapter({
            edge: false,
            split: false,
            fallback: '404.html'
        })
    };
    
}

/** @type {import('@sveltejs/kit').Config} */
const config = {
	kit: adapterKit,
};

console.log( `NODE_ENV = ${ process.env.NODE_ENV }`);
console.log( `VITE_ENV = ${ process.env.VITE_ENV }`);

export default config;
