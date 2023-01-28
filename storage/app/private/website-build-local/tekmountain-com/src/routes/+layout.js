export const prerender = true;
export const trailingSlash = 'always';
export const ssr = false;


export async function load( fetch, params, route, url, parent ) 
{
  
  const response = await fetch( '/lib/data/websiteBuild.json' );
  const responseJson = await res.json();
 
  return
  {
	test: responseJson
  };
}