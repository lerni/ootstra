<% include App/Includes/Header %>
<main class="typography" id="main">
	<% if $Slides %>
		<article class="element elementhero spacing-bottom-2<% if $SiteConfig.GlobalAlert %>> global-alert<% end_if %>"><% include App/Includes/Slides %></article>
	<% else %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	<% if $SiteConfig.GlobalAlert %><article class="global-alert">
		<div class="inner">$SiteConfig.GlobalAlert</div>
	</article><% end_if %>
	<% if $Content %><article class="element elementcontent">
		<div class="typography inner">$Content</div>
	</article><% end_if %>
	<% if $CategoriesWithState %>
		<nav class="element blog-post-meta">
			<p class="cats">
				<a href="$Link" <%-- up-target="#main >.typography" --%>class="all<% if not $getCurrentCategory %> current<% end_if %>" title="<%t SilverStripe\Blog\Model\Blog.Alle "Alle" %>"><%t SilverStripe\Blog\Model\Blog.Alle "Alle" %></a>
				<% loop $CategoriesWithState %>
					<a href="$Link" class="$CustomLinkingMode" title="$Title" <%-- up-target="#main >.typography" href="$Link" --%>data-segment="$URLSegment">$Title</a>
				<% end_loop %>
			</p>
		</nav>
	<% end_if %>
	<div class="inner">
		<article class="element posts">
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
	</div>
</main>
