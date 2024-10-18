const mix = require('laravel-mix');

// Compile TailwindCSS from app.css and output to resources/css/style.css
mix.postCss('resources/css/app.css', 'resources/css/style.css', [
    require('tailwindcss'),
]);

// Optional: Enable versioning for cache busting in production
if (mix.inProduction()) {
    mix.version();
}
