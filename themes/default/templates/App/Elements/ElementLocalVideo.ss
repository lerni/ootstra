<% require themedCSS("dist/css/localvideo") %>
<% include App/Includes/ElementTitle %>
<% if $LocalMP4Video || $LocalMP4VideoSmall || $Image %>
	<div class="video-wrapper<% if $Autoplay %> play<% end_if %><% if $Autoplay || $Mute %> muted<% end_if %>" id="video-wrapper-{$LocalVideo.ID}">
		<video onclick="togglePlay()" id="video-{$LocalVideo.ID}" poster="{$Image.FocusFillMax(1230,692).Convert('webp').URL}" width="100%" <% if $Autoplay %> autoplay<% end_if %><% if $Autoplay || $Mute %> muted<% end_if %><% if $Loop %> loop<% end_if %> playsinline>
			<% if $LocalMP4Video %><source src="{$LocalMP4Video.Link}" media="(min-width: 800px)" type="video/mp4"><% end_if %>
			<% if $LocalMP4VideoSmall %><source src="{$LocalMP4VideoSmall.Link}" type="video/mp4"><% end_if %>
		</video>
		<div class="play-wrapper">
			<button type="button" class="play" aria-label="play" onclick="togglePlay()"></button>
		</div>
		<button type="button" class="mute" aria-label="mute" onclick="toggleMute()">
			<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2">
				<path id="cross" d="M16.28,8.22c-0.142,-0.152 -0.341,-0.239 -0.549,-0.239c-0.411,0 -0.75,0.339 -0.75,0.75c0,0.208 0.087,0.407 0.239,0.549l2.72,2.72l-2.72,2.72c-0.152,0.142 -0.239,0.341 -0.239,0.549c0,0.411 0.339,0.75 0.75,0.75c0.208,-0 0.407,-0.087 0.549,-0.239l2.72,-2.72l2.72,2.72c0.142,0.152 0.341,0.239 0.549,0.239c0.411,-0 0.75,-0.339 0.75,-0.75c-0,-0.208 -0.087,-0.407 -0.239,-0.549l-2.72,-2.72l2.72,-2.72c0.129,-0.139 0.201,-0.322 0.201,-0.511c0,-0.412 -0.338,-0.75 -0.75,-0.75c-0.189,-0 -0.372,0.072 -0.511,0.201l-2.72,2.72l-2.72,-2.72Z"/>
				<path id="wave" d="M18.718,4.23c0.291,-0.29 0.769,-0.29 1.06,0c4.296,4.296 4.296,11.26 0,15.556c-0.139,0.13 -0.322,0.202 -0.511,0.202c-0.412,-0 -0.75,-0.339 -0.75,-0.75c-0,-0.19 0.072,-0.373 0.201,-0.512c1.781,-1.781 2.783,-4.199 2.783,-6.718c-0,-2.519 -1.002,-4.937 -2.783,-6.718c-0.291,-0.291 -0.291,-0.769 0,-1.06Zm-2.476,3.535c2.328,2.328 2.327,6.158 -0,8.485c-0.139,0.13 -0.322,0.202 -0.511,0.202c-0.412,-0 -0.75,-0.339 -0.75,-0.75c-0,-0.19 0.072,-0.373 0.201,-0.512c0.844,-0.843 1.318,-1.989 1.318,-3.182c0,-1.193 -0.474,-2.338 -1.318,-3.182c-0.141,-0.14 -0.22,-0.331 -0.22,-0.53c0,-0.412 0.339,-0.75 0.75,-0.75c0.199,-0 0.39,0.079 0.53,0.219Z"/>
				<path id="speaker" d="M12,3.75c0,-0 0,-0 0,-0c0,-0.412 -0.339,-0.75 -0.75,-0.75c-0.187,-0 -0.367,0.069 -0.505,0.195l-5.285,4.805l-2.71,0c-0.96,0 -1.75,0.79 -1.75,1.75l0,4.5c0,0.966 0.784,1.75 1.75,1.75l2.71,0l5.285,4.805c0.138,0.126 0.318,0.195 0.505,0.195c0.411,0 0.75,-0.338 0.75,-0.75c0,0 0,0 0,0l0,-16.5Zm-5.745,5.555l4.245,-3.86l0,13.11l-4.245,-3.86c-0.138,-0.126 -0.318,-0.195 -0.505,-0.195l-3,0c-0.137,0 -0.25,-0.113 -0.25,-0.25l0,-4.5c0,-0.137 0.113,-0.25 0.25,-0.25l3,0c0.187,0 0.367,-0.069 0.505,-0.195Z"/>
			</svg>
		</button>
		<script>
			var video = document.getElementById("video-{$LocalVideo.ID}");
			var videoWrapper = document.getElementById("video-wrapper-{$LocalVideo.ID}");
			video.addEventListener('ended', function() {
				videoWrapper.classList.remove('play');
			});
			function toggleMute() {
				video.muted = !video.muted;
				if (video.muted) {
					videoWrapper.classList.add('muted');
				} else {
					videoWrapper.classList.remove('muted');
				}
			}
			function togglePlay() {
				video.paused?video.play():video.pause();
				videoWrapper.classList.toggle('play');
			}
		</script>
	</div>
<% end_if %>
