<div class="typography">
	<% include App/Includes/ElementTitle %>
	<% if $Everybody %>
		<% if $Sorting == "random" %>
			<article class="expandable-grid persos">
			<% loop $Everybody.sort('RAND()') %>
				<% include App/Includes/PersoItem ElementID=$Top.ID %>
			<% end_loop %>
			</article>
		<% else %>
			<% loop $Departments.Sort("Sort") %>
				<h2>$Title</h2>
				<article class="expandable-grid persos">
				<% loop $Persos.sort('SortOrder') %>
					<% include App/Includes/PersoItem ElementID=$Top.ID %>
				<% end_loop %>
				</article>
			<% end_loop %>
		<% end_if %>
	<% end_if %>
</div>
