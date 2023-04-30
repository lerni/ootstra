<% include App/Includes/Header %>
<main>
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	<article class="element spacing-top-2 spacing-bottom-1 width-reduced">
		<div class="typography horizontal-spacing">
			$Content
			$Form
		</div>
	</article>
</main>
