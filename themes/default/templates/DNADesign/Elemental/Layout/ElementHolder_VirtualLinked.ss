<% if $LinkedElement %><article class="element $ClassName.ShortName.LowerCase $LinkedElement.ShortClassName.LowerCase
		<% if $LinkedElement.isFullWidth %>full-width<% end_if %>
		<% if $LinkedElement.ClassName != App\Elements\ElementHero %>horizontal-spacing<% end_if %>
		<% if $LinkedElement.WidthReduced %>width-reduced<% end_if %>
		spacing-top-{$LinkedElement.SpacingTop}
		spacing-bottom-{$LinkedElement.SpacingBottom}
		<% if $Page.ClassName == 'App\Models\ElementPage' && $isHero && $Page.ParentID != 0 %>breadcrumbs<% end_if %>
		<% if $LinkedElement.AfterHero %>after-hero<% end_if %>
		<% if $LinkedElement.BackgroundColor %> background--{$LinkedElement.BackgroundColor}<% end_if %>"
	<% if $ElementAnchor %> id="$ElementAnchor"<% end_if %>>
	$Element
</article>
<% end_if %>
