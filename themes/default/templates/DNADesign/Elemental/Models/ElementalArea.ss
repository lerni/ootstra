<% if $ElementControllers %>
	<% loop $ElementControllers %>
		<% if $AfterHero && $Page.hasHero %>
			<% if $SiteConfig.GlobalAlert %><article class="global-alert">
				<div class="inner">$SiteConfig.GlobalAlert</div>
			</article><% end_if %>
			<% if $Page.ClassName != 'SilverStripe\Blog\Model\BlogPost' %>
				<% with $Page %><% if $ParentID != 0 %><nav class="breadcrumbs"><div class="inner">{$Breadcrumbs}</div></nav><% end_if %><% end_with %>
			<% end_if %>
		<% end_if %>
		<% if $Page.ClassName == 'SilverStripe\Blog\Model\BlogPost' && $AfterHero %>
			<% with $Page %>
				<% if $CategoriesWithState %>
					<nav class="element blog-post-meta">
						<p class="cat-tag">
							<a href="$Parent.Link" class="all" title="$Parent.Title"><%t Blog.Allcategories "Alle" %></a>
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
