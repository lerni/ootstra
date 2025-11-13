<% vite 'src/css/cards.css' %>
<div class="typography">
	<div class="txt">
		<% include App/Includes/ElementTitle %>
	</div>
	<% if $PDFDocs %>
		<% if $ShowAsSlider %>
			<% vite 'src/css/swiper.css', 'src/js/swiper.js' %>
			<div class="swiper-container teaser" id="general-swiper-{$ID}">
				<div class="swiper-wrapper cards {$Layout}">
		<% else %>
			<div class="cards {$Layout}">
		<% end_if %>
		<% loop $PDFDocs.Sort(PDFSortOrder) %>
			<a href="$Document.URL" class="card swiper-slide" title="{$Title}" target="_blank">
				<figure>
					<% with $ImageWithFallback.FillMax(414, 414) %>
						<img src="$URL" width="$Width()" height="$Height()" alt="{$Up.Title}" />
					<% end_with %>
					<% if $Text %><figcaption>
						<span class="lead-text">{$Text.XML}<span>
					</figcaption><% end_if %>
				</figure>
				<header>{$Title}</header>
			</a>
		<% end_loop %>
		</div><% if $ShowAsSlider %></div><% end_if %>
	<% end_if %>
</div>
