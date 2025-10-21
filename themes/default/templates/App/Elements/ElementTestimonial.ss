<% if $Items.Count > 1 %>
	<% require themedCSS("dist/css/swiper") %>
	<% require javascript("themes/default/dist/js/swiper.js") %>
<% end_if %>
<% if $ShowTitle %><div class="typography<% if $isFullWidth %> inner<% end_if %>"><% end_if %>
	<% include App/Includes/ElementTitle %>
<% if $ShowTitle %></div><% end_if %>
<div class="typography">
	<div class="inner">
		<% if $Items %>
		<div class="swiper-container testimonial" data-id="{$ID}" id="testimonial-swiper-{$ID}">
			<div class="swiper-wrapper testimonial">
				<% loop $Items %>
					<div class="swiper-slide">
						<blockquote><div class="larger"><p>{$Text}</p></div></blockquote>
						<p class="small">{$Title}</p>
					</div>
				<% end_loop %>
			</div>
		</div>
		<% end_if %>
		<% if $Items.Count > 1 %><div class="swiper-pagination testimonial" id="testimonial-swiper-pagination{$ID}"></div><% end_if %>
	</div>
</div>
