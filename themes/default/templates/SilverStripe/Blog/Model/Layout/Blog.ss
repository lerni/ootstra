<%-- vite 'src/css/blog") - those sytes are (pre)loaded per BlogInitExtension, but with htmX we laod em anyway --%>
<% vite 'src/css/blog.css' %>
<% include App/Includes/Header %>
<main class="typography">
	<% if $Slides %>
		<article class="element elementhero spacing-bottom-2 full-width<% if $CategoriesWithState %> breadcrumbs<% end_if %><% if $SiteConfig.GlobalAlert %> global-alert<% end_if %>">
			<% include App/Includes/Slides %>
		</article>
		<% if $SiteConfig.GlobalAlert %><article class="global-alert">
			<div class="typography inner">$SiteConfig.GlobalAlert</div>
		</article><% end_if %>
		<% include App/Includes/BlogCategories Page=$Me %>
	<% else_if $SiteConfig.DefaultHeaderSlides.Count() %>
		<% include App/Includes/DefaultHero %>
	<% end_if %>
	<% if $Content %><article class="element horizontal-spacing elementcontent">
		<div class="typography">$Content</div>
	</article><% end_if %>
	<article class="element posts horizontal-spacing">
		<% if $PaginatedList.Exists %>
			<div class="loader"><%t Page.Loader 'Loading...' %></div>
			<% loop $PaginatedList %>
				<% include SilverStripe/Blog/PostSummary %>
			<% end_loop %>
		<% else %>
			<div class="typography nopost">
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
