<% include App/Includes/Header %>
<% vite 'src/css/cards.css', 'src/js/infiniteGrid.js' %>
<main>
	<% include App/Includes/DefaultHero %>
	<% if $Content %>
		<article class="element default horizontal-spacing spacing-bottom-1 after-hero">
			<div class="typography width-reduced">
				$Content
			</div>
		</article >
	<% end_if %>
	<% if $CategoriesWithState.Count %><nav class="element blog-post-meta horizontal-spacing">
		<nav class="cat-tag" data-hx-boost="true" data-hx-indicator=".loader" data-hx-swap="outerHTML show:unset">
			<a href="$Top.Link" class="all<% if not $URLCategoryFirst %> current<% end_if %>" title="<%t SilverStripe\Blog\Model\Blog.Allcategories "Alle" %>"><%t SilverStripe\Blog\Model\Blog.Allcategories "Alle" %></a>
			<% loop $CategoriesWithState %>
				<a href="{$Top.Link}?tags={$URLSegment}" class="$CustomLinkingMode" title="$Title" data-segment="$URLSegment">$Title</a>
			<% end_loop %>
		</nav>
	</nav><% end_if %>
	<article class="element elementfeedteaser full-width horizontal-spacing">
		<% if $Items %>
			<div class="masonry-holder cards {$Layout}">
				<% loop $Items %>
					<a href="$Link" class="masonry-brick card" style="aspect-ratio: {$getDefaultOGImage(1).ScaleMaxWidth(600).Width()} / {$getDefaultOGImage(1).ScaleMaxWidth(600).Height()}">
						<% if $getDefaultOGImage(1).Exists() %><figure><img <% if not $IsFirst %>loading="lazy" <% end_if %>width="$getDefaultOGImage(1).ScaleMaxWidth(600).Width()" height="$getDefaultOGImage(1).ScaleMaxWidth(600).Height()" src="$getDefaultOGImage(1).ScaleMaxWidth(600).Convert('webp').URL" srcset="$getDefaultOGImage(1).ScaleMaxWidth(600).Convert('webp').URL 1x, $getDefaultOGImage(1).ScaleMaxWidth(1200).Convert('webp').URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $OGTitle %><h3>$OGTitle</h3><% end_if %>
							<div class="accordion">
								<% if $Summary %>
									$Summary
								<% else_if $OGDescription %>
									<p>$getDefaultOGDescription(0, 60)</p>
								<% end_if %>
							</div>
							<span class="link forth"><%t App\Models\Teaser.MORE "Learn more" %></span>
						</div>
					</a>
				<% end_loop %>
				<div class="loader"><%t Page.Loader 'Loading...' %></div>
			</div>
		<% end_if %>
	</article>
</main>
