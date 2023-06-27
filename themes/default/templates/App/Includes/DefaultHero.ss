<article class="element elementhero default full-width spacing-bottom-2<% if $Top.ClassName == 'App\Models\ElementPage' && $Top.ParentID != 0 %> breadcrumbs<% end_if %>">
	<% include App/Includes/Slides Slides=$Siteconfig.DefaultHeaderSlides, Size=$Siteconfig.DefaultHeaderSize, Page=$Page %>
</article>
<% if $SiteConfig.GlobalAlert %><article class="global-alert horizontal-spacing">
	$SiteConfig.GlobalAlert
</article><% end_if %>
<% with $Page %><% if $ClassName != 'SilverStripe\Blog\Model\BlogPost' && $ParentID %>
	<nav class="breadcrumbs"><div class="typography inner">{$Breadcrumbs}</div></nav>
<% end_if %><% end_with %>
