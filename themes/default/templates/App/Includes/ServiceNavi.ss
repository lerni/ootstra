<% if $SiteConfig.ServiceNavigationItems %><menu class="service-nav">
    <% loop $SiteConfig.ServiceNavigationItems %>
        <li class="$Page.LinkingMode"><a href="$URL"<% if $OpenInNew %> target="_blank" rel="noopener noreferrer"<% end_if %>>$Title</a></li>
    <% end_loop %>
</menu><% end_if%>
