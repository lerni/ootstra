<% if $SiteConfig.SocialLinks %>
	<div class="social-icons">
		<% loop $SiteConfig.SocialLinks.sort("SortOrder") %>
			<a class="socialize" target="_blank" rel="noopener" title="$Title" href="$Url"><img height="22" width="22" loading="lazy" src="/_resources/vendor/simple-icons/simple-icons/icons/{$IconName.LowerCase}.svg" alt="" /></a>
		<% end_loop %>
	</div>
<% end_if %>
