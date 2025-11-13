<%-- vite 'src/css/perso-simple.css' --%>
<% vite 'src/css/perso.css' %>
<div class="typography">
	<% include App/Includes/ElementTitle %>
	<% if $GroupByDepartment %>
		<% loop $Departments.Sort("DepartmentsSortOrder") %>
			<h2>$Title</h2>
			<div class="expandable-grid persos">
				<% loop $Persos.Sort("SortOrder") %>
					<% include App/Includes/PersoItem Element=$Top %>
				<% end_loop %>
			</div>
		<% end_loop %>
	<% else %>
		<% if $Everybody %>
			<div class="expandable-grid persos">
				<% loop $Everybody %>
					<% include App/Includes/PersoItem Element=$Top %>
				<% end_loop %>
			</div>
		<% end_if %>
	<% end_if %>
</div>
