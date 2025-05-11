<% require themedCSS("dist/css/logo") %>
<% if $isFullWidth && $ShowTitle %><div class="typography inner"><% end_if %>
	<% include App/Includes/ElementTitle %>
<% if isFullWidth %></div><% end_if %>
<% if $Items %>
	<ul class="logos<% if $Greyscale %> greyscale<% end_if %>">
		<% loop $Items %>
			<% if $LogoImageID %>
				<li class="logo<% if $Link %> has-link<% end_if %>">
					<% if $Link %><a class="prevent-hover" title="<% if $Title %>$Title<% else %>$LogoImage.Title<% end_if %>" href="$Link" target="_blank" rel="noopener"><% end_if %>
					<figure>
						<img<% if not $IsFirst %> loading="lazy"<% end_if %> height="$LogoImage.ScaleMaxHeight(80).Height()" width="$LogoImage.ScaleMaxHeight(80).Width()" src="$LogoImage.ScaleMaxHeight(80).Convert('webp').URL" srcset="$LogoImage.ScaleMaxHeight(80).Convert('webp').URL 1x, $LogoImage.ScaleMaxHeight(160).Convert('webp').URL 2x" alt="<% if $Title %>$Title<% else %>$LogoImage.Title<% end_if %>" />
					</figure>
					<% if $Link %></a><% end_if %>
				</li>
			<% end_if %>
		<% end_loop %>
	</ul>
<% end_if %>
