<% if $HTML %>
	<div class="txt typography">
		<% include App/Includes/ElementTitle %>
		{$HTML}
	</div>
<% end_if %>
<div id="map_canvas"<% if $HTML %> class="has-txt"<% end_if %>></div>
