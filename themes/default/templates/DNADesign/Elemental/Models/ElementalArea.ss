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
		<% if $IsFirst && $Page.Parent.ClassName == 'App\Models\HolderPage' %>
			<% with $Page.Parent %>
			<nav class="element blog-post-meta horizontal-spacing">
				<p class="cat-tag">
					<a href="$Link" class="all" title="<%t SilverStripe\Blog\Model\Blog.Alle "Alle" %>"><%t Blog.Alle "Alle" %></a>
					<% loop $CategoriesWithState %>
						<a href="{$Up.Link}?tags={$URLSegment}" class="$CustomLinkingMode" title="$Title" data-segment="$URLSegment">$Title</a>
					<% end_loop %>
				</p>
			</nav>
			<% end_with %>
		<% end_if %>
		$Me
	<% end_loop %>
<% end_if %>
