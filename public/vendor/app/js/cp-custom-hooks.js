'use strict'

let schema = null;

const statamicHookPayload = ( $_ARGS ) => {

    return schema = ( $_ARGS.payload ) ? $_ARGS.payload.values : {};
}

const statamicHookReject = ( $_ARGS ) => {

    Statamic.$progress.complete('base-entry-publish-form');
    return $_ARGS.message;
}





Statamic.$hooks.on('entry.saving', (resolve, reject, payload) => {
    
    statamicHookPayload( { 'payload': payload });
    resolve();

});


Statamic.$hooks.on('entry.saved', (resolve, reject, payload) => {
    
    resolve();

});


Statamic.$hooks.on('entry.publishing', (resolve, reject, payload) => {
    
    
    if ( !schema )
    {
        reject( statamicHookReject( { message: 'Publishing Aborted: Required schema missing or un-saved.' } ) );
    } 
    
    if ( schema?.target === 'none' )
    {
        reject( statamicHookReject( { message: 'Publishing Aborted: A publishing target is required.' } ) );
    } 

    if ( schema?.target === 'production' )
    {
        if (confirm('CAUTION: You have chosen to publish this page to production. Are you sure?')) {
            // Continue with the save action.
            resolve( statamicHookReject( { message: 'Publishing Started.' } ) );
        } else {
            // Cancel the save action. You can provide the error message.
            reject( statamicHookReject( { message: 'Publishing Aborted.' } ) );
        }
    }

    resolve();

});


Statamic.$hooks.on('entry.published', (resolve, reject, payload) => {
    
    resolve('Build Complete.');
    
    var t = setTimeout(() => {
        console.log('Published Now Refresh');
        console.log(payload);
        console.log(payload.response);
        console.log(payload.response.data);
        console.log(JSON.stringify(payload.response));
        window.location.reload( window.location + '#' + window.location.hash);
        clearTimeout(t);
    }, 10);

});