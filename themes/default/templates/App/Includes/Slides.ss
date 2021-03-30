<% if $Slides %>
	<div class="swiper-container hero {$Size}<% if $DoNotCrop %> do-not-crop<% end_if %>">
		<div class="swiper-wrapper hero">
			<% loop $Slides.Sort('SortOrder') %>
				<% if $SlideImage %>
					<div class="swiper-slide {$TextAlignment}">
						<% if $Up.Up.Size == "small" %>
							<figure <% if $LinkID %>class="linked"<% end_if %>><img sizes="100vw"
								height="$SlideImage.FocusFillMax(1440,360).Height()"
								width="$SlideImage.FocusFillMax(1440,360).Width()"
								<% if not $First %>loading="lazy" <% end_if %>
								alt="$SlideImage.Title"
								style="object-position: {$SlideImage.FocusFillMax(2600,650).PercentageX}% {$SlideImage.FocusFillMax(2600,650).PercentageY}%;"
								src="$SlideImage.FocusFillMax(1440,360).URL"
								srcset="
									$SlideImage.FocusFillMax(480,120).URL 480w,
									$SlideImage.FocusFillMax(640,160).URL 640w,
									$SlideImage.FocusFillMax(800,200).URL 800w,
									$SlideImage.FocusFillMax(1000,250).URL 1000w,
									$SlideImage.FocusFillMax(1200,300).URL 1200w,
									$SlideImage.FocusFillMax(1440,360).URL 1440w<% if $Up.Up.isFullWidth %>,
									$SlideImage.FocusFillMax(1600,400).URL 1600w,
									$SlideImage.FocusFillMax(2000,500).URL 2000w,
									$SlideImage.FocusFillMax(2600,650).URL 2600w<% end_if %>" />
							</figure>
						<% else_if $Up.Up.Size == "medium" %>
							<figure <% if $LinkID %>class="linked"<% end_if %>><img sizes="100vw"
								height="$SlideImage.FocusFillMax(1440,550).Height()"
								width="$SlideImage.FocusFillMax(1440,550).Width()"
								<% if not $First %>loading="lazy" <% end_if %>
								alt="$SlideImage.Title"
								style="object-position: {$SlideImage.FocusFillMax(1440,810).PercentageX}% {$SlideImage.FocusFillMax(1440,810).PercentageY}%;"
								src="$SlideImage.FocusFillMax(1440,810).URL"
								srcset="$SlideImage.FocusFillMax(480,270).URL 480w,
									$SlideImage.FocusFillMax(640,360).URL 640w,
									$SlideImage.FocusFillMax(800,450).URL 800w,
									$SlideImage.FocusFillMax(1000,563).URL 1000w,
									$SlideImage.FocusFillMax(1200,675).URL 1200w,
									$SlideImage.FocusFillMax(1440,810).URL 1440w<% if $Up.Up.isFullWidth %>,
									$SlideImage.FocusFillMax(1600,900).URL 1600w,
									$SlideImage.FocusFillMax(2000,1125).URL 2000w,
									$SlideImage.FocusFillMax(2600,1463).URL 2600w<% end_if %>" />
							</figure>
						<% else_if $Up.Up.Size == "fullscreen" %>
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
									$SlideImage.FocusFillMax(640,1024).URL 720w,
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
								<img src="$SlideImage.FocusFillMax(1400,1050).URL" alt="$Beschreibung" id="hero-image-{$ID}">
							</picture></figure>
							<div class="scroll"></div>
							<style type="text/css">
								#hero-image-{$ID} {
									object-position: {$SlideImage.FocusFillMax(2600,1950).PercentageX}% {$SlideImage.FocusFillMax(2600,1950).PercentageY}%;
								}
								@media screen and (max-aspect-ratio: 5/8) {
									#hero-image-{$ID} {
										object-position: {$SlideImage.FocusFillMax(1440,2304).PercentageX}% {$SlideImage.FocusFillMax(1440,2304).PercentageY}%;
									}
								}
								@media screen and (min-aspect-ratio: 8/5) {
									#hero-image-{$ID} {
										object-position: {$SlideImage.FocusFillMax(2600,1625).PercentageX}% {$SlideImage.FocusFillMax(2600,1625).PercentageY}%;
									}
								}
							</style>
						<% end_if %>
						<% if $Text || $LinkID %>
							<% if $LinkID %><a href="$Link.Link" class="txt {$TextAlignment}"><% else %><div class="txt {$TextAlignment}"><% end_if %>
								<% if $Text %><div class="inner">
									<div class="spacer">
										<% if $ShowTitle %><h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>>$Title</h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>><% end_if %>
										<p>$Text</p>
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
		<div class="swiper-pagination hero"></div><%-- <div class="swiper-button-prev"></div>  <div class="swiper-button-next"></div> --%>
	<% end_if %>
<% end_if %>
