<% require css("themes/default/thirdparty/fancybox/jquery.fancybox.min.css") %>
<% require javascript("themes/default/thirdparty/fancybox/jquery.fancybox.min.js") %>
<% if not $isFullWidth %><div class="inner"><% end_if %>
<% include App/Includes/ElementTitle %>
<% if $Items %>
	<ul class="gallery {$Layout}">
		<% if $CropGalleryThumbsByWidth %>
			<% loop $Items %>
				<li>
					<a href="$ScaleMaxWidth(1224).URL"
						data-type="image"
						data-caption="$Caption"
						data-fancybox="group{$Top.FancyGroupRand}"
						data-srcset="$ScaleMaxWidth(1224).URL 1224w,
							$ScaleMaxWidth(900).URL 900w,
							$ScaleMaxWidth(600).URL 600w"
						data-width="$ScaleMaxWidth(900).Width"
						data-height="$ScaleMaxWidth(900).Height">
						<img width="$ScaleMaxHeight(130).Width()" height="$ScaleMaxHeight(130).Height()" src="$ScaleMaxHeight(130).URL" srcset="$ScaleMaxHeight(130).URL 1x, $ScaleMaxHeight(260).URL 2x" alt="$Caption" />
					</a>
				</li>
			<% end_loop %>
		<% else %>
			<% loop $Items %>
				<li>
					<a href="$ScaleMaxWidth(1224).URL"
						data-type="image"
						data-caption="$Caption"
						data-fancybox="group{$Top.FancyGroupRand}"
						data-srcset="$ScaleMaxWidth(1224).URL 1224w,
							$ScaleMaxWidth(900).URL 900w,
							$ScaleMaxWidth(600).URL 600w"
						data-width="$ScaleMaxWidth(900).Width"
						data-height="$ScaleMaxWidth(900).Height">
						<img width="$FocusFillMax(250,187).Width()" height="$FocusFillMax(250,187).Height()" src="$FocusFillMax(250,187).URL" srcset="$FocusFillMax(250,187).URL 1x, $FocusFillMax(500,374).URL 2x" alt="$Caption" />
					</a>
				</li>
			<% end_loop %>
		<% end_if %>
	</ul>
<% end_if %>
<% if not $isFullWidth %></div><% end_if %>
