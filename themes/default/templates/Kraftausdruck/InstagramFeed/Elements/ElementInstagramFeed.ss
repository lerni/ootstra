<% require themedCSS("dist/css/instafeed") %>
<% require themedCSS("dist/css/swiper") %>
<% require javascript("themes/default/dist/js/swiper.js") %>
<%-- $InstagramFeed.Profile.username --%>
<% if $isFullWidth && $ShowTitle %><div class="typography inner"><% end_if %>
	<% include App/Includes/ElementTitle %>
<% if isFullWidth %></div><% end_if %>
<% if $HTML %><div class="typography">{$HTML}</div><% end_if %>
<% if $InstagramFeed.Media %>
	<div class="instafeed swiper-container" data-id="{$ID}" id="multiple-swiper-{$ID}">
		<div class="swiper-wrapper multiple">
			<% loop $InstagramFeed.Media %>
				<% if $media_type == "CAROUSEL_ALBUM" %>
					<% if $Children.Count >= 1 %>
						<div class="swiper-slide">
							<div class="swiper-container swiper-v" data-id="{$Pos}" id="insta-swiper-{$Pos}">
								<div class="swiper-wrapper">
					<% end_if %>
					<% loop $Children %><%-- per default we show just one - may just incrase limit? --%>
						<a class="swiper-slide $media_type.LowerCase" href="$permalink?img_index={$Pos}" target="_blank" rel="noopener">
							<figure >
								<% if $media_type == "VIDEO" %>
									<video muted poster="$thumbnail_url" autoplay loop playsinline style="width:100%">
										<source src="$media_url" type="video/mp4">
									</video>
								<% else_if $media_type == "IMAGE" %>
									<img loading="lazy" src="$media_url" alt="$Up.caption" />
								<% end_if %>
								<figcaption>
									{$Up.caption}
									<span data-feather="instagram"></span>
								</figcaption>
							</figure>
						</a>
					<% end_loop %>
					<% if $Children.Count >= 1 %>
								</div>
								<div class="swiper-pagination vertical" id="insta-vertical-swiper-pagination{$Pos}"></div>
							</div>
						</div>
					<% end_if %>
				<% end_if %>
				<a class="swiper-slide $media_type.LowerCase" href="$permalink" target="_blank" rel="noopener">
					<figure>
						<% if $media_type == "VIDEO" %>
							<video muted poster="$thumbnail_url" autoplay loop playsinline style="width:100%">
								<source src="$media_url" type="video/mp4">
							</video>
						<% else_if $media_type == "IMAGE" %>
							<img loading="lazy" src="$media_url" alt="$caption" />
						<% end_if %>
						<figcaption>{$caption}<span data-feather="instagram"></span></figcaption>
					</figure>
				</a>
			<% end_loop %>
		</div>
	</div>
<% end_if %>
