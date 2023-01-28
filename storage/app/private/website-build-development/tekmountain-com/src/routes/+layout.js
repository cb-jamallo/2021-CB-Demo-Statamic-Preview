export const prerender = true;
export const trailingSlash = 'always';
export const ssr = false;


export async function load( fetch, params, route, url, parent ) 
{
  
    const response = await fetch( '/lib/data/websiteBuild.json' );
  	const responseJson = await response.json();
	console.log( responseJson );
 	
  /*
  return {
  	props: responseJson
  }
  */
}