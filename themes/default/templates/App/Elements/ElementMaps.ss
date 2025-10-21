<% if $ShowTitle %><div class="typography<% if $isFullWidth %> inner<% end_if %>"><% end_if %>
	<% include App/Includes/ElementTitle %>
<% if $ShowTitle %></div><% end_if %>
<% if $HTML %>
	<div class="txt typography">
		<% if not $isFullWidth == 0 %>
			<% include App/Includes/ElementTitle %>
		<% end_if %>
		{$HTML}
	</div>
<% end_if %>
<div id="map_canvas"<% if $HTML %> class="has-txt"<% end_if %>></div>
