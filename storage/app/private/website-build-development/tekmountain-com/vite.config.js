// https://stackoverflow.com/questions/70709987/how-to-load-environment-variables-from-env-file-using-vite

import { sveltekit } from '@sveltejs/kit/vite';
import { defineConfig, loadEnv } from 'vite';

/** @type {import('vite').UserConfig} */
export default ({ mode }) => {
    
    // Extends 'process.env.*' with VITE_*-variables from '.env.(mode=production|development)'
    process.env = {...process.env, ...loadEnv(mode, process.cwd())};

    console.log( mode );
    console.dir( {...process.env} );
    return defineConfig({
        plugins: [sveltekit()]
    }); 
};
