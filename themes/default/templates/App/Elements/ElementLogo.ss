<% if not $isFullWidth %><div class="inner"><% end_if %>
	<% include App/Includes/ElementTitle %>
	<% if $Logos %>
		<ul class="logos<% if $Greyscale %> greyscale<% end_if %>">
			<% loop $Logos.Sort("SortOrder") %>
				<% if $LogoImageID %>
					<li class="logo<% if $Link %> has-link<% end_if %>">
						<% if $Link %><a href="$Link" target="_blank" rel="noopener"><% end_if %>
						<figure>
							<img height="$LogoImage.ScaleMaxHeight(80).Height()" width="$LogoImage.ScaleMaxHeight(80).Width()" src="$LogoImage.ScaleMaxHeight(80).URL" srcset="$LogoImage.ScaleMaxHeight(80).URL 1x, $LogoImage.ScaleMaxHeight(160).URL 2x" alt="<% if $Title %>$Title<% else %>$LogoImage.Title<% end_if %>" />
						</figure>
						<% if $Link %></a><% end_if %>
					</li>
				<% end_if %>
			<% end_loop %>
		</ul>
	<% end_if %>
<% if not $isFullWidth %></div><% end_if %>
