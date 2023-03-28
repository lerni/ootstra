<% cached 'navigation', $ID, $List('SilverStripe\CMS\Model\SiteTree').max('LastEdited'), $List('SilverStripe\CMS\Model\SiteTree').count() %><% if $Menu(1) %>
<nav class="nav">
	<ul class="menu1">
		<% loop $Menu(1) %>
			<li class="$LinkingMode<% if $Childrenexcluded %> has-children<% end_if %><% if $LinkingMode == section %> expanded<% end_if %>">
				<a href="$Link">$MenuTitle.XML</a><% if $Childrenexcluded %><span class="trigger"></span><% end_if %>
				<% if $Childrenexcluded %>
					<ul class="menu2">
						<% loop $Childrenexcluded %>
							<li class="$LinkingMode">
    							<a class="$LinkingMode" href="$Link">$MenuTitle</a>
							</li>
						<% end_loop %>
					</ul>
				<% end_if %>
			</li>
		<% end_loop %>
	</ul>
</nav>
<a href="#" class="menu-button" id="menuButton" aria-label="Navigation">
	<span class="txt"><%t Page.MENU "Menu" %></span><span class="burger-icon"></span>
</a>
<% end_if %><% end_cached %>
