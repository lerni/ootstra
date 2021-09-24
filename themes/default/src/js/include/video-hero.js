$(document).ready(function() {
  ResizeHeroVideoIframe();
});

$(window).on('resize', function(){
  ResizeHeroVideoIframe();
});

function ResizeHeroVideoIframe() {
  elementhero = $('.elementhero').first();
  herowidth = $(elementhero).width();
  aimedheight = herowidth*.5625;
  $(elementhero).find('iframe').attr('height', aimedheight + 'px')
}
