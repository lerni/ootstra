<% if $ElementControllers %>
	<% loop $ElementControllers %>
		<% if $AfterHero && $Page.hasHero %>
			<% if $SiteConfig.GlobalAlert %><article class="global-alert">
				<div class="typography inner">{$SiteConfig.GlobalAlert}</div>
			</article><% end_if %>
			<% with $Page %><% if $ClassName != 'SilverStripe\Blog\Model\BlogPost' && $ClassName != 'SilverStripe\Blog\Model\Blog' && $ParentID %>
				<nav class="breadcrumbs"><div class="inner">{$Breadcrumbs}</div></nav>
			<% end_if %><% end_with %>
			<% if $Page.ClassName == 'SilverStripe\Blog\Model\BlogPost' %>
				<% include App/Includes/BlogCategories Page=$Page %>
			<% end_if %>
		<% end_if %>
		$Me
	<% end_loop %>
<% end_if %>
