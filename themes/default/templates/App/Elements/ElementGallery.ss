<% vite 'src/css/gallery.css' ,'src/css/fancy.css', 'src/js/fancy.js' %>
<% if $ShowTitle %><div class="typography<% if $isFullWidth %> inner<% end_if %>"><% end_if %>
	<% include App/Includes/ElementTitle %>
<% if $ShowTitle %></div><% end_if %>
<% if $Items %>
	<% if $Layout == "slider" %>
		<% vite 'src/css/swiper.css', 'src/js/swiper.js' %>
		<div class="swiper multiple" id="general-swiper-{$ID}">
			<div class="swiper-wrapper multiple">
				<% loop $Items %>
					<a href="$ScaleMaxWidth(1224).Convert('avif').URL"
						class="swiper-slide"
						data-type="image"
						data-caption="$Caption"
						data-fancybox="group{$Top.FancyGroupRand}"
						data-srcset="$ScaleMaxWidth(1224).Convert('avif').URL 1224w,
							$ScaleMaxWidth(900).Convert('avif').URL 900w,
							$ScaleMaxWidth(600).Convert('avif').URL 600w"
						data-width="$ScaleMaxWidth(1224).Width"
						data-height="$ScaleMaxWidth(1224).Height">
							<img<% if not $IsFirst %> loading="lazy" <% end_if %> width="$ScaleMaxHeight(600).Width()" height="$ScaleMaxHeight(600).Height()" src="$ScaleMaxHeight(600).Convert('avif').URL" alt="$Title" />
					</a>
				<% end_loop %>
			</div>
		</div>
	<% else_if $Layout == "flex" %>
		<ul class="gallery {$Layout} {$Alignment}">
			<% loop $Items %>
				<li>
					<a href="$ScaleMaxWidth(1224).Convert('avif').URL"
						data-type="image"
						data-caption="$Caption"
						data-fancybox="group{$Top.FancyGroupRand}"
						data-srcset="$ScaleMaxWidth(1224).Convert('avif').URL 1224w,
							$ScaleMaxWidth(900).Convert('avif').URL 900w,
							$ScaleMaxWidth(600).Convert('avif').URL 600w"
						data-width="$ScaleMaxWidth(1224).Width"
						data-height="$ScaleMaxWidth(1224).Height">
						<img<% if not $IsFirst %> loading="lazy"<% end_if %> width="$ScaleMaxHeight(130).Width()" height="$ScaleMaxHeight(130).Height()" src="$ScaleMaxHeight(130).Convert('avif').URL" srcset="$ScaleMaxHeight(130).Convert('avif').URL 1x, $ScaleMaxHeight(260).Convert('avif').URL 2x" alt="$Title" />
					</a>
				</li>
			<% end_loop %>
		</ul>
	<% else %>
		<ul class="gallery {$Layout} {$Alignment}">
			<% loop $Items %>
				<li>
					<a href="$ScaleMaxWidth(1224).Convert('avif').URL"
						data-type="image"
						data-caption="$Caption"
						data-fancybox="group{$Top.FancyGroupRand}"
						data-srcset="$ScaleMaxWidth(1224).Convert('avif').URL 1224w,
							$ScaleMaxWidth(900).Convert('avif').URL 900w,
							$ScaleMaxWidth(600).Convert('avif').URL 600w"
						data-width="$ScaleMaxWidth(1224).Width"
						data-height="$ScaleMaxWidth(1224).Height">
						<img<% if not $IsFirst %> loading="lazy"<% end_if %> width="$FocusFillMax(250,187).Width()" height="$FocusFillMax(250,187).Height()" src="$FocusFillMax(250,187).Convert('avif').URL" srcset="$FocusFillMax(250,187).Convert('avif').URL 1x, $FocusFillMax(500,374).Convert('avif').URL 2x" alt="$Title" />
					</a>
				</li>
			<% end_loop %>
		</ul>
	<% end_if %>
<% end_if %>
