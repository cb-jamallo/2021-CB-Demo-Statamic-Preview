'use strict'

/* 
    Statamic Resources
    =============================

    - Hooks: https://statamic.dev/extending/hooks#prerequisites

*/


let schema = null;



const statamicHookPayload = ( _collection ) => 
{
    return schema = {
        'collection' : _collection.collection,
        'payload': _collection.values
    }
}

const statamicHookReject = ( _message ) => 
{
    Statamic.$progress.complete('base-entry-publish-form');
    return _message;
}

const statamicHookResolve = ( _message ) => 
{
    console.log( _message );
    console.dir( schema.payload );
    Statamic.$progress.complete('base-entry-publish-form');
    return _message;
}

const statamicHookStart = ( _message ) => 
{
    console.log( _message );
    console.dir( schema.payload );
    return _message;
}


Statamic.$hooks.on('entry.saving', (  resolve, reject, payload  ) => {
    
    statamicHookPayload( payload );

    resolve( statamicHookStart( `Save Start: ${ payload.collection }` ) );

});


Statamic.$hooks.on('entry.saved', ( resolve, reject ) => {
    
    resolve( statamicHookResolve( `Save Complete: ${ schema.collection }` ) );

});


Statamic.$hooks.on('entry.publishing', ( resolve, reject ) => {
    
    
    if ( !schema )
    {
        reject( statamicHookReject( `Publish Abort: Required schema: ${ schema.collection }` ) );
    } 
    
    if ( schema?.target === 'none' )
    {
        reject( statamicHookReject( 'Publish Abort: A publishing target is required.' ) );
    } 

    if ( schema?.target === 'production' )
    {
        if (confirm('CAUTION: You have chosen to publish this page to production. Are you sure?')) {
            // Continue with the save action.
            resolve( statamicHookStart( `Publish Start: ${ schema.collection} `) );
        } else {
            // Cancel the save action.
            reject( statamicHookReject( `Publish Abort: ${ schema.collection} ` ) );
        }
    }

    resolve( statamicHookStart( `Publish Start: ${ schema.collection} `) );

});


Statamic.$hooks.on('entry.published', ( resolve, reject, payload ) => {
    
    schema.payload = payload.response;
    resolve( statamicHookStart( `Publish Complete: ${ schema.collection} `) );

    let t = setTimeout(() => {
        console.log( `Publish Refresh: ${ schema.collection} ` );
        window.location.reload( window.location + '#' + window.location.hash);
        clearTimeout( t );
    }, 500 );

});