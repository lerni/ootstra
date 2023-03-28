<% require themedCSS("dist/css/gallery") %>
<% require themedCSS("dist/css/fancy") %>
<% require javascript("themes/default/dist/js/fancy.js") %>
<% if $isFullWidth && $ShowTitle %><div class="typography inner"><% end_if %>
	<% include App/Includes/ElementTitle %>
<% if isFullWidth %></div><% end_if %>
<% if $Items %>
	<% if $Layout == "slider" %>
		<div class="swiper-container multiple" data-id="{$ID}" id="multiple-swiper-{$ID}">
			<div class="swiper-wrapper multiple">
				<% loop $Items %>
					<a href="$ScaleMaxWidth(1224).URL"
						class="swiper-slide"
						data-type="image"
						data-caption="$Caption"
						data-fancybox="group{$Top.FancyGroupRand}"
						data-srcset="$ScaleMaxWidth(1224).URL 1224w,
							$ScaleMaxWidth(900).URL 900w,
							$ScaleMaxWidth(600).URL 600w"
						data-width="$ScaleMaxWidth(1224).Width"
						data-height="$ScaleMaxWidth(1224).Height">
							<img <% if not $First %>loading="lazy" <% end_if %> width="$ScaleMaxHeight(600).Width()" height="$ScaleMaxHeight(600).Height()" src="$ScaleMaxHeight(600).URL" alt="$Title" />
					</a>
				<% end_loop %>
			</div>
		</div>
	<% else_if $Layout == "flex" %>
		<ul class="gallery {$Layout} {$Alignment}">
			<% loop $Items %>
				<li>
					<a href="$ScaleMaxWidth(1224).URL"
						data-type="image"
						data-caption="$Caption"
						data-fancybox="group{$Top.FancyGroupRand}"
						data-srcset="$ScaleMaxWidth(1224).URL 1224w,
							$ScaleMaxWidth(900).URL 900w,
							$ScaleMaxWidth(600).URL 600w"
						data-width="$ScaleMaxWidth(1224).Width"
						data-height="$ScaleMaxWidth(1224).Height">
						<img<% if not $First %> loading="lazy"<% end_if %> width="$ScaleMaxHeight(130).Width()" height="$ScaleMaxHeight(130).Height()" src="$ScaleMaxHeight(130).URL" srcset="$ScaleMaxHeight(130).URL 1x, $ScaleMaxHeight(260).URL 2x" alt="$Title" />
					</a>
				</li>
			<% end_loop %>
		</ul>
	<% else %>
		<ul class="gallery {$Layout} {$Alignment}">
			<% loop $Items %>
				<li>
					<a href="$ScaleMaxWidth(1224).URL"
						data-type="image"
						data-caption="$Caption"
						data-fancybox="group{$Top.FancyGroupRand}"
						data-srcset="$ScaleMaxWidth(1224).URL 1224w,
							$ScaleMaxWidth(900).URL 900w,
							$ScaleMaxWidth(600).URL 600w"
						data-width="$ScaleMaxWidth(1224).Width"
						data-height="$ScaleMaxWidth(1224).Height">
						<img<% if not $First %> loading="lazy"<% end_if %> width="$FocusFillMax(250,187).Width()" height="$FocusFillMax(250,187).Height()" src="$FocusFillMax(250,187).URL" srcset="$FocusFillMax(250,187).URL 1x, $FocusFillMax(500,374).URL 2x" alt="$Title" />
					</a>
				</li>
			<% end_loop %>
		</ul>
	<% end_if %>
<% end_if %>
