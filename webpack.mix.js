const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

module.exports = {
    plugins: {
        "postcss-import": {},
        "tailwindcss/nesting": "postcss-nesting",
        tailwindcss: {},
        autoprefixer: {},
    },
};

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/cliente.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        require("postcss-import"),
        require("tailwindcss"),
    ]);

// cliente
mix.postCss("resources/css/cliente.css", "public/css/cliente", [
    require("postcss-import"),
    require("tailwindcss"),
]);

mix.copy(
    "node_modules/jquery/dist/jquery.min.js",
    "public/plugins/jquery/jquery.min.js"
);
mix.copy(
    "node_modules/tw-elements/dist/js/index.min.js",
    "public/plugins/tw-elements/index.min.js"
);

mix.sass("resources/css/style.scss", "public/css").options({
    postCss: [
        require("postcss-import"),
        require("tailwindcss/nesting", "postcss-nesting"),
        require("tailwindcss"),
    ],
});

if (mix.inProduction()) {
    mix.version();
}

// mix.webpackConfig({
//     stats: {
//         children: true,
//     },
// });
