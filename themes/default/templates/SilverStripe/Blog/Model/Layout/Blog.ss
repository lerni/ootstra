<%-- require themedCSS("dist/css/blog") - those sytes are (pre)loaded per BlogInitExtension --%>
<% include App/Includes/Header %>
<main>
	<% if $Slides %>
		<article class="element elementhero spacing-bottom-2<% if $SiteConfig.GlobalAlert %>> global-alert<% end_if %>"><% include App/Includes/Slides %></article>
	<% else_if $SiteConfig.DefaultHeaderSlides.Count() %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	<% if $SiteConfig.GlobalAlert %><article class="global-alert horizontal-spacing">
		<div class="inner">$SiteConfig.GlobalAlert</div>
	</article><% end_if %>
	<% if $Content %><article class="element horizontal-spacing elementcontent">
		<div class="typography">$Content</div>
	</article><% end_if %>
	<% if $CategoriesWithState %>
		<nav class="element blog-post-meta horizontal-spacing">
			<div class="typography">
				<p class="cat-tag">
					<a href="$Link" <%-- up-target="#main >.typography" --%>class="all<% if not $getCurrentCategory %> current<% end_if %>" title="<%t SilverStripe\Blog\Model\Blog.Allcategories %>"><%t SilverStripe\Blog\Model\Blog.Allcategories %></a>
					<% loop $CategoriesWithState %>
						<a href="$Link" class="$CustomLinkingMode" title="$Title" <%-- up-target="#main >.typography" href="$Link" --%>data-segment="$URLSegment">$Title</a>
					<% end_loop %>
				</p>
			</div>
		</nav>
	<% end_if %>
	<article class="element posts horizontal-spacing">
		<% if $PaginatedList.Exists %>
			<% loop $PaginatedList %>
				<% include SilverStripe/Blog/PostSummary %>
			<% end_loop %>
		<% else %>
			<div class="post-summary nopost">
				<p><%t SilverStripe\Blog\Model\Blog.NoPosts 'There are no posts' %></p>
			</div>
		<% end_if %>
		<% with $PaginatedList %>
			<% include SilverStripe/Blog/Pagination %>
		<% end_with %>
	</article>
</main>
