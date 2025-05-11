<% require themedCSS("dist/css/cards") %><%-- Items() is cached, so no need to...  cached 'ElementFeedTeaser', $ID, $LastEdited, $List('SilverStripe\CMS\Model\SiteTree').max('LastEdited'), $List('SilverStripe\CMS\Model\SiteTree').count() --%>
<div class="typography">
	<% if $isFullWidth && $ShowTitle %><div class="inner"><% end_if %>
		<% include App/Includes/ElementTitle %>
	<% if $isFullWidth && $ShowTitle %></div><% end_if %>
	<% if $Items %>
		<% if $ShowAsSlider %>
			<% require themedCSS("dist/css/swiper") %>
			<% require javascript("themes/default/dist/js/swiper.js") %>
			<div class="swiper-container cards multiple" id="general-swiper-{$ID}" data-id="{$ID}">
				<div class="swiper-wrapper cards {$Layout}">
		<% else %>
			<div class="cards {$Layout}">
		<% end_if %>
			<% if $Layout == "full" %>
				<% loop $Items %>
					<a href="$Link" class="<% if $Up.ShowAsSlider %>swiper-slide <% end_if %>card">
						<% if $getDefaultOGImage(1).Exists() %><figure><img <% if not $IsFirst %>loading="lazy" <% end_if %>width="$getDefaultOGImage(1).FocusFillMax(1400,700).Width()" height="$getDefaultOGImage(1).FocusFillMax(1400,700).Height()" src="$getDefaultOGImage(1).FocusFillMax(1400,700).Convert('webp').URL" srcset="$getDefaultOGImage(1).FocusFillMax(1400,700).Convert('webp').URL 1x, $getDefaultOGImage(1).FocusFillMax(2800,1400).Convert('webp').URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $OGTitle %><{$Up.ChildTitleLevel}>$OGTitle</{$Up.ChildTitleLevel}><% end_if %>
							<div class="accordion">
								<% if $OGDescription %><p>$OGDescription</p><% end_if %>
							</div>
							<span class="link forth"><%t App\Models\Teaser.MORE "Learn more" %></span>
						</div>
					</a>
				<% end_loop %>
			<% else_if $Layout == "halve" %>
				<% loop $Items %>
					<a href="$Link" class="<% if $Up.ShowAsSlider %>swiper-slide <% end_if %>card">
						<% if $getDefaultOGImage(1).Exists() %><figure><img <% if not $IsFirst %>loading="lazy" <% end_if %>width="$getDefaultOGImage(1).FocusFillMax(600,500).Width()" height="$getDefaultOGImage(1).FocusFillMax(600,500).Height()" src="$getDefaultOGImage(1).FocusFillMax(600,500).Convert('webp').URL" srcset="$getDefaultOGImage(1).FocusFillMax(600,500).Convert('webp').URL 1x, $getDefaultOGImage(1).FocusFillMax(1200,1000).Convert('webp').URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $OGTitle %><{$Up.ChildTitleLevel}>$OGTitle</{$Up.ChildTitleLevel}><% end_if %>
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
			<% else %>
				<% loop $Items %>
					<a href="$Link" class="<% if $Up.ShowAsSlider %>swiper-slide <% end_if %>card">
						<% if $getDefaultOGImage(1).Exists() %><figure><img <% if not $IsFirst %>loading="lazy" <% end_if %>width="$getDefaultOGImage(1).FocusFillMax(380,190).Width()" height="$getDefaultOGImage(1).FocusFillMax(380,190).Height()" src="$getDefaultOGImage(1).FocusFillMax(380,190).Convert('webp').URL" srcset="$getDefaultOGImage(1).FocusFillMax(380,190).Convert('webp').URL 1x, $getDefaultOGImage(1).FocusFillMax(680,340).Convert('webp').URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $OGTitle %><{$Up.ChildTitleLevel}>$OGTitle</{$Up.ChildTitleLevel}><% end_if %>
							<% if $Summary %>
								$Summary
							<% else_if $OGDescription %>
								<p>$getDefaultOGDescription(0, 30)</p>
							<% end_if %>
						</div>
						<span class="link forth"><%t App\Models\Teaser.MORE "Learn more" %></span>
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
		<a class="link forth" href="$FeedTeaserParentsWithCategory">$FirstLinkAction</a>
	<% end_if %>
</div><%-- end_cached --%>
