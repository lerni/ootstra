<% include App/Includes/ElementTitle %>
<div class="inner">
	<div class="txt {$ElementLayout}">
		<div class="relativizer">
			<div class="inner-txt">
				$HTML
			</div>
		</div>
	</div>
	<figure class="{$ElementLayout}<% if $ImageCover %> image-cover<% end_if %>">
		<% if $ImageID %>
			<% with $Image %>
				<img alt="$Title"
					style="object-position: {$ScaleMaxWidth(700).PercentageX}% {$ScaleMaxWidth(700).PercentageY}%;"
					src="$ScaleMaxWidth(700).URL"
					srcset="$ScaleMaxWidth(700).URL 1x, $ScaleMaxWidth(1400).URL 2x" />
			<% end_with %>
		<% end_if %>
	</figure>
</div>
