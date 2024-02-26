<% if $ClassName != "DNADesign\Elemental\Models\BaseElement" %><article class="element $ShortClassName($this, 0).LowerCase
		<% if $isFullWidth %>full-width<% end_if %>
		<% if $ClassName != App\Elements\ElementHero %>horizontal-spacing<% end_if %>
		<% if $WidthReduced %>width-reduced<% end_if %>
		spacing-top-{$SpacingTop}
		spacing-bottom-{$SpacingBottom}
		<% if $Page.ClassName == 'App\Models\ElementPage' && $isHero && $Page.ParentID != 0 %>breadcrumbs<% end_if %>
		<% if $isHero && $Page.SiteConfig.GlobalAlert %>global-alert<% end_if %>
		<% if $AfterHero %>after-hero<% end_if %>
		<% if $BackgroundColor %> background--{$BackgroundColor}<% end_if %>"
		<% if $ElementAnchor %>id="$ElementAnchor"<% end_if %>>
	$Element
	<% if not $Page.IsPreview && $canEdit %><a class="preview" href="{$BaseHref}/{$CMSEditLink}"><span>✎<span></a><% end_if %>
</article><% end_if %>
