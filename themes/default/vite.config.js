import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import {ViteImageOptimizer} from 'vite-plugin-image-optimizer';
import {readdirSync} from 'node:fs';
import {join} from 'node:path';

// Auto-include every SVG under src/images/svg/ as a Vite input so that
// `viteAsset('src/images/svg/<name>.svg')` calls in .ss templates resolve
// via the manifest. Drop a new SVG in the folder and it just works.
const svgInputs = readdirSync(join(import.meta.dirname, 'src/images/svg'))
  .filter((f) => f.endsWith('.svg'))
  .map((f) => `src/images/svg/${f}`);

export default defineConfig({
  base: '/_resources/themes/default/dist/',
  publicDir: '/dist/',
  build: {
    sourcemap: process.env.NODE_ENV !== 'production',
  },
  css: {
    devSourcemap: true,
  },
  plugins: [
    laravel({
      input: [
        'src/css/style.css',
        'src/css/footer.css',
        'src/css/editor.css',
        'src/css/blog.css',
        'src/css/contentsections.css',
        'src/css/fancy.css',
        'src/css/swiper.css',
        'src/css/gallery.css',
        'src/css/logo.css',
        'src/css/metaoverviewpage.css',
        'src/css/perso.css',
        'src/css/persocfa.css',
//        'src/css/perso-simple.css',
        'src/css/cards.css',
//        'src/css/jobs.css',
//        'src/css/counter.css',
//        'src/css/instafeed.css',
        'src/css/textimage.css',
        'src/css/localvideo.css',
        'src/js/app.js',
        'src/js/fancy.js',
        'src/js/swiper.js',
        'src/js/countup.js',
        'src/js/flip.js',
        'src/js/infiniteGrid.js',
        'src/js/userform-url-params.js',
        // SVGs referenced from .ss templates via viteAsset() — auto-globbed
        // so any new file in src/images/svg/ is emitted with a manifest entry.
        ...svgInputs,
      ],
      publicDirectory: '../default',
      buildDirectory: 'dist',
      refresh: [
        'templates/**/*.ss',
      ],
    }),

    ViteImageOptimizer({
      test: /\.svg$/i,
      exclude: /spritemap\.svg$/i,
    }),
  ],
  server: {
    // Respond to all network requests
    host: "0.0.0.0",
    port: 5173,
    strictPort: true,
    // Defines the origin of the generated asset URLs during development, this must be set to the
    // Vite dev server URL and selected Vite port. In general, `process.env.DDEV_PRIMARY_URL` will
    // give us the primary URL of the DDEV project, e.g. "https://test-vite.ddev.site". But since
    // DDEV can be configured to use another port (via `router_https_port`), the output can also be
    // "https://test-vite.ddev.site:1234". Therefore we need to strip a port number like ":1234"
    // before adding Vites port to achieve the desired output of "https://test-vite.ddev.site:5173".
    origin: `${process.env.DDEV_PRIMARY_URL.replace(/:\d+$/, "")}:5173`,
    // Configure CORS securely for the Vite dev server to allow requests from *.ddev.site domains,
    // supports additional hostnames (via regex). If you use another `project_tld`, adjust this.
    cors: {
      origin: /https?:\/\/([A-Za-z0-9\-\.]+)?(\.ddev\.site)(?::\d+)?$/,
    },
  },
})
