<% include App/Includes/Header %>
<main>
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	$ElementalArea
</main>
