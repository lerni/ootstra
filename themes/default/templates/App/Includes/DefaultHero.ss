<% if not $Page.PreventHero && $Siteconfig.DefaultHeaderSlides.Count %><article class="element elementhero default spacing-bottom-2<% if $Top.ClassName == 'App\Models\ElementPage' && $Top.ParentID != 0 %> breadcrumbs<% end_if %><% if $Page.SiteConfig.GlobalAlert %> global-alert<% end_if %>">
	<% include App/Includes/Slides Slides=$Siteconfig.DefaultHeaderSlides, HeroSize=$Siteconfig.DefaultHeroSize, Page=$Page %>
</article><% end_if %>
<% if $SiteConfig.GlobalAlert %><article class="global-alert">
	<div class="typography inner">{$SiteConfig.GlobalAlert}</div>
</article><% end_if %>
<% with $Page %><% if $ClassName != 'SilverStripe\Blog\Model\BlogPost' && $ClassName != 'SilverStripe\Blog\Model\Blog' && $ParentID %>
	<nav class="breadcrumbs"><div class="typography inner">{$Breadcrumbs}</div></nav>
<% end_if %><% end_with %>
