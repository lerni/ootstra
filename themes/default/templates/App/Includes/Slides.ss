<% if $Slides %>
	<div class="swiper-container hero hero--{$HeroSize}<% if $DoNotCrop %> do-not-crop<% end_if %>" data-id="{$ID}" id="hero-swiper-{$ID}">
		<div class="swiper-wrapper hero">
			<% loop $Slides.Sort('SortOrder') %>
				<% if $SlideImage || $EmbedVideo %>
					<div class="swiper-slide {$TextAlignment}">
						<% if $EmbedVideo %>
							<div class="embed-hero" style="display: none;">
								{$EmbedVideo}
								<div class="overlayer"></div>
							</div>
							<%-- we repeat medium-size for a still-image fake --%>
							<figure class="video<% if $LinkID %> linked<% end_if %>"><img sizes="100vw"
								height="$SlideImage.FocusFillMax(1440,650).Height()"
								width="$SlideImage.FocusFillMax(1440,650).Width()"
								<% if not $First %>loading="lazy" <% end_if %>
								alt="$SlideImage.Title"
								style="object-position: {$SlideImage.FocusFillMax(1440,650).FocusPoint.PercentageX}% {$SlideImage.FocusFillMax(1440,650).FocusPoint.PercentageY}%;"
								src="$SlideImage.FocusFillMax(1440,650).URL"
								srcset="
									$SlideImage.FocusFillMax(480,217).URL 480w,
									$SlideImage.FocusFillMax(640,289).URL 640w,
									$SlideImage.FocusFillMax(800,361).URL 800w,
									$SlideImage.FocusFillMax(1000,451).URL 1000w,
									$SlideImage.FocusFillMax(1200,542).URL 1200w,
									$SlideImage.FocusFillMax(1440,650).URL 1440w<% if $Up.isFullWidth %>,
									$SlideImage.FocusFillMax(1600,722).URL 1600w,
									$SlideImage.FocusFillMax(2000,903).URL 2000w,
									$SlideImage.FocusFillMax(2600,1174).URL 2600w<% end_if %>" />
							</figure>
						<% else_if $Up.HeroSize == "small" %>
							<figure <% if $LinkID %>class="linked"<% end_if %>><img sizes="100vw"
								height="$SlideImage.FocusFillMax(1440,360).Height()"
								width="$SlideImage.FocusFillMax(1440,360).Width()"
								<% if not $First %>loading="lazy" <% end_if %>
								alt="$SlideImage.Title"
								style="object-position: {$SlideImage.FocusFillMax(1440,360).FocusPoint.PercentageX}% {$SlideImage.FocusFillMax(1440,360).FocusPoint.PercentageY}%;"
								src="$SlideImage.FocusFillMax(1440,360).URL"
								srcset="
									$SlideImage.FocusFillMax(480,120).URL 480w,
									$SlideImage.FocusFillMax(640,160).URL 640w,
									$SlideImage.FocusFillMax(800,200).URL 800w,
									$SlideImage.FocusFillMax(1000,250).URL 1000w,
									$SlideImage.FocusFillMax(1200,300).URL 1200w,
									$SlideImage.FocusFillMax(1440,360).URL 1440w<% if $Up.isFullWidth %>,
									$SlideImage.FocusFillMax(1600,400).URL 1600w,
									$SlideImage.FocusFillMax(2000,500).URL 2000w,
									$SlideImage.FocusFillMax(2600,650).URL 2600w<% end_if %>" />
							</figure>
						<% else_if $Up.HeroSize == "medium" %>
							<figure <% if $LinkID %>class="linked"<% end_if %>><img sizes="100vw"
								height="$SlideImage.FocusFillMax(1440,650).Height()"
								width="$SlideImage.FocusFillMax(1440,650).Width()"
								<% if not $First %>loading="lazy" <% end_if %>
								alt="$SlideImage.Title"
								style="object-position: {$SlideImage.FocusFillMax(1440,650).FocusPoint.PercentageX}% {$SlideImage.FocusFillMax(1440,650).FocusPoint.PercentageY}%;"
								src="$SlideImage.FocusFillMax(1440,650).URL"
								srcset="
									$SlideImage.FocusFillMax(480,217).URL 480w,
									$SlideImage.FocusFillMax(640,289).URL 640w,
									$SlideImage.FocusFillMax(800,361).URL 800w,
									$SlideImage.FocusFillMax(1000,452).URL 1000w,
									$SlideImage.FocusFillMax(1200,542).URL 1200w,
									$SlideImage.FocusFillMax(1440,650).URL 1440w<% if $Up.isFullWidth %>,
									$SlideImage.FocusFillMax(1600,722).URL 1600w,
									$SlideImage.FocusFillMax(2000,903).URL 2000w,
									$SlideImage.FocusFillMax(2600,1174).URL 2600w<% end_if %>" />
							</figure>
						<% else_if $Up.HeroSize == "fullscreen" %>
							<figure><picture>
								<%-- 8:5 is like macbook pro display--%>
								<source media="(min-width: 640px) and (min-aspect-ratio: 8/5)"
										srcset="$SlideImage.FocusFillMax(640,400).URL 640w,
									$SlideImage.FocusFillMax(800,500).URL 800w,
									$SlideImage.FocusFillMax(1000,625).URL 1000w,
									$SlideImage.FocusFillMax(1200,750).URL 1200w,
									$SlideImage.FocusFillMax(1440,900).URL 1440w,
									$SlideImage.FocusFillMax(1600,1000).URL 1600w,
									$SlideImage.FocusFillMax(2000,1250).URL 2000w,
									$SlideImage.FocusFillMax(2600,1625).URL 2600w
							">
								<%-- 5:8 is portrait --%>
								<source media="(min-width: 384px) and (max-aspect-ratio: 5/8)"
										srcset="$SlideImage.FocusFillMax(384,614).URL 320w,
									$SlideImage.FocusFillMax(480,768).URL 480w,
									$SlideImage.FocusFillMax(720,1152).URL 800w,
									$SlideImage.FocusFillMax(800,1280).URL 1000w,
									$SlideImage.FocusFillMax(1000,1600).URL 1200w,
									$SlideImage.FocusFillMax(1200,1920).URL 1440w,
									$SlideImage.FocusFillMax(1440,2304).URL 1600w
							">
								<%-- 4:3 say desktop --%>
								<source media="(min-width: 480px) and (min-aspect-ratio: 4/3)"
										srcset="$SlideImage.FocusFillMax(480,360).URL 480w,
									$SlideImage.FocusFillMax(640,480).URL 640w,
									$SlideImage.FocusFillMax(800,600).URL 800w,
									$SlideImage.FocusFillMax(1000,750).URL 1000w,
									$SlideImage.FocusFillMax(1200,900).URL 1200w,
									$SlideImage.FocusFillMax(1400,1050).URL 1400w,
									$SlideImage.FocusFillMax(1600,1200).URL 1600w,
									$SlideImage.FocusFillMax(2000,1500).URL 2000w,
									$SlideImage.FocusFillMax(2600,1950).URL 2600w
							">
								<img src="$SlideImage.FocusFillMax(1400,1050).URL" alt="$SlideImage.Title" id="hero-image-{$ID}">
							</picture></figure>
							<div class="scroll"></div>
							<style type="text/css" nonce="{$Nonce}">
								#hero-image-{$ID} {
									object-position: {$SlideImage.FocusFillMax(2600,1950).Focuspoint.PercentageX}% {$SlideImage.FocusFillMax(2600,1950).Focuspoint.PercentageY}%;
								}
								@media screen and (max-aspect-ratio: 5/8) {
									#hero-image-{$ID} {
										object-position: {$SlideImage.FocusFillMax(1440,2304).Focuspoint.PercentageX}% {$SlideImage.FocusFillMax(1440,2304).Focuspoint.PercentageY}%;
									}
								}
								@media screen and (min-aspect-ratio: 8/5) {
									#hero-image-{$ID} {
										object-position: {$SlideImage.FocusFillMax(2600,1625).Focuspoint.PercentageX}% {$SlideImage.FocusFillMax(2600,1625).Focuspoint.PercentageY}%;
									}
								}
							</style>
						<% end_if %>
						<% if $Text || $LinkID %>
							<% if $LinkID %><a href="$Link.Link" class="txt {$TextAlignment}"><% else %><div class="txt {$TextAlignment}"><% end_if %>
								<% if $Text %><div class="inner">
									<div class="spacer">
										<% if $ShowTitle %><h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>>$Title</h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>><% end_if %>
										$Text.Markdowned
									</div>
								</div><% end_if %>
							<% if $LinkID %></a><% else %></div><% end_if %>
						<% end_if %>
					</div>
				<% end_if %>
			<% end_loop %>
		</div>
	</div>
	<% if $Slides.Count > 1 %>
		<% require themedCSS("dist/css/swiper") %>
		<% require javascript("themes/default/dist/js/swiper.js") %>
		<div class="swiper-pagination hero spacing-bottom-{$SpacingBottom}" id="hero-swiper-pagination{$ID}"></div>
		<div class="swiper-button-prev hero spacing-bottom-{$SpacingBottom}" id="hero-swiper-prev{$ID}"></div>
		<div class="swiper-button-next hero spacing-bottom-{$SpacingBottom}" id="hero-swiper-next{$ID}"></div>
	<% end_if %>
<% end_if %>
