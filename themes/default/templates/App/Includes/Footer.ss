<% require themedCSS("dist/css/footer") %>
<footer>
	<div class="upper">
		<div class="inner">
			<div class="column logo">
				<a href="{$MyBaseURLForLocale}" title="$SiteConfig.Title (home)">
					<img src="$resourceURL('themes/default/dist/images/svg/oo.svg')" alt="$SiteConfig.Title">
				</a>
				<% if $SiteConfig.Locations.Count %>
					<% with $SiteConfig.Locations.First() %>
						<% if $OpeningHours %>
							<h3><%t Page.OpeningHours 'opening hours' %></h3>
							$OpeningHours.Markdowned
						<% end_if %>
					<% end_with %>
				<% end_if %>
				<% include App/Includes/Social %>
			</div>
			<div class="column coord">
				<% if $SiteConfig.Locations.Count %>
					<% with $SiteConfig.Locations.First() %>
						<span>$Title</span>
						<span>$Address</span>
						<span>$PostalCode $Town</span>
						<% if $Telephone %><a href="tel:{$Telephone.TelEnc}"><%t Page.TELEPHONE "T" %>&nbsp;$Telephone</a><% end_if %>
						<% if $EMail %><a href="mailto:{$EMail}">$EMail</a><% end_if %>
					<% end_with %>
				<% end_if %>
			</div>
			<div class="column inprint">
				<nav class="inprint">
					<% loop $SiteConfig.TermsNavigationItems.Sort("SortOrder ASC") %>
						<a class="{$LinkingMode}" href="{$Link}">$Title</a>
					<% end_loop %>
					<% if $SiteConfig.CookieIsActive %><a href="#klaro" onClick="klaro.show();return false;"><%t Kraftausdruck\KlaroCookie.MODALLINK "Cookie settings" %></a><% end_if %>
				</nav>
				<span class="copyright">
					© $Now.Format('y')
				</span>
			</div>
		</div>
	</div>
	<%-- <div class="lowest">
		<div class="inner">
			Some last claim
		</div>
	</div> --%>
</footer>
