<% include App/Includes/Header %>
<% require themedCSS("dist/css/cards") %>
<% require javascript("themes/default/dist/js/infiniteGrid.js") %>
<main>
	<% include App/Includes/DefaultHero %>
	<article class="element default horizontal-spacing spacing-bottom-1 after-hero">
		<div class="typography width-reduced">
			$Content
		</div>
	</article>
	<article class="element elementfeedteaser full-width horizontal-spacing">
		<% if $Items %>
			<div class="masonry-holder cards {$Layout}">
				<% loop $Items %>
					<a href="$Link" class="masonry-brick card" style="aspect-ratio: {$getDefaultOGImage(1).ScaleMaxWidth(600).Width()} / {$getDefaultOGImage(1).ScaleMaxWidth(600).Height()}">
						<% if $getDefaultOGImage(1).Exists() %><figure><img <% if not $IsFirst %>loading="lazy" <% end_if %>width="$getDefaultOGImage(1).ScaleMaxWidth(600).Width()" height="$getDefaultOGImage(1).ScaleMaxWidth(600).Height()" src="$getDefaultOGImage(1).ScaleMaxWidth(600).Convert('webp').URL" srcset="$getDefaultOGImage(1).ScaleMaxWidth(600).Convert('webp').URL 1x, $getDefaultOGImage(1).ScaleMaxWidth(1200).Convert('webp').URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $OGTitle %><h3>$OGTitle</h3><% end_if %>
							<div class="accordion">
								<% if $Summary %>
									$Summary
								<% else_if $OGDescription %>
									<p>$getDefaultOGDescription(0, 60)</p>
								<% end_if %>
							</div>
							<span class="link forth"><%t App\Models\Teaser.MORE "Learn more" %></span>
						</div>
					</a>
				<% end_loop %>
			</div>
		<% end_if %>
	</article>
</main>
