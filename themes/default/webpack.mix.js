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
mix
  .js('src/js/app.js', 'dist/js')
  .sass('src/scss/editor.scss', 'dist/css')
  .sass('src/scss/style.scss', 'dist/css')
  .sourceMaps(true, 'source-map')
  .copyDirectory('src/webfonts', 'dist/webfonts');

// Glob loading for SASS ("@import dir/**/*.scss")
mix.webpackConfig({
  module: {
    rules: [{ test: /\.scss$/, loader: 'import-glob-loader' }]
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
const sitepath = path.join(__dirname, '/../../');
const parent = path.basename(path.join(sitepath, '../'));
if (parent === 'webroot') {
  mix.browserSync({
    files: ['dist/**/*'],// , 'templates/**/*'
//    proxy: `http://${path.basename(sitepath)}.lodev`
    proxy: `http://localhost:8080`
  });
}

// Remove stale assets from folders which are blindly copied
mix.webpackConfig({
  plugins: [
    new CleanWebpackPlugin(
    {
      cleanOnceBeforeBuildPatterns: [
        'dist/images/**/*',
        '!dist/images/.gitkeep',
        'dist/webfonts/**/*',
        '!dist/webfonts/.gitkeep'
      ],
      cleanStaleWebpackAssets: false,
      verbose: false
    })
  ]
});

// Setup task to copy + compress images
// Setup task to copy + compress images
mix.webpackConfig({
  plugins: [
    new CopyWebpackPlugin(
      {
        patterns: [
          {
            from: 'src/images', to: 'dist/images',
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
