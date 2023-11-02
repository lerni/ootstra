<% require themedCSS("dist/css/jobs") %>
<% include App/Includes/ElementTitle %>
<% if $Items %>
	<div class="jobs teasers">
		<% loop $Items %>
			<a href='{$AbsoluteLink}' class="job teaser">
				<% if $Slides.Sort('SortOrder').First.SlideImage %>
					<% with $Slides.Sort('SortOrder').First.SlideImage %>
						<figure><img height="$FocusFillMax(340,160).Height()" width="$FocusFillMax(340,160).Width()" src="$FocusFillMax(340,160).URL" srcset="$FocusFillMax(340,160).URL 1x, $FocusFillMax(680,320).URL 2x" alt="$Title" /></figure>
					<% end_with %>
				<% end_if %>
				<div class="txt">
					<% if $Title %><h2>$Title</h2><% end_if %>
					<%-- <p><% loop $JobLocations %>$Town<% if not $Last %>, <% end_if %><% end_loop %></p> --%>
					<p class="link forth"><%t Kraftausdruck\Elements\ElementJobs.MORE "Read more" %></p>
				</div>
			</a>
		<% end_loop %>
	</div>
<% else %>
	<div class="no-vacancies">
		{$NoVacancies}
	</div>
<% end_if %>
