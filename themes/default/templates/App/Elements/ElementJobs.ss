<% if $Items %>
<% if not $isFullWidth %><div class="inner"><% end_if %>
	<% include App/Includes/ElementTitle %>
	<div class="jobs teasers">
		<% loop $Items %>
			<a href='{$AbsoluteLink}' id="#{$Slug}" class="job teaser">
				<% if $HeaderImage %><figure><img height="$HeaderImage.FocusFillMax(340,160).Height()" width="$HeaderImage.FocusFillMax(340,160).Width()" src="$HeaderImage.FocusFillMax(340,160).URL" srcset="$HeaderImage.FocusFillMax(340,160).URL 1x, $HeaderImage.FocusFillMax(680,320).URL 2x" alt="$Title" /></figure><% end_if %>
				<div class="txt">
					<% if $Title %><h4>$Title</h4><% end_if %>
					<%-- <p><% loop $JobLocations %>$AddressLocality<% if not $Last %>, <% end_if %><% end_loop %></p> --%>
				</div>
				<p class="forth"><%t App\Elements\ElementJobs.MORE 'none' %></p>
			</a>
		<% end_loop %>
	</div>
	<% if not $isFullWidth %></div><% end_if %>
<% else %>
	<div class="inner nojobs">
		<p><strong>Aktuell sind alle Positionen besetzt. Wir sind jedoch stets daran interessiert, engagierte Berufsleute kennen zu lernen. Sind Sie interessiert für uns zu arbeiten? Dann freuen wir uns über eine Initiativbewerbung!</strong></p>
	</div>
<% end_if %>
