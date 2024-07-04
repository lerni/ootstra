const mix = require('laravel-mix');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const CSSMQPacker = require('mqpacker');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const imageminMozjpeg = require('imagemin-mozjpeg');
const imageminPngquant = require('imagemin-pngquant');
const imageminSvgo = require('imagemin-svgo');
const path = require('path');
const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');

// Options for existing plugins
mix.options({
  cssNano: {
    mergeRules: true,
    reduceIdents: { keyframes: false },
    zindex: false
  },
  postCss: [
//     CSSMQPacker({ sort: true }),
    require('postcss-inline-svg'),
    require('cssnano')({
      preset: 'default',
    }),
  ],
  processCssUrls: false
});

// Set up base tasks
let productionSourceMaps = false;
mix
  .js('src/js/app.js', 'dist/js')
  .js('src/js/fancy.js', 'dist/js')
  .js('src/js/swiper.js', 'dist/js')
  .js('src/js/countup.js', 'dist/js')
  .sass('src/scss/blog.scss', 'dist/css')
  .sass('src/scss/contentsections.scss', 'dist/css')
  .sass('src/scss/editor.scss', 'dist/css')
  .sass('src/scss/fancy.scss', 'dist/css')
  .sass('src/scss/swiper.scss', 'dist/css')
  .sass('src/scss/footer.scss', 'dist/css')
  .sass('src/scss/gallery.scss', 'dist/css')
  .sass('src/scss/logo.scss', 'dist/css')
  .sass('src/scss/metaoverviewpage.scss', 'dist/css')
  .sass('src/scss/perso.scss', 'dist/css')
  .sass('src/scss/persocfa.scss', 'dist/css')
//  .sass('src/scss/perso-simple.scss', 'dist/css')
  .sass('src/scss/style.scss', 'dist/css')
  .sass('src/scss/cards.scss', 'dist/css')
//  .sass('src/scss/jobs.scss', 'dist/css')
  .sass('src/scss/counter.scss', 'dist/css')
  .sass('src/scss/textimage.scss', 'dist/css')
  .sass('src/scss/localvideo.scss', 'dist/css')
  .sourceMaps(productionSourceMaps, 'source-map')
  .copyDirectory('src/fonts', 'dist/fonts');

// Glob loading for SASS ("@import dir/**/*.scss")
mix.webpackConfig({
  module: {
    rules: [{ test: /\.scss$/, loader: 'glob-import-loader' }]
  }
});

// Update babel loader to ensure code imported from node_modules is transpiled
// See https://github.com/JeffreyWay/laravel-mix/issues/1906#issuecomment-455241790
// mix.webpackConfig({
//   module: {
//     rules: [
//       {
//         test: /\.jsx?$/,
//         exclude: /(bower_components)/,
//         use: [{
//           loader: 'babel-loader',
//           options: Config.babel()
//         }]
//       }
//     ]
//   }
// });

// SVG sprite generation
// mix.webpackConfig({
//   plugins: [
//     new SVGSpritemapPlugin('src/images/icons/**/*.svg', {
//       output: { filename: 'dist/images/icons.svg' },
//       sprite: { prefix: 'icon-' }
//     })
//   ]
// });

// Configure browsersync
const url = process.env.DDEV_HOSTNAME;
mix.browserSync({
  files: [
    'dist/**/*',
    'templates/**/*'
  ],
  ignore: [
    'dist/images/.gitkeep',
    'dist/fonts/.gitkeep'
  ],
  proxy: 'localhost',
  host: url,
  open: false,
  ui: false
});

// Remove stale assets from folders which are blindly copied
mix.webpackConfig({
  plugins: [
    new CleanWebpackPlugin(
    {
      cleanOnceBeforeBuildPatterns: [
        'dist/images/**/*',
        '!dist/images/.gitkeep',
        'dist/fonts/**/*',
        '!dist/fonts/.gitkeep'
      ],
      cleanStaleWebpackAssets: false,
      verbose: false
    })
  ],
  stats: {
    children: true,
  }
});

// Setup task to copy + compress images
mix.webpackConfig({
  plugins: [
    new CopyWebpackPlugin(
      {
        patterns: [
          {
            from: 'src/images',
            to: 'dist/images',
            globOptions: {
              dot: true,
              gitignore: true,
              ignore: ['*.DS_Store', 'icons/.gitkeep', 'icons/**/*.svg']
            },
          }
        ]
      }
    ),
    new ImageminPlugin(
      {
        test: (path) => {
          // Don't re-compress sprite
          if (path === 'dist/images/icons.svg') {
            return false;
          }
          const regex = new RegExp(/\.(jpe?g|png|gif|svg)$/i);
          return regex.test(path);
        },
        plugins: [
          new ImageminPlugin({
            disable: process.env.NODE_ENV !== 'production', // Disable during development
            mozjpeg: {
              quality: 80
            },
            pngquant: {
              quality: '95-100'
            },
            svgo: {
              plugins: [{ removeViewBox: false }]
            }
          })
        ]
      }
    )
  ]
});

// Stop mix from generating a license file called app.js.LICENSE.txt
mix.options({
  terser: {
    extractComments: false,
  }
});
