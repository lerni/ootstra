<% cached 'ElementFeedTeaser', $ID, $LastEdited, $List('SilverStripe\CMS\Model\SiteTree').max('LastEdited'), $List('SilverStripe\CMS\Model\SiteTree').count() %>
<% require themedCSS("dist/css/teaser") %>
<div class="typography">
	<% if $isFullWidth && $ShowTitle %><div class="inner"><% end_if %>
		<% include App/Includes/ElementTitle %>
	<% if $isFullWidth && $ShowTitle %></div><% end_if %>
	<% if $Items %>
		<% if $ShowAsSlider %>
			<% require themedCSS("dist/css/swiper") %>
			<% require javascript("themes/default/dist/js/swiper.js") %>
			<div class="swiper-container teaser" id="general-swiper-{$ID}">
				<div class="swiper-wrapper teasers {$Layout}">
		<% else %>
			<div class="teasers {$Layout}">
		<% end_if %>
			<% if $Layout == "third" %>
				<% loop $Items %>
					<a href="$Link" class="<% if $Up.ShowAsSlider %>swiper-slide <% end_if %>teaser">
						<% if $getDefaultOGImage(1).ID %><figure><img <% if not $First %>loading="lazy" <% end_if %>width="$getDefaultOGImage(1).FocusFillMax(380,190).Width()" height="$getDefaultOGImage(1).FocusFillMax(380,190).Height()" src="$getDefaultOGImage(1).FocusFillMax(380,190).URL" srcset="$getDefaultOGImage(1).FocusFillMax(380,190).URL 1x, $getDefaultOGImage(1).FocusFillMax(680,340).URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $OGTitle %><h4>$OGTitle</h4><% end_if %>
							<% if $Summary %>
								$Summary
							<% else_if $OGDescription %>
								<p>$OGDescription.Summary(40)</p>
							<% end_if %>
						</div>
						<span class="link forth"><%t App\Models\Teaser.MORE "Learn more" %></span>
					</a>
				<% end_loop %>
			<% end_if %>
			<% if $Layout == "halve" %>
				<% loop $Items %>
					<a href="$Link" class="<% if $Up.ShowAsSlider %>swiper-slide <% end_if %>teaser">
						<% if $getDefaultOGImage(1).ID %><figure><img <% if not $First %>loading="lazy" <% end_if %>width="$getDefaultOGImage(1).FocusFillMax(600,500).Width()" height="$getDefaultOGImage(1).FocusFillMax(600,500).Height()" src="$getDefaultOGImage(1).FocusFillMax(600,500).URL" srcset="$getDefaultOGImage(1).FocusFillMax(600,500).URL 1x, $getDefaultOGImage(1).FocusFillMax(1200,1000).URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $OGTitle %><h3>$OGTitle</h3><% end_if %>
							<div class="accordion">
								<% if $Summary %>
									$Summary
								<% else_if $OGDescription %>
									<p>$OGDescription.Summary(60)</p>
								<% end_if %>
							</div>
							<span class="link forth"><%t App\Models\Teaser.MORE "Learn more" %></span>
						</div>
					</a>
				<% end_loop %>
			<% end_if %>
			<% if $Layout == "full" %>
				<% loop $Items %>
					<a href="$Link" class="<% if $Up.ShowAsSlider %>swiper-slide <% end_if %>teaser">
						<% if $getDefaultOGImage(1).ID %><figure><img <% if not $First %>loading="lazy" <% end_if %>width="$getDefaultOGImage(1).FocusFillMax(1400,700).Width()" height="$getDefaultOGImage(1).FocusFillMax(1400,700).Height()" src="$getDefaultOGImage(1).FocusFillMax(1400,700).URL" srcset="$getDefaultOGImage(1).FocusFillMax(1400,700).URL 1x, $getDefaultOGImage(1).FocusFillMax(2800,1400).URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $OGTitle %><h3>$OGTitle</h3><% end_if %>
							<div class="accordion">
								<% if $OGDescription %><p>$OGDescription</p><% end_if %>
							</div>
							<span class="link forth"><%t App\Models\Teaser.MORE "Learn more" %></span>
						</div>
					</a>
				<% end_loop %>
			<% end_if %>
		<% if $ShowAsSlider %>
			</div>
		</div>
		<% else %>
		</div>
		<% end_if %>
	<% end_if %>
	<% if $FirstLinkAction %>
		<a class="link forth" href="$FeedTeaserParents().First().Link()">$FirstLinkAction</a>
	<% end_if %>
</div>
<% end_cached %>
