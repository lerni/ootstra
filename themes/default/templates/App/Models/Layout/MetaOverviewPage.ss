<% include App/Includes/Header %>
<main class="typography">
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	<div class="inner">
		<% loop $list("Page") %>
			<% if ClassName != "SilverStripe\CMS\Model\RedirectorPage" %>
				<div class="item">
					<h3>$Title #{$Pos}</h3>
					<p>
						<a target="_blank" href="$Link">$Link</a> &#x2192; <a href="/admin/pages/edit/show/{$ID}">edit</a><br/>
						<% if $MetaTitle %>
							<span><strong>$MetaTitle</strong> ($MetaTitle.Length)</span><br>
						<% else %>
							<i class="color-gray">$Title | $SiteConfig.Title</i> <span>(Default Meta-Title -> \$Title | \$SiteConfig.Title)</span><br>
						<% end_if %>
						<% if $MetaDescription %>
							<span>$MetaDescription ($MetaDescription.Length)</span><br>
						<% else %>
							<span class="color-red">No MetaDescription!</span><br>
						<% end_if %>
						<strong class="color-red">$ProductTable.CSVFirstColumUniquenes</strong><br>
					</p>
					<% if $ImagesForSitemap %>
						<ul class="gallery">
							<% loop $ImagesForSitemap %>
								<li>
									<a href="{$AbsoluteLink}"
										data-type="image"
										data-caption="$Caption"
										data-fancybox="group{$Up.Pos}"
										data-fancybox="gallery">
										<img src="{$AbsoluteLink}" alt="$title" />
									</a>
									<a target="_blank" href="{$CMSEditLink}">
										<h4>{$Title}</h4>
										<p>$Caption</p>
									(<- edit)</a>
								</li>
							<% end_loop %>
						</ul>
					<% end_if %>
				</div>
				<% end_if %>
		<% end_loop %>
	</div>
</main>
