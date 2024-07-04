<% include App/Includes/ElementTitle %>
<div class="typography">
<% if $Items %>
	<% require themedCSS("dist/css/swiper") %>
	<% require javascript("themes/default/dist/js/swiper.js") %>
	<div class="swiper-container multiple" id="general-swiper-{$ID}">
		<div class="swiper-wrapper">
			<% loop $Items %>
				<a class="swiper-slide" href="$URL" title="{$Title}" target="_blank">
					<% with $PDFImage().ScaleMaxWidth(600) %>
						<img src="$URL" width="$Width()" height="$Height()" alt="{$Title}" />
					<% end_with %>
				</a>
			<% end_loop %>
		</div>
	</div>
<% end_if %>
</div>
