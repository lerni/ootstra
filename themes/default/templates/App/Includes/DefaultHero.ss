<% if not $PreventHero && $Siteconfig.DefaultHeaderSlides.Count %><article class="element elementhero default full-width spacing-bottom-2<% if $Top.ClassName == 'App\Models\ElementPage' && $Top.ParentID != 0 %> breadcrumbs<% end_if %><% if $SiteConfig.GlobalAlert %> global-alert<% end_if %><% if $ClassName == 'SilverStripe\Blog\Model\Blog' || $ClassName == 'SilverStripe\Blog\Model\BlogPost' %> breadcrumbs<% end_if %>">
	<% include App/Includes/Slides Items=$Siteconfig.DefaultHeaderSlides, HeroSize=$Siteconfig.DefaultHeroSize, Page=$Me, SpacingBottom=2, DefaultHero=1 %>
</article><% end_if %>
<% if $SiteConfig.GlobalAlert %><article class="global-alert">
	<div class="typography inner">{$SiteConfig.GlobalAlert}</div>
</article><% end_if %>
<% if $ClassName != 'SilverStripe\Blog\Model\BlogPost' && $ClassName != 'SilverStripe\Blog\Model\Blog' && $Parent.ClassName != 'App\Models\HolderPage' && $ParentID %>
	<nav class="breadcrumbs"><div class="typography inner">{$Breadcrumbs}</div></nav>
<% else_if $ClassName == 'SilverStripe\Blog\Model\BlogPost' || $ClassName == 'SilverStripe\Blog\Model\Blog' %>
	<% include App/Includes/BlogCategories Page=$Me %>
<% end_if %>
