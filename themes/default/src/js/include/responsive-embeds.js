import responsiveEmbeds from '@micropackage/responsive-embeds';

const embeds = document.querySelectorAll('iframe[src*="vimeo.com"], iframe[src*="youtube.com"]');

responsiveEmbeds( embeds, {
  watch: true,
  wrapClass: 'embed'
} );
