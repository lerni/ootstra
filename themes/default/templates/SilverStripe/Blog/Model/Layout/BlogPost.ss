<% include App/Includes/Header %>
<main class="typography" id="main">
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	$ElementalArea
	<%-- <div class="inner">
		<a href="$Parent.Link" class="parent-link back">$Parent.MenuTitle</a>
	</div> --%>
</main>
