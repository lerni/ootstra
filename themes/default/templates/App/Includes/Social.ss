<% if $SiteConfig.SocialLinks %>
    <div class="social-icons">
        <% loop $SiteConfig.SocialLinks.sort("SortOrder") %>
            <a class="socialize" target="_blank" rel="noopener" title="$Title" data-social-short="$Icon" href="$Url">$Icon</a>
        <% end_loop %>
    </div>
<% end_if %>
