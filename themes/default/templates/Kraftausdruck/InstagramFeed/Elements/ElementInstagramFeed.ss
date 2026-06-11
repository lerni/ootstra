<% vite 'src/css/instafeed.css', 'src/css/swiper.css', 'src/js/swiper.js' %>
<%-- $InstagramFeed.Profile.username --%>
<% if $isFullWidth && $ShowTitle %><div class="typography inner"><% end_if %>
	<% include App/Includes/ElementTitle %>
<% if isFullWidth %></div><% end_if %>
<% if $HTML %><div class="typography">{$HTML}</div><% end_if %>
<% if $InstagramFeed.Media %>
	<div class="instafeed swiper" data-id="{$ID}" id="multiple-swiper-{$ID}">
		<div class="swiper-wrapper multiple">
			<% loop $InstagramFeed.Media %>
				<% if $media_type == "CAROUSEL_ALBUM" %>
					<% if $Children.Count >= 1 %>
						<div class="swiper-slide">
							<div class="swiper swiper-vertical" data-id="{$Pos}" id="insta-swiper-{$Pos}">
								<div class="swiper-wrapper">
					<% end_if %>
					<% loop $Children %><%-- per default we show just one - may just incrase limit? --%>
						<div class="swiper-slide $media_type.LowerCase">
							<figure>
								<% if $media_type == "VIDEO" %>
									<video muted poster="$thumbnail_url" autoplay loop playsinline>
										<source src="$media_url" type="video/mp4">
									</video>
								<% else_if $media_type == "IMAGE" %>
									<img loading="lazy" src="$media_url" alt="$Up.caption" />
								<% end_if %>
								<figcaption>
									<span class="caption-text">{$Up.caption}</span>
									<a href="$permalink?img_index={$Pos}" target="_blank" rel="noopener" aria-label="<%t Kraftausdruck\InstagramFeed\Elements\ElementInstagramFeed.OpenOnInstagram 'Open on Instagram' %>"><span data-icon="instagram"></span></a>
								</figcaption>
							</figure>
						</div>
					<% end_loop %>
					<% if $Children.Count >= 1 %>
								</div>
								<div class="swiper-pagination vertical" id="insta-vertical-swiper-pagination{$Pos}"></div>
							</div>
						</div>
					<% end_if %>
				<% else %>
					<div class="swiper-slide $media_type.LowerCase">
						<figure>
							<% if $media_type == "VIDEO" %>
								<video muted poster="$thumbnail_url" autoplay loop playsinline>
									<source src="$media_url" type="video/mp4">
								</video>
							<% else_if $media_type == "IMAGE" %>
								<img loading="lazy" src="$media_url" alt="$caption" />
							<% end_if %>
							<figcaption><span class="caption-text">{$caption}</span><a href="$permalink" target="_blank" rel="noopener" aria-label="<%t Kraftausdruck\InstagramFeed\Elements\ElementInstagramFeed.OpenOnInstagram 'Open on Instagram' %>"><span data-icon="instagram"></span></a></figcaption>
						</figure>
					</div>
				<% end_if %>
			<% end_loop %>
		</div>
	</div>
<% end_if %>
