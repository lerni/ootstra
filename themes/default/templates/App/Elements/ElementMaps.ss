<% include App/Includes/ElementTitle %>
<% if $HTML %>
	<div class="txt typography">{$HTML}</div>
<% end_if %>
<div id="map_canvas"<% if $HTML %> class="has-txt"<% end_if %>></div>
