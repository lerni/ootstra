<% include App/Includes/Header %>
<main>
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	<article class="element spacing-top-2 width-reduced">
		<div class="typography">
			$Content
			$Form
		</div>
	</article>
</main>
