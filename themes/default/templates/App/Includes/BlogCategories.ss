<% with $Page %>
	<% if $CategoriesWithState %>
		<nav class="element blog-post-meta horizontal-spacing">
			<nav class="cat-tag" data-hx-boost="true" data-hx-indicator=".loader">
				<% if $ClassName == 'SilverStripe\Blog\Model\BlogPost' %>
					<a href="$Parent.Link" class="all" title="<%t SilverStripe\Blog\Model\Blog.Allcategories %>"><%t SilverStripe\Blog\Model\Blog.Allcategories %></a>
				<% else %>
					<a href="$Link" class="all <% if not $getCurrentCategory %> current<% end_if %>" title="<%t SilverStripe\Blog\Model\Blog.Allcategories %>"><%t SilverStripe\Blog\Model\Blog.Allcategories %></a>
				<% end_if %>
				<% loop $CategoriesWithState %>
					<a href="$Link" class="$CustomLinkingMode" title="$Title" data-segment="$URLSegment">$Title</a>
				<% end_loop %>
			</nav>
		</nav>
	<% end_if %>
<% end_with %>
