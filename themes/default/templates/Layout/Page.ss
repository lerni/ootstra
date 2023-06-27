<% include App/Includes/Header %>
<main>
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	<article class="element default horizontal-spacing spacing-top-1 spacing-bottom-1 width-reduced after-hero">
		<div class="typography">
			<h1 class="element-title">$Title</h1>
			$Content
			$Form
		</div>
	</article>
</main>
