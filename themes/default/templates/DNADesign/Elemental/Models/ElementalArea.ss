<% if $ElementControllers %>
	<% loop $ElementControllers %>
		<% if $AfterHero && $Page.hasHero %>
			<% if $SiteConfig.GlobalAlert %><article class="global-alert">
				<div class="typography inner">{$SiteConfig.GlobalAlert}</div>
			</article><% end_if %>
			<% with $Page %><% if $ClassName != 'SilverStripe\Blog\Model\BlogPost' && $ParentID %>
				<nav class="breadcrumbs"><div class="inner">{$Breadcrumbs}</div></nav>
			<% end_if %><% end_with %>
		<% end_if %>
		<% if $Page.ClassName == 'SilverStripe\Blog\Model\BlogPost' && $AfterHero %>
			<% with $Page %>
				<% if $CategoriesWithState %>
					<nav class="element blog-post-meta horizontal-spacing">
						<p class="cat-tag">
							<a href="$Parent.Link" class="all" title="$Parent.Title"><%t SilverStripe\Blog\Model\Blog.Allcategories %></a>
							<% loop $CategoriesWithState %>
								<a href="$Link" class="$CustomLinkingMode" title="$Title" data-segment="$URLSegment">$Title</a>
							<% end_loop %>
						</p>
					</nav>
				<% end_if %>
			<% end_with %>
		<% end_if %>
		$Me
	<% end_loop %>
<% end_if %>
