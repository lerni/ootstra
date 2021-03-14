<div class="inner">
<% include App/Includes/ElementTitle %>
<% if $HTML %>$HTML<% end_if %>
<% if $ContentParts %>
	<% if $Layout == "Accordion" %>
		<div class="content-part accordion" role="presentation">
			<% loop $ContentParts.Sort("SortOrder") %>
				<article class="flip">
					<header>
						<% if $ShowTitle %><h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %> class="flip">$Title</h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>><% end_if %>
					</header>
					<div class="flip" style="display:none;" aria-expanded="false" role="region">
						$Text
					</div>
				</article>
			<% end_loop %>
		</div>
	<% else %>
		<div class="content-part text-blocks">
			<% loop $ContentParts.Sort("SortOrder") %>
				<article>
					<% if $ShowTitle %><h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>>$Title</h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>><% end_if %>
					$Text
				</article>
			<% end_loop %>
		</div>
	<% end_if %>
<% end_if %>
</div>
