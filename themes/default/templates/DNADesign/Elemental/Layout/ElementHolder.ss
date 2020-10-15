<article class="element
		$ShortClassName.LowerCase
		spacing-top-{$SpacingTop}
		spacing-bottom-{$SpacingBottom}
		<% if $Page.ClassName == 'App\Models\ElementPage' && $isHero && $Page.ParentID != 0 %>breadcrumbs<% end_if %>
		<% if $isHero && $Page.SiteConfig.GlobalAlert %>global-alert<% end_if %>
		<% if $AfterHero %>after-hero<% end_if %>
		<% if $ExtraClass %>$ExtraClass<% end_if %>
		<% if $BackgroundColor %> background-{$BackgroundColor}<% end_if %>"
		<% if $ElementAnchor %>id="$ElementAnchor"<% end_if %>>
	$Element
</article>
