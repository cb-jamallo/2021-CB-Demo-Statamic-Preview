import { writable } from 'svelte/store';

let Store = writable({

    headerLogo: true,
    ttpl: true,
    disqus: false

});

export default Store;