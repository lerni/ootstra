<div id="#{$ID}-{$URLSegment}" class="item level-{$PageLevel}<% if not $ImagesForSitemap %> no-images<% end_if %><% if not $isPublished %> not-published<% end_if %><% if not $ShowInSearch %> not-showed-in-search<% end_if %> {$ShortClassName($this, 'false')}">
	<% if not $ShowInSearch %><label class="label large"><%t App\Models\MetaOverviewPage.NotShowInSearch 'ShowInSearch isn\'t checked' %></label><% end_if %>
	<% if not $isPublished %><label class="label large"><%t App\Models\MetaOverviewPage.IsNotPublished 'Not published!' %></label><% end_if %>
	<label class="label class-name">{$ShortClassName($this, 0)}</label>
	<label class="label url-segment">#{$ID}-{$URLSegment}</label>
	<% if $ImagesForSitemap %>
	<figure>
		<figcaption class="label"><%t App\Models\MetaOverviewPage.OGImageLabel 'OG Image' %></figcaption>
		<img src="$getDefaultOGImage().Link" alt="$getDefaultOGImage().Title">
	</figure>
	<% end_if %>
	<div class="txt">
		<h3>$Title #{$Pos}</h3>
		<p>
			<a target="_blank" href="$Link">$Link</a> &#x2192; <a href="/admin/pages/edit/show/{$ID}">edit</a><br/>
			<% if $MetaTitle %>
				<span><strong>$MetaTitle</strong> ($MetaTitle.Length)</span><br>
			<% else %>
				<i class="color-gray">$Title | $SiteConfig.Title</i> <a href="#default-meta">(Default Meta-Title -> \$Title | \$SiteConfig.Title)</a><br>
			<% end_if %>
			<% if $MetaDescription %>
				<span>$MetaDescription ($MetaDescription.Length)</span><br>
			<% else %>
				<span class="color-red"><%t App\Models\MetaOverviewPage.NoMetaDescription 'There is no Meta-Description!' %></span><br>
			<% end_if %>
		</p>
	</div>
	<% if $ImagesForSitemap %>
		<div class="gallery">
			<div class="label"><%t App\Models\MetaOverviewPage.ImagesForXMLSitemapLabel 'Images for sitemap.xml' %></div>
			<ul>
				<% loop $ImagesForSitemap %>
					<li>
						<a href="{$AbsoluteLink}"
							data-type="image"
							data-caption="{$Title}<br/>{$Caption}"
							data-fancybox="group{$Up.Pos}">
							<img src="{$AbsoluteLink}" alt="$Title" />
						</a>
						<a target="_blank" href="{$CMSEditLink}">
							<h4>{$Title}</h4>
							<p>$Caption.LimitWordCount(16)</p>
						(<- edit)</a>
					</li>
				<% end_loop %>
			</ul>
		</div>
	<% end_if %>
</div>
<% loop $Childrenexcluded('metaoverview') %>
	<% include App/Includes/MetaItem %>
<% end_loop %>
