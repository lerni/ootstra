<% require themedCSS("dist/css/jobs") %>
<% include App/Includes/ElementTitle %>
<% if $Items %>
	<div class="jobs">
		<% loop $Items %>
			<a href='{$AbsoluteLink}' class="job">
				<% if $HeaderImage %><figure><img height="$HeaderImage.FocusFillMax(340,160).Height()" width="$HeaderImage.FocusFillMax(340,160).Width()" src="$HeaderImage.FocusFillMax(340,160).URL" srcset="$HeaderImage.FocusFillMax(340,160).URL 1x, $HeaderImage.FocusFillMax(680,320).URL 2x" alt="$Title" /></figure><% end_if %>
				<div class="txt">
					<% if $Title %><h2>$Title</h2><% end_if %>
					<%-- <p><% loop $JobLocations %>$AddressLocality<% if not $Last %>, <% end_if %><% end_loop %></p> --%>
				</div>
				<p class="link forth"><%t Kraftausdruck\Elements\ElementJobs.MORE "Read more" %></p>
			</a>
		<% end_loop %>
	</div>
<% else %>
	<div class="no-vacancies">
		{$NoVacancies}
	</div>
<% end_if %>
