<% vite 'src/css/perso.css', 'src/js/perso.js' %>
<div class="typography">
	<% include App/Includes/ElementTitle %>
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
</div>
