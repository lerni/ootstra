// this script loads the YouTube iframe-api, gets all instances and adds enable jsapi & origin-URL to the src-URL
// after initiating the API it adds playing-mode & paused-mode to the iframes

if ($('[src^="https://www.youtube.com/"]').length) {
	var tag = document.createElement('script');
	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

window.BaseUrl = function() {
	return(window.location.protocol +'//'+ window.location.hostname);
}

function onYouTubeIframeAPIReady() {
	$('iframe').filter(function(){
		return this.src.indexOf('https://www.youtube.com/') == 0
	}).each( function (k, v) {
		if (!this.id) { this.id='embeddedvideoiframe' + k }
		id = this.id;
		url = $('#'+id).attr("src") + '&enablejsapi=1&origin=' + BaseUrl() + '&rel=0';
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

var done = false;
function onPlayerStateChange(event) {
	if (event.data == YT.PlayerState.PLAYING && !done) {
		console.log(event.target.a);
		$(event.target.a).closest("div.video-box").removeClass("paused-mode");
		$(event.target.a).closest("div.video-box").addClass("playing-mode");
	}
	if (event.data == YT.PlayerState.PAUSED && !done) {
		console.log('pause');
		$(event.target.a).closest("div.video-box").removeClass("playing-mode");
		$(event.target.a).closest("div.video-box").addClass("paused-mode");
	}
}