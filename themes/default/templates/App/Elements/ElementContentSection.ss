<div class="inner">
<% include App/Includes/ElementTitle %>
<% if $HTML %>$HTML<% end_if %>
<% if $ContentParts %>
	<div class="content-part" role="presentation">
		<% loop $ContentParts.Sort("SortOrder") %>
			<article class="flip">
				<header>
					<h3 class="flip">
						$Title
					</h3>
				</header>
				<div class="flip" style="display:none;" aria-expanded="false" role="region">
					$Text
				</div>
			</article>
		<% end_loop %>
	</div>
<% end_if %>
</div>