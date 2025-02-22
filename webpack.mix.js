const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('node_modules/ionicons/dist/ionicons', 'public/js/ionicons')
    .version()
    .webpackConfig({
        resolve: {
            fallback: {
                "buffer": require.resolve("buffer/"), // Polyfill for buffer
                "process": require.resolve("process/browser") // Polyfill for process
            }
        }
    });