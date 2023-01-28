export const prerender = true;
export const trailingSlash = 'always';
export const ssr = false;


export async function load( fetch, params, route, url, parent ) {
  
  const f = await fetch( '/lib/data/websiteBuild.json' )
    .then(response => response.json())
    .then(response => console.log(JSON.stringify(response)));
  
  return
  {
	test: f
  };
}