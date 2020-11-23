<% include App/Includes/Header %>
<main class="typography" id="main">
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	$ElementalArea

		<% if $PrevNext('prev') %><a href="{$PrevNext('prev').Link()}" class="prev">{$PrevNext('prev').Title}</a><% end_if %>
		<% if $PrevNext('next') %><a href="{$PrevNext('next').Link()}" class="next">{$PrevNext('next').Title}</a><% end_if %>

	<%-- <div class="inner">
		<a href="$Parent.Link" class="parent-link back">$Parent.MenuTitle</a>
	</div> --%>
</main>
