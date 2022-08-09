// this script loads the YouTube iframe-api, gets all instances and adds enable jsapi & origin-URL to the src-URL and prevents showing related videos
// after initializing the API it adds playing-mode & paused-mode "div.embed"

if (document.querySelectorAll('iframe[src*="youtube.com"]').length) {
  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

window.BaseUrl = function() {
  url = window.location.protocol +'//'+ window.location.hostname;
  if (window.location.port != 80) {
    url = url + ':' + window.location.port;
  }
  return(url);
}

window.onYouTubeIframeAPIReady = function() {
  document.querySelectorAll('iframe[src*="youtube.com"]').forEach( function (v, k) {
  id = 'embeddedvideoiframe' + k;
  if (!v.getAttribute('id')) { v.setAttribute('id', id) }

    var url = new URL(v.getAttribute("src"));
    url.searchParams.append('enablejsapi', 1);
    url.searchParams.append('origin', BaseUrl());
    url.searchParams.append('rel', 0);

    // if (v.parentElement.classList.contains('embed-hero')) {
    //   url.searchParams.append('disablekb', 1);
    //   url.searchParams.append('fs', 0);
    //   url.searchParams.append('modestbranding', 1);
    //   url.searchParams.append('controls', 0);
    //   url.searchParams.append('mute', 1);
    //   url.searchParams.append('showinfo', 0);
    //   url.searchParams.append('autoplay', 1);
    //   url.searchParams.append('loop', 1);
    //   url.searchParams.append('autohide', 2);
    //   url.searchParams.append('iv_load_policy', 3);
    //   url.searchParams.append('cc_load_policty', 0);
    //   v.setAttribute('src', url.href);
    //   new YT.Player(id, {
    //     events: {
    //       'onStateChange': onPlayerStateChange,
    //       'onReady': function(e) {
    //         e.target.mute();
    //         e.target.playVideo();
    //         onPlayerReady(e);
    //       }
    //     }
    //   });
    // } else {
    v.setAttribute('src', url.href);
    new YT.Player(id, {
      events: {
        'onStateChange': onPlayerStateChange,
        'onReady': onPlayerReady
      }
    });

  });
}

onPlayerStateChange = function(event) {
  if (event.data == 1) {
    event.target.i.parentNode.classList.remove('paused-mode')
    event.target.i.parentNode.classList.add('playing-mode')
  }
  if (event.data == 2) {
    event.target.i.parentNode.classList.remove('playing-mode')
    event.target.i.parentNode.classList.add('paused-mode')
  }
  // if (event.target.getPlayerState() == 2) {
  //   event.target.playVideo();
  // }
}

function onPlayerReady(event)
{
  if (event.data == null) {
    event.target.i.parentNode.classList.add('paused-mode')
  }
}
