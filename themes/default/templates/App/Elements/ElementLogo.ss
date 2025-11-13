<% vite 'src/css/logo.css' %>
<% if $ShowTitle %><div class="typography<% if $isFullWidth %> inner<% end_if %>"><% end_if %>
	<% include App/Includes/ElementTitle %>
<% if $ShowTitle %></div><% end_if %>
<% if $Items %>
	<% if $Layout == "slider" %>
		<% vite 'src/css/swiper.css', 'src/js/swiper.js' %>
		<div class="swiper-container logo" data-id="{$ID}" id="logo-swiper-{$ID}">
			<ul class="swiper-wrapper logos<% if $Greyscale %> greyscale<% end_if %>">
				<% loop $Items %>
					<li class="logo swiper-slide<% if $Link %> has-link<% end_if %>">
						<% if $Link %><a title="<% if $Title %>$Title<% else %>$LogoImage.Title<% end_if %>" href="$Link" target="_blank" rel="noopener"><% end_if %>
							<figure>
								<img<% if not $IsFirst %> loading="lazy"<% end_if %> height="$LogoImage.ScaleMaxHeight(75).Height()" width="$LogoImage.ScaleMaxHeight(75).Width()" src="$LogoImage.ScaleMaxHeight(75).Convert('webp').URL" srcset="$LogoImage.ScaleMaxHeight(75).Convert('webp').URL 1x, $LogoImage.ScaleMaxHeight(150).Convert('webp').URL 2x" alt="<% if $Title %>$Title<% else %>$LogoImage.Title<% end_if %>" />
							</figure>
							<% if $Link %></a>
						<% end_if %>
					</li>
				<% end_loop %>
			</ul>
		</div>
	<% else %>
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
<% end_if %>
