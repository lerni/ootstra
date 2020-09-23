<% if $SiteConfig.SocialLinks %>
    <div class="social-icons">
        <% loop $SiteConfig.SocialLinks.sort("SortOrder") %>
            <% if $RelatedPageID %>
                <a class="socialize $FirstLast" title="$Title" data-social-short="$Icon" href="$RelatedPage.Link">$Icon</a>
            <% else %>
                <a class="socialize $FirstLast" target="_blank" rel="noopener" title="$Title" data-social-short="$Icon" href="$Url">$Icon</a>	
            <% end_if %>
        <% end_loop %>
    </div>
<% end_if %>