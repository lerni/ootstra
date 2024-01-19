<% cached 'navigation', $ID, $List('SilverStripe\CMS\Model\SiteTree').max('LastEdited'), $List('SilverStripe\CMS\Model\SiteTree').count() %>
	<% if $Menu(1) %>
	<button class="menu-button" id="menuButton" aria-controlls="menu1" aria-expanded="false">
		<span class="txt" ><%t Page.MENU "Menu" %></span>
		<span class="burger-icon" aria-hidden="true"></span>
	</button>
	<nav class="nav" aria-label="<%t Page.NavAriaLabel 'Menu' %>">
		<menu id="menu1" class="menu1">
			<% loop $Menu(1) %>
				<li class="$LinkingMode<% if $Childrenexcluded %> has-children<% end_if %><% if $LinkingMode == section %> expanded<% end_if %>">
					<a href="$Link"<% if $NewWindow %> target="_blank" rel="noopener"<% end_if %>>$MenuTitle.XML</a>
					<% if $Childrenexcluded %><span class="trigger"><span></span></span>
						<menu class="menu2">
							<% loop $Childrenexcluded %>
								<li class="$LinkingMode">
									<a href="$Link"<% if $NewWindow %> target="_blank" rel="noopener"<% end_if %>>$MenuTitle</a>
								</li>
							<% end_loop %>
						</menu>
					<% end_if %>
				</li>
			<% end_loop %>
		</menu>
	</nav>
	<% end_if %>
<% end_cached %>
