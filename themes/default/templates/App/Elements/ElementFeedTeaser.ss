<% if not $isFullWidth %><div class="inner"><% end_if %>
	<% include App/Includes/ElementTitle %>
	<% if $Items %>
		<% if $Layout == "third" %>
			<div class="teasers third">
				<% loop $Items %>
					<a href="$Link" class="teaser">
						<% if $OGImage %><figure><img src="$OGImage.FocusFillMax(340,170).URL" srcset="$OGImage.FocusFillMax(340,170).URL 1x, $OGImage.FocusFillMax(680,340).URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $OGTitle %><h4>$OGTitle</h4><% end_if %>
							<% if $OGDescription %><p>$OGDescription.Summary(20)</p><% end_if %>
						</div>
						<span class="pseudolink"><%t App\Models\Teaser.MORE "none" %></span>
					</a>
				<% end_loop %>
			</div>
		<% end_if %>
		<% if $Layout == "halve" %>
			<div class="teasers halve">
				<% loop $Items %>
					<a href="$Link" class="teaser">
						<% if $OGImage %><figure><img src="$OGImage.FocusFillMax(480,400).URL" srcset="$OGImage.FocusFillMax(480,400).URL 1x, $OGImage.FocusFillMax(960,800).URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $OGTitle %><h4>$OGTitle</h4><% end_if %>
							<div class="accordion">
								<% if $OGDescription %><p>$OGDescription.Summary(30)</p><% end_if %>
								<span class="pseudolink"><%t App\Models\Teaser.MORE "none" %></span>
							</div>
						</div>
					</a>
				<% end_loop %>
			</div>
		<% end_if %>
		<% if $Layout == "full" %>
			<div class="teasers full">
				<% loop $Items %>
					<a href="$Link" class="teaser">
						<% if $OGImage %><figure><img src="$OGImage.FocusFillMax(1400,600).URL" srcset="$OGImage.FocusFillMax(1400,600).URL 1x, $OGImage.FocusFillMax(2800,1200).URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $OGTitle %><h4>$OGTitle</h4><% end_if %>
							<div class="accordion">
								<% if $OGDescription %><p>$OGDescription</p><% end_if %>
								<span class="pseudolink"><%t App\Models\Teaser.MORE "none" %></span>
							</div>
						</div>
					</a>
				<% end_loop %>
			</div>
		<% end_if %>
	<% end_if %>
	<% if $FirstLinkAction %>
		<a class="pseudolink button" href="$FeedTeaserParents().First().Link()">$FirstLinkAction</a>
	<% end_if %>
<% if not $isFullWidth %></div><% end_if %>
