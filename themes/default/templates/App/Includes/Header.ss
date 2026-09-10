<header id="header">
	<div class="inner">
		<a class="logo" href="{$MyBaseURLForLocale}" aria-label="{$SiteConfig.Title} (home)">
			<img width="207" height="48" src="{$viteAsset('src/images/svg/stripecon-26.svg')}" alt="$SiteConfig.Title" />
		</a>
		<% include App/Includes/ServiceNavi %>
		<%-- include App/Includes/LangNav --%>
		$CachedNavigation<%-- include App/Includes/Navigation --%>
	</div>
</header>
