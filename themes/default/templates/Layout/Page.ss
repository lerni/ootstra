<% include App/Includes/Header %>
<main class="typography">
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	<article class="element">
		<div class="inner">
			$Content
			$Form
		</div>
	</article>
</main>
