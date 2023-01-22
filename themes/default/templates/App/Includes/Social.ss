<% if $SiteConfig.SocialLinks %>
	<div class="social-icons">
		<% loop $SiteConfig.SocialLinks.sort("SortOrder") %>
			<% if $Title == "WhatsApp" %>
				<a class="socialize" target="_blank" rel="noopener" title="WhatsApp" href="$Url"><span class="whatsapp"></span></a>
			<% else %>
				<a class="socialize" target="_blank" rel="noopener" title="$Title" href="$Url"><span data-feather="$IconName.LowerCase"></span></a>
			<% end_if %>
		<% end_loop %>
	</div>
<% end_if %>
