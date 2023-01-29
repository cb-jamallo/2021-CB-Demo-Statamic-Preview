export const prerender = true;
export const trailingSlash = 'always';
export const ssr = false;

/** @type {import('./$types').LayoutLoad} */
export async function load({ fetch, params, url }) 
{
    let data = null;
  	let dataWebsiteReport = null;
  	let dataWebsiteControllerReport = null;
    let dataWebsiteBuildReport = null;
  
  	if ( url.searchParams.get('websiteReport')  === 'true' )
	{ 
		data = await fetch( '/lib/data/website/websiteReport.js' );
  		dataWebsiteBuild = await data.json();
	  	
	}
  	
    if ( url.searchParams.get('websiteControllerReport') === 'true' )
	{ 
		data = await fetch( '/lib/data/website/websiteControllerReport.js' );
  		dataWebsiteBuildReport = await data.json();
	}
  
  	if ( url.searchParams.get('websiteBuildReport')  === 'true' )
	{ 
		data = await fetch( '/lib/data/website/websiteBuildReport.js' );
  		dataWebsiteBuildReport = await data.json();
	}
    
  	return { dataWebsiteReport, dataWebsiteBuildReport, dataWebsiteControllerReport };
  
}