<div class="typography">
	<% if $isFullWidth && $ShowTitle %><div class="inner"><% end_if %>
		<% include App/Includes/ElementTitle %>
	<% if isFullWidth %></div><% end_if %>
	<% if $Items %>
		<ul class="doc">
			<% loop $Items %>
				<li><a href="$URL" class="download" target="_blank" rel="noopener">{$Title}</a></li>
			<% end_loop %>
		</ul>
	<% end_if %>
</div>
