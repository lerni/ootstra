<% if $SiteConfig.SocialLinks %>
	<div class="social-icons">
		<% loop $SiteConfig.SocialLinks.sort("SortOrder") %>
			<a class="socialize" target="_blank" rel="noopener" title="$Title" href="$Url"><img loading="lazy" src="/_resources/vendor/simple-icons/simple-icons/icons/{$IconName.LowerCase}.svg" alt="" /></span></a>
		<% end_loop %>
	</div>
<% end_if %>
