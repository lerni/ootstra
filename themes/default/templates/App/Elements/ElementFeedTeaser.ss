<% cached 'ElementFeedTeaser', $ID, $LastEdited, $List('SilverStripe\CMS\Model\SiteTree').max('LastEdited'), $List('SilverStripe\CMS\Model\SiteTree').count() %>
<% include App/Includes/ElementTitle %>
<% if $Items %>
	<% if $Layout == "third" %>
		<div class="teasers third">
			<% loop $Items %>
				<a href="$Link" class="teaser">
					<% if $getDefaultOGImage(1).ID %><figure><img loading="lazy" width="$getDefaultOGImage(1).FocusFillMax(340,170).Width()" height="$getDefaultOGImage(1).FocusFillMax(340,170).Height()" src="$getDefaultOGImage(1).FocusFillMax(340,170).URL" srcset="$getDefaultOGImage(1).FocusFillMax(340,170).URL 1x, $getDefaultOGImage(1).FocusFillMax(680,340).URL 2x" alt="$Title" /></figure><% end_if %>
					<div class="txt">
						<% if $OGTitle %><h4>$OGTitle</h4><% end_if %>
						<% if $Summary %>
							$Summary
						<% else_if $OGDescription %>
							<p>$OGDescription.Summary(40)</p>
						<% end_if %>
					</div>
					<span class="pseudolink"><%t App\Models\Teaser.MORE "Learn more" %></span>
				</a>
			<% end_loop %>
		</div>
	<% end_if %>
	<% if $Layout == "halve" %>
		<div class="teasers halve">
			<% loop $Items %>
				<a href="$Link" class="teaser">
					<% if $getDefaultOGImage(1).ID %><figure><img loading="lazy" width="$getDefaultOGImage(1).FocusFillMax(480,400).Width()" height="$getDefaultOGImage(1).FocusFillMax(480,400).Height()" src="$getDefaultOGImage(1).FocusFillMax(480,400).URL" srcset="$getDefaultOGImage(1).FocusFillMax(480,400).URL 1x, $getDefaultOGImage(1).FocusFillMax(960,800).URL 2x" alt="$Title" /></figure><% end_if %>
					<div class="txt">
						<% if $OGTitle %><h4>$OGTitle</h4><% end_if %>
						<% if $Summary %>
							$Summary
						<% else_if $OGDescription %>
							<p>$OGDescription.Summary(60)</p>
						<% end_if %>
						<span class="pseudolink"><%t App\Models\Teaser.MORE "Learn more" %></span>
					</div>
				</a>
			<% end_loop %>
		</div>
	<% end_if %>
	<% if $Layout == "full" %>
		<div class="teasers full">
			<% loop $Items %>
				<a href="$Link" class="teaser">
					<% if $getDefaultOGImage(1).ID %><figure><img loading="lazy" width="$getDefaultOGImage(1).FocusFillMax(1400,600).Width()" height="$getDefaultOGImage(1).FocusFillMax(1400,600).Height()" src="$getDefaultOGImage(1).FocusFillMax(1400,600).URL" srcset="$getDefaultOGImage(1).FocusFillMax(1400,600).URL 1x, $getDefaultOGImage(1).FocusFillMax(2800,1200).URL 2x" alt="$Title" /></figure><% end_if %>
					<div class="txt">
						<% if $OGTitle %><h4>$OGTitle</h4><% end_if %>
						<% if $OGDescription %><p>$OGDescription</p><% end_if %>
						<span class="pseudolink"><%t App\Models\Teaser.MORE "Learn more" %></span>
					</div>
				</a>
			<% end_loop %>
		</div>
	<% end_if %>
<% end_if %>
<% if $FirstLinkAction %>
	<a class="pseudolink button" href="$FeedTeaserParents().First().Link()">$FirstLinkAction</a>
<% end_if %>
<% end_cached %>
