<% vite 'src/css/textimage.css' %>
<% if $ShowTitle %><div class="typography<% if $isFullWidth %> inner<% end_if %>"><% end_if %>
	<% include App/Includes/ElementTitle %>
<% if $ShowTitle %></div><% end_if %>
<div class="typography">
	<div class="container">
		<div class="txt {$ElementLayout}">
			<% if $HTML %>{$HTML}<% end_if %>
		</div>
		<figure class="{$ElementLayout}<% if $ImageCover %> image-cover<% end_if %>">
			<% if $ImageID %>
				<% with $Image %>
					<img loading="lazy" alt="$Title" width="{$ScaleMaxWidth(800).Width()}" height="{$ScaleMaxWidth(800).Height()}"
						style="object-position: {$ScaleMaxWidth(800).FocusPoint.PercentageX}% {$ScaleMaxWidth(800).FocusPoint.PercentageY}%;"
						src="$ScaleMaxWidth(800).Convert('webp').URL"
						srcset="$ScaleMaxWidth(800).Convert('webp').URL 1x, $ScaleMaxWidth(1600).Convert('webp').URL 2x" />
				<% end_with %>
			<% end_if %>
		</figure>
	</div>
</div>
