// this script loads the YouTube iframe-api, gets all instances and adds enable jsapi & origin-URL to the src-URL and prevents showing related videos
// after initializing the API it adds playing-mode & paused-mode "div.embed"

if ($('[src^="https://www.youtube.com/"], [src^="https://www.youtube-nocookie.com/"]').length) {
  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

window.BaseUrl = function() {
  return(window.location.protocol +'//'+ window.location.hostname);
}

window.onYouTubeIframeAPIReady = function() {
  $('iframe').filter(function(){
    return this.src.indexOf('https://www.youtube-nocookie.com/') || this.src.indexOf('https://www.youtube.com/')
  }).each( function (k, v) {
    if (!this.id) { this.id='embeddedvideoiframe' + k }
    id = this.id;

    var url = new URL($('#'+id).attr("src"));
    url.searchParams.append('enablejsapi', 1);
    url.searchParams.append('origin', BaseUrl());
    url.searchParams.append('rel', 0);

    $('#'+id).attr("src", url);
    if ($(this).parent().hasClass('embed-hero')) {
      url.searchParams.append('disablekb', 1);
      url.searchParams.append('fs', 0);
      url.searchParams.append('modestbranding', 1);
      url.searchParams.append('controls', 0);
      url.searchParams.append('mute', 1);
      url.searchParams.append('showinfo', 0);
      url.searchParams.append('autoplay', 1);
      url.searchParams.append('loop', 1);
      url.searchParams.append('autohide', 2);
      url.searchParams.append('iv_load_policy', 3);
      url.searchParams.append('cc_load_policty', 0);
      new YT.Player(id, {
        events: {
          'onStateChange': onPlayerStateChange,
          'onReady': function(e) {
            e.target.mute();
            e.target.playVideo();
            onPlayerReady(e);
          }
        }
      });
    } else {
      new YT.Player(id, {
        events: {
          'onStateChange': onPlayerStateChange
        }
      });
    }
  });
}

onPlayerStateChange = function(event) {
  if (event.data == YT.PlayerState.PLAYING) {
    $('#' + event.target.h.id).closest("div.embed, div.embed-hero").removeClass("paused-mode");
    $('#' + event.target.h.id).closest("div.embed, div.embed-hero").addClass("playing-mode");
  }
  if (event.data == YT.PlayerState.PAUSED) {
    $('#' + event.target.h.id).closest("div.embed, div.embed-hero").removeClass("playing-mode");
    $('#' + event.target.h.id).closest("div.embed, div.embed-hero").addClass("paused-mode");
  }
  if (event.data === YT.PlayerState.ENDED) {
    event.target.playVideo();
  }
}

function onPlayerReady(event)
{
  overlayer = $('#' + event.target.h.id).parent().parent().find(".overlayer, div.txt");
  player = event.target;

  $(overlayer).on('click', function(e) {
    if (player.getPlayerState() == 1) {
        player.pauseVideo();
    }
    if (player.getPlayerState() == 2) {
      player.playVideo();
    }
  });
}
