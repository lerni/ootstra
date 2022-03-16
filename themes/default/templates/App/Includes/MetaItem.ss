<div id="#{$ID}-{$URLSegment}" class="item level-{$PageLevel}<% if not $ImagesForSitemap %> no-images<% end_if %><% if not $isPublished %> not-published<% end_if %><% if not $ShowInSearch %> not-showed-in-search<% end_if %> {$ShortClassName($this, 'false')}">
<% if not $ShowInSearch %><label class="label large"><%t App\Models\MetaOverviewPage.NotShowInSearch 'ShowInSearch isn\'t checked' %></label><% end_if %>
<% if not $isPublished %><label class="label large"><%t App\Models\MetaOverviewPage.IsNotPublished 'Not published!' %></label><% end_if %>
<% if $ClassName == 'SilverStripe\CMS\Model\RedirectorPage' %><label class="label large"><%t App\Models\MetaOverviewPage.RedirectorPage 'Redirector Page' %></label><% end_if %>
<label class="label class-name">{$ShortClassName($this, 0)}</label>
<label class="label anchor">#{$ID}-{$URLSegment}</label>
<%-- if $ImagesForSitemap --%>
<figure>
    <img src="$getDefaultOGImage().Link" alt="$getDefaultOGImage().Title">
<figcaption class="label"><%t App\Models\MetaOverviewPage.OGImageLabel 'OG Image' %></figcaption>
</figure>
<%-- end_if --%>
<div class="txt">
    <a  class="edit" alt="edit" href="/admin/pages/edit/show/{$ID}"></a>
    <h3>$Title ID:{$ID} <span class="gray">(Title)</span></h3>
    <p>
        <a target="_blank" href="$Link">$Link</a><br/>
        <% if $ClassName != "SilverStripe\CMS\Model\RedirectorPage" %>
            <% if $MetaTitle %>
                <span><strong>$MetaTitle</strong>  <span class="gray">(Metatitle $MetaTitle.Length | min. 50 max. 60)</span></span><br>
            <% else %>
                <br><i class="color-gray">$Title | $SiteConfig.Title</i><br><a href="#default-meta">(Default Meta-Title -> \$Title | \$SiteConfig.Title)</a><br><br>
            <% end_if %>
            <% if $MetaDescription %>
                <span>$MetaDescription ($MetaDescription.Length | min. 100 max. 160)</span><br>
            <% else %>
                <span class="color-red"><%t App\Models\MetaOverviewPage.NoMetaDescription 'There is no Meta-Description!' %></span><br>
            <% end_if %>
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
                        data-fancybox="group{$Up.ID}">
                        <img src="{$AbsoluteLink}" alt="$Title" />
                    </a>
                    <a class="edit" alt="edit {$Title}" target="_blank" href="{$CMSEditLink}"></a>
                        <h4>{$Title}</h4>
                        <p>$Caption.LimitWordCount(16)</p>
                    </a>
                </li>
            <% end_loop %>
        </ul>
    </div>
<% end_if %>
</div>
<% loop $Childrenexcluded('metaoverview') %>
<% include App/Includes/MetaItem %>
<% end_loop %>
