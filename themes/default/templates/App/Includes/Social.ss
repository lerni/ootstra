<% if $SiteConfig.SocialLinks %>
	<div class="social-icons">
		<% loop $SiteConfig.SocialLinks.sort("SortOrder") %>
			<a class="social-icon socialize" target="_blank" rel="noopener" title="$Title" href="$Url" style="mask-image: url('{$IconPath}')"></a>
		<% end_loop %>
	</div>
<% end_if %>
