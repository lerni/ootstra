<menu class="service-nav">
    <% loop $SiteConfig.ServiceNavigationItems.Sort("SortOrder ASC") %>
        <li class="$LinkingMode">$Me</li>
    <% end_loop %>
</menu>
