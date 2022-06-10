<% include App/Includes/Header %>
<main class="typography">
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	<article class="element">
		$Content
		$Form
	</article>
</main>
