// For more information about PostCSS configuration files
// or the correct property values of each plugin,
// check each plugin's documentation.
export default {
  plugins: {
    '@csstools/postcss-global-data': {
      files: ['./src/css/_custom-media.css'],
    },
    'postcss-mixins': {
      mixinsFiles: ['./src/css/_mixins.css'],
    },
    'postcss-custom-media': {},
    'postcss-nesting': {
      // Use the 2021 edition so simple descendant nesting unrolls flat
      // (the 2024-02 spec mandates :is() wrapping for & semantics).
      // Combined with noIsPseudoSelector, output is plain flat CSS.
      edition: '2021',
      noIsPseudoSelector: true,
    },
    'autoprefixer': {},
    'postcss-inline-svg': {
      paths: ['./src/images/svg/']
    },
    ...(process.env.NODE_ENV === 'production' && {
      cssnano: {
        preset: ['default', {
          discardComments: {
            removeAll: true
          },
          normalizeWhitespace: true,
          discardUnused: true,
          mergeRules: true,
          reduceIdents: true
        }]
      }
    })
  }
}
