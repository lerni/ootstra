<% if $SiteConfig.SocialLinks %>
    <div class="social-icons">
        <% loop $SiteConfig.SocialLinks.sort("SortOrder") %>
			<a class="socialize" target="_blank" rel="noopener" title="$Title" href="$Url"><span data-feather="$Title.LowerCase"></span></a>
        <% end_loop %>
    </div>
<% end_if %>
