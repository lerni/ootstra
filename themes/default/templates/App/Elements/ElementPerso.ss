<%-- require themedCSS("dist/css/perso-simple") --%>
<% require themedCSS("dist/css/perso") %>
<div class="typography">
	<% include App/Includes/ElementTitle %>
	<% if $Everybody %>
		<% if $Sorting == "random" %>
			<div class="expandable-grid persos">
			<% loop $Everybody.Shuffle %>
				<% include App/Includes/PersoItem Element=$Top %>
			<% end_loop %>
			</div>
		<% else %>
			<% loop $Departments.Sort("Sort") %>
				<h2>$Title</h2>
				<div class="expandable-grid persos">
				<% loop $Persos.sort('SortOrder') %>
					<% include App/Includes/PersoItem Element=$Top %>
				<% end_loop %>
				</div>
			<% end_loop %>
		<% end_if %>
	<% end_if %>
</div>
