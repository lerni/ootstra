<%-- require themedCSS("dist/css/blog") - those sytes are (pre)loaded per BlogInitExtension --%>
<% include App/Includes/Header %>
<main>
	<% if $Slides %>
		<article class="element elementhero spacing-bottom-2 full-width<% if $SiteConfig.GlobalAlert %>> global-alert<% end_if %>"><% include App/Includes/Slides %></article>
	<% else_if $SiteConfig.DefaultHeaderSlides.Count() %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	<% if $SiteConfig.GlobalAlert %><article class="global-alert">
		<div class="typography inner">$SiteConfig.GlobalAlert</div>
	</article><% end_if %>
	<% if $Content %><article class="element horizontal-spacing elementcontent">
		<div class="typography">$Content</div>
	</article><% end_if %>
	<% if $CategoriesWithState %>
		<nav class="element blog-post-meta horizontal-spacing">
			<p class="cat-tag">
				<a href="$Link" class="all<% if not $getCurrentCategory %> current<% end_if %>" title="<%t SilverStripe\Blog\Model\Blog.Allcategories %>"><%t SilverStripe\Blog\Model\Blog.Allcategories %></a>
				<% loop $CategoriesWithState %>
					<a href="$Link" class="$CustomLinkingMode" title="$Title" data-segment="$URLSegment">$Title</a>
				<% end_loop %>
			</p>
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
		<%--
		todo: this still needs SilverStripe\ORM\DB::query("SET SESSION sql_mode='REAL_AS_FLOAT,PIPES_AS_CONCAT,ANSI_QUOTES,IGNORE_SPACE';");
		if $YearlyArchive %>
			<div class="archive">
				<h3><%t SilverStripe\Blog\Model\Blog.Archive "Archiv" %></h3>
				<hr/>
				<a href="$Link" class="all<% if not getArchiveYear %> current<% end_if %>" title="Archive all"><%t SilverStripe\Blog\Model\Blog.Alle "Alle" %></a>
				<% loop $YearlyArchive %>
					<a <% if $Top.getArchiveYear ==  $Title %>class="current"<% end_if %> href="$Link" title="$Title">
						$Title
					</a>
				<% end_loop %>
			</div>
		<% end_if --%>
	</article>
</main>
