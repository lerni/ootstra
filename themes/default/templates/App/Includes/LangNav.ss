<% if $Locales %><menu class="lang-nav">
    <% loop $Locales %>
        <li class="lang $LinkingMode" >
            <a href="$Link.ATT" <% if $LinkingMode != 'invalid' || $LinkingMode != 'current' %>rel="alternate" hreflang="$LocaleRFC1766"<% end_if %>>
                $Title
            </a>
        </li>
    <% end_loop %>
</menu><% end_if %>
