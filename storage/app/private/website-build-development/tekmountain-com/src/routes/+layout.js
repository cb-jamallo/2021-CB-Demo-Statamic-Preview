export const prerender = true;
export const trailingSlash = 'always';
export const ssr = false;

/** @type {import('./$types').LayoutLoad} */
export async function load({ fetch, params }) 
{
    const response = await fetch( '/lib/data/websiteBuild.json' );
  	const responseJson = await response.json();
	// console.log( responseJson );
    return { responseJson };
  
}