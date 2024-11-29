<a href="$Link" class="post-summary" title="$OGTitle" data-hx-boost="true">
	<% if $getDefaultOGImage(1).Exists() %><figure>
		<img
			height="$getDefaultOGImage(1).FocusFillMax(340,170).Height()"
			width="$getDefaultOGImage(1).FocusFillMax(340,170).Width()"
			src="$getDefaultOGImage(1).FocusFillMax(340,170).Convert('webp').URL"
			srcset="$getDefaultOGImage(1).FocusFillMax(340,170).Convert('webp').URL 1x,
				$getDefaultOGImage(1).FocusFillMax(680,340).Convert('webp').URL 2x"
			alt="{$Title} {$Caption}" />
	</figure><% end_if %>
	<div class="txt">
		<p class="pre">$PublishDate.Format('d. LLLL y')<% if $Authors %> | <% loop $Authors %>{$Name}<% if not $IsLast %>, <% end_if %><% end_loop %><% end_if %></p>
		<h2>
			<% if $MenuTitle %>
				$MenuTitle
			<% else %>
				$Title
			<% end_if %>
		</h2>
		<% if $Summary && $Summary.CountLink < 1 %>
			$Summary
		<% else_if $DefaultOGDescription %>
			<p>$DefaultOGDescription</p>
		<% end_if %>
		<span class="link forth"><%t SilverStripe\Blog\Model\Blog.MORE 'Read more' %></span>
	</div>
</a>
