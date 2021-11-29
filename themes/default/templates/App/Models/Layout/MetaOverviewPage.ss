<% include App/Includes/Header %>
<main class="typography">
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	<div class="inner">
		<% loop $MetaOverview %>
			<% include App/Includes/MetaItem %>
		<% end_loop %>
	</div>
</main>
