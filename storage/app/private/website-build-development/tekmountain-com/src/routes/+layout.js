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
  
  	if ( url.searchParams.get('websiteReport') )
	{ 
		response = await fetch( '/lib/data/website/websiteReport.js' );
  		dataWebsiteBuild = await response.json();
	  	
	}
  	
    if ( url.searchParams.get('websiteControllerReport') )
	{ 
		response = await fetch( '/lib/data/website/websiteControllerReport.js' );
  		dataWebsiteBuildReport = await response.json();
	}
  
  	if ( url.searchParams.get('websiteBuildReport') )
	{ 
		response = await fetch( '/lib/data/website/websiteBuildReport.js' );
  		dataWebsiteBuildReport = await response.json();
	}
  
    const urlSearchParams = url.searchParams;
  	
  
    return { urlSearchParams, dataWebsiteReport, dataWebsiteBuildReport, dataWebsiteControllerReport };
  
}