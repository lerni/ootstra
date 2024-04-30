<% require themedCSS("dist/css/teaser") %>
<div class="typography">
	<% if $isFullWidth && $ShowTitle %><div class="inner"><% end_if %>
		<% include App/Includes/ElementTitle %>
	<% if $isFullWidth && $ShowTitle %></div><% end_if %>
	<% if $Teasers %>
		<% if $ShowAsSlider %>
			<% require themedCSS("dist/css/swiper") %>
			<% require javascript("themes/default/dist/js/swiper.js") %>
			<div class="swiper-container teaser" id="general-swiper-{$ID}">
				<div class="swiper-wrapper teasers {$Layout}">
		<% else %>
			<div class="teasers {$Layout}">
		<% end_if %>
		<% if $Layout == "third" %>
			<% loop $Teasers.Sort(TeaserSortOrder) %>
				<% if $RelatedPageID %><a href="$RelatedPage.Link" <% else %><div <% end_if %>class="teaser<% if $Up.ShowAsSlider %> swiper-slide<% end_if %>">
					<% if $Image %><figure><img <% if not $IsFirst %>loading="lazy" <% end_if %>width="$Image.FocusFillMax(380,190).Width()" height="$Image.FocusFillMax(380,190).Height()" src="$Image.FocusFillMax(380,190).URL" srcset="$Image.FocusFillMax(380,190).URL 1x, $Image.FocusFillMax(680,340).URL 2x" alt="$Title" /></figure><% end_if %>
					<div class="txt">
						<% if $Title %><h3>$Title</h3><% end_if %>
						<% if $Text %>$Text.Markdowned<% end_if %>
					</div>
					<% if $RelatedPageID %><span class="link forth"><% if $Action %>{$Action}<% else %><%t App\Models\Teaser.MORE "Learn more" %><% end_if %></span><% end_if %>
				<% if $RelatedPageID %></a><% else %></div><% end_if %>
			<% end_loop %>
		<% end_if %>
		<% if $Layout == "halve" %>
			<% loop $Teasers.Sort(TeaserSortOrder) %>
				<% if $RelatedPageID %><a href="$RelatedPage.Link" <% else %><div <% end_if %>class="teaser<% if $Up.ShowAsSlider %> swiper-slide<% end_if %>">
					<% if $Image %><figure><img <% if not $IsFirst %>loading="lazy" <% end_if %>width="$Image.FocusFillMax(600,500).Width()" height="$Image.FocusFillMax(600,500).Height()" src="$Image.FocusFillMax(600,500).URL" srcset="$Image.FocusFillMax(600,500).URL 1x, $Image.FocusFillMax(1200,1000).URL 2x" alt="$Title" /></figure><% end_if %>
					<div class="txt">
						<% if $Title %><h3>$Title</h3><% end_if %>
						<div class="accordion">
							<% if $Text %>$Text.Markdowned<% end_if %>
							<% if $RelatedPageID %><span class="link forth"><% if $Action %>{$Action}<% else %><%t App\Models\Teaser.MORE "Learn more" %><% end_if %></span><% end_if %>
						</div>
					</div>
				<% if $RelatedPageID %></a><% else %></div><% end_if %>
			<% end_loop %>
		<% end_if %>
		<% if $Layout == "full" %>
			<% loop $Teasers.Sort(TeaserSortOrder) %>
				<% if $RelatedPageID %><a href="$RelatedPage.Link" <% else %><div <% end_if %>class="teaser<% if $Up.ShowAsSlider %> swiper-slide<% end_if %>">
					<% if $Image %><figure><img <% if not $IsFirst %>loading="lazy" <% end_if %>width="$Image.FocusFillMax(1400,700).Width()" height="$Image.FocusFillMax(1400,700).Height()" src="$Image.FocusFillMax(1400,700).URL" srcset="$Image.FocusFillMax(1400,700).URL 1x, $Image.FocusFillMax(2800,1400).URL 2x" alt="$Title" /></figure><% end_if %>
					<div class="txt">
						<% if $Title %><h3>$Title</h3><% end_if %>
						<div class="accordion">
							<% if $Text %>$Text.Markdowned<% end_if %>
							<% if $RelatedPageID %><span class="link forth"><% if $Action %>{$Action}<% else %><%t App\Models\Teaser.MORE "Learn more" %><% end_if %></span><% end_if %>
						</div>
					</div>
				<% if $RelatedPageID %></a><% else %></div><% end_if %>
			<% end_loop %>
		<% end_if %>
		<% if $ShowAsSlider %>
			</div>
		</div>
		<% else %>
		</div>
		<% end_if %>
	<% end_if %>
</div>
