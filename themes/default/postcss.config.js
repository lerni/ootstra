// For more information about PostCSS configuration files
// or the correct property values of each plugin,
// check each plugin's documentation.
export default {
  plugins: {
    'postcss-mixins': {},
    'postcss-custom-media': {},
    'postcss-nesting': {},
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
