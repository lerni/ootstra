<% vite 'src/css/perso.css', 'src/js/perso.js' %>
<div class="typography">
	<% cached 'perso', $ID, $CacheKey %>
		<% include App/Includes/ElementTitle %>
		<% if $GroupByDepartment %>
			<% loop $Departments.Sort("DepartmentsSortOrder") %>
				<h2>$Title</h2>
				<div class="persos">
					<% loop $Persos.Sort('SortOrder ASC') %>
						<% include App/Includes/PersoItem Element=$Top %>
					<% end_loop %>
				</div>
			<% end_loop %>
		<% else %>
			<% if $Everybody %>
				<nav class="cat-tag">
					<button class="all" title="<%t App\Elements\ElementPerso.AllDepartments "All" %>"><%t App\Elements\ElementPerso.AllDepartments "All" %></button>
					<% loop $Departments.Sort('DepartmentsSortOrder ASC') %>
						<a href="#{$Title.URLEnc}" class="$CustomLinkingMode" title="$Title" data-segment="$Title.URLEnc">$Title</a>
					<% end_loop %>
				</nav>
				<div class="persos">
					<% loop $Everybody %>
						<% include App/Includes/PersoItem Element=$Top %>
					<% end_loop %>
				</div>
			<% end_if %>
		<% end_if %>
	<% end_cached %>
</div>
