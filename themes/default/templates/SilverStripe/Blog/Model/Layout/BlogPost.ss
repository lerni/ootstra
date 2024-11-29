<%-- require themedCSS("dist/css/blog") - those sytes are (pre)loaded per BlogInitExtension, but with htmX we laod em anyway --%>
<% require themedCSS("dist/css/blog") %>
<% include App/Includes/Header %>
<main>
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero %>
	<% end_if %>
	$ElementalArea
	<div class="prev-all-next inner">
		<% if $PrevNext('prev') %>
			<a href="{$PrevNext('prev').Link()}" class="prev">
				<img src="$PrevNext('prev').getDefaultOGImage(1).FocusFillMax(80,80).Convert('webp').URL" height="80" width="80" alt="$PrevNext('prev').Title" loading="lazy">
				<span>{$PrevNext('prev').Title}</span>
			</a>
		<% else %>
			<span class="prev"></span>
		<% end_if %>
		<a href="{$Parent.Link}" class="all-posts" title="Alle Artikel ({$Parent.Title})"></a>
		<% if $PrevNext('next') %>
			<a href="{$PrevNext('next').Link()}" class="next">
				<span>{$PrevNext('next').Title}</span>
				<img src="$PrevNext('next').getDefaultOGImage(1).FocusFillMax(80,80).Convert('webp').URL" height="80" width="80" alt="$PrevNext('next').Title" loading="lazy">
			</a>
		<% else %>
			<span class="next"></span>
		<% end_if %>
	</div>
</main>
