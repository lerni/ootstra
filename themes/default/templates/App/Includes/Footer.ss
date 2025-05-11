<% require themedCSS("dist/css/footer") %>
<footer>
	<div class="inner">
		<div class="column coord">
			<% if $SiteConfig.Locations.Count %>
				<% with $SiteConfig.Locations.First() %>
					<span><strong>$Title</strong></span>
					<span>$Address</span>
					<span>$PostalCode $Town</span>
					<% if $Telephone %><a href="tel:{$Telephone.TelEnc}"><%-- t Page.TELEPHONE "T" &nbsp;--%>$Telephone</a><% end_if %>
					<% if $EMail %><a href="mailto:{$EMail}">$EMail</a><% end_if %>
				<% end_with %>
			<% end_if %>
		</div>
		<div class="column social">
			<% include App/Includes/Social %>
		</div>
		<div class="column inprint">
			<nav class="inprint">
				<% loop $SiteConfig.TermsNavigationItems %>
					<a class="{$Page.LinkingMode}" href="{$URL}"<% if $OpenInNew %> target="_blank" rel="noopener noreferrer"<% end_if %>>$Title</a>
				<% end_loop %>
				<% if $SiteConfig.CookieIsActive %><a href="#klaro" onClick="klaro.show();return false;">{$SiteConfig.ConsentNoticeTitle}</a><% end_if %>
			</nav>
		</div>
	</div>
</footer>
