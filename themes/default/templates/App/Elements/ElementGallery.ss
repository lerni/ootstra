<% if not $isFullWidth %><div class="inner"><% end_if %>
<% include App/Includes/ElementTitle %>
<% if $CropGalleryTumbsByWidth %>
	<% if $Items %>
		<ul class="gallery {$Layout}">
			<% loop $Items %>
				<li>
					<a href="$ScaleMaxWidth(1224).URL" data-caption="$Caption" data-fancybox="group{$Top.FancyGroupRand}" data-fancybox="gallery">
						<%--<a data-caption="$Caption" data-fancybox="group{$Top.FancyGroupRand}" data-srcset="$ScaleMaxWidth(1500).URL 1500w, $ScaleMaxWidth(1200).URL 1200w, $ScaleMaxWidth(900).URL 900w, $ScaleMaxWidth(600).URL 600w" data-fancybox="gallery" data-type="image" >--%>
						<img width="$ScaleMaxHeight(130).Width()" height="$ScaleMaxHeight(130).Height()" src="$ScaleMaxHeight(130).URL" srcset="$ScaleMaxHeight(130).URL 1x, $ScaleMaxHeight(260).URL 2x" alt="$Caption" />
					</a>
				</li>
			<% end_loop %>
		</ul>
	<% end_if %>
<% else %>
	<% if $Items %>
		<ul class="gallery {$Layout}">
			<% loop $Items %>
				<li>
					<a href="$ScaleMaxWidth(1224).URL" data-caption="$Caption" data-fancybox="group{$Top.FancyGroupRand}" data-fancybox="gallery">
						<%--<a data-caption="$Caption" data-fancybox="group{$Top.FancyGroupRand}" data-srcset="$ScaleMaxWidth(1500).URL 1500w, $ScaleMaxWidth(1200).URL 1200w, $ScaleMaxWidth(900).URL 900w, $ScaleMaxWidth(600).URL 600w" data-fancybox="gallery" data-type="image" >--%>
						<img width="$FocusFillMax(250,187).Width()" height="$FocusFillMax(250,187).Height()" src="$FocusFillMax(250,187).URL" srcset="$FocusFillMax(250,187).URL 1x, $FocusFillMax(500,374).URL 2x" alt="$Caption" />
					</a>
				</li>
			<% end_loop %>
		</ul>
	<% end_if %>
<% end_if %>
<% if not $isFullWidth %></div><% end_if %>
