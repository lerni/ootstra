<header id="header">
	<div class="inner">
		<div class="column logo">
			<a href="{$MyBaseURLForLocale}" aria-label="{$SiteConfig.Title} (home)">
				<img width="342" height="68" src="$resourceURL('themes/default/dist/images/svg/logo.svg')" alt="$SiteConfig.Title" />
			</a>
		</div>
		<nav class="column nav">
			<% include App/Includes/ServiceNavi %>
			<%-- include App/Includes/LangNav --%>
			<% include App/Includes/Navigation %>
		</nav>
	</div>
</header>
