<% include App/Includes/ElementTitle %>
<% if not $isFullWidth %><div class="inner"><% end_if %>
<% if $Items %>
	<div class="jobs teasers">
		<% loop $Items %>
			<a href='{$AbsoluteLink}' class="job teaser">
				<% if $HeaderImage %><figure><img height="$HeaderImage.FocusFillMax(340,160).Height()" width="$HeaderImage.FocusFillMax(340,160).Width()" src="$HeaderImage.FocusFillMax(340,160).URL" srcset="$HeaderImage.FocusFillMax(340,160).URL 1x, $HeaderImage.FocusFillMax(680,320).URL 2x" alt="$Title" /></figure><% end_if %>
				<div class="txt">
					<% if $Title %><h4>$Title</h4><% end_if %>
					<%-- <p><% loop $JobLocations %>$AddressLocality<% if not $Last %>, <% end_if %><% end_loop %></p> --%>
				</div>
				<p class="forth"><%t Kraftausdruck\Models\JobPosting.MORE "Stelleninserat" %></p>
			</a>
		<% end_loop %>
	</div>
<% else %>
	<div class="no-vacancies">
		{$NoPodcasts}
	</div>
<% end_if %>
$PodcastSeries.PodcastSeriesSchema.RAW
<% if not $isFullWidth %></div><% end_if %>
