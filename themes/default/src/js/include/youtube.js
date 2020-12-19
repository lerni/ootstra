// this script loads the YouTube iframe-api, gets all instances and adds enable jsapi & origin-URL to the src-URL and prevents showing related videos
// after initializing the API it adds playing-mode & paused-mode "div.embed"

if ($('[src^="https://www.youtube.com/"]').length) {
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
    return this.src.indexOf('https://www.youtube.com/') == 0
  }).each( function (k, v) {
    if (!this.id) { this.id='embeddedvideoiframe' + k }
    id = this.id;

    var url = new URL($('#'+id).attr("src"));
    url.searchParams.append('enablejsapi', 1);
    url.searchParams.append('origin', BaseUrl());
    url.searchParams.append('rel', 0);

    $('#'+id).attr("src", url);
    new YT.Player(id, {
      events: {
        'onStateChange': onPlayerStateChange,
        'onReady': function(e) {
          // e.target.mute();
          // e.target.playVideo();
        }
      }
    });
  });
}

onPlayerStateChange = function(event) {
  if (event.data == YT.PlayerState.PLAYING) {
    $('#' + event.target.h.id).closest("div.embed").removeClass("paused-mode");
    $('#' + event.target.h.id).closest("div.embed").addClass("playing-mode");
  }
  if (event.data == YT.PlayerState.PAUSED) {
    $('#' + event.target.h.id).closest("div.embed").removeClass("playing-mode");
    $('#' + event.target.h.id).closest("div.embed").addClass("paused-mode");
  }
}
