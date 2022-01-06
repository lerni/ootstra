<% include App/Includes/ElementTitle %>
<div class="txt {$ElementLayout}">
	<div class="relativizer">
		<% if $HTML %>
			<div class="inner-txt">
				$HTML
			</div>
		<% end_if %>
	</div>
</div>
<figure class="{$ElementLayout}<% if $ImageCover %> image-cover<% end_if %>">
	<% if $ImageID %>
		<% with $Image %>
			<img alt="$Title" width="{$ScaleMaxWidth(800).Width()}" height="{$ScaleMaxWidth(800).Height()}"
				style="object-position: {$ScaleMaxWidth(800).FocusPoint.PercentageX}% {$ScaleMaxWidth(800).FocusPoint.PercentageY}%;"
				src="$ScaleMaxWidth(800).URL"
				srcset="$ScaleMaxWidth(800).URL 1x, $ScaleMaxWidth(1600).URL 2x" />
		<% end_with %>
	<% end_if %>
</figure>
