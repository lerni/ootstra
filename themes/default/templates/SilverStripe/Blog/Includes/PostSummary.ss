<a href="$Link" class="post-summary">
	<% if $getOGImage() %><figure>
		<img src="$getOGImage().FocusFillMax(340,170).URL" srcset="$getOGImage().FocusFillMax(340,170).URL 1x, $getOGImage().FocusFillMax(680,340).URL 2x" alt="$Title" />
	</figure><% end_if %>
	<div class="txt">
		<p>$PublishDate.Format('d. LLLL y')<% if $Authors %> | <% loop $Authors %>{$Name}<% if not $Last %>, <% end_if %><% end_loop %><% end_if %></p>
		<h3>
			<% if $MenuTitle %>
				$MenuTitle
			<% else %>
				$Title
			<% end_if %>
		</h3>
		<% if $Summary %>
			$Summary
		<% else %>
			<p>$DefaultOGDescription</p>
		<% end_if %>
		<span class="pseudolink"><%t SilverStripe\Blog\Model\Blog.MORE "Weiterlesen" %></span>
	</div>
</a>
