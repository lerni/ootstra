<article class="element
	<% if $ClassName == 'DNADesign\ElementalVirtual\Model\ElementVirtual' %>
		$ClassName.ShortName.LowerCase
		<% if $LinkedElement.isFullWidth %>full-width<% end_if %>
		<% if $WidthReduced %>width-reduced<% end_if %>
		$LinkedElement.ShortClassName.LowerCase
		spacing-top-{$LinkedElement.SpacingTop}
		spacing-bottom-{$LinkedElement.SpacingBottom}
		<% if $LinkedElement.AfterHero %>after-hero<% end_if %>
		<% if $LinkedElement.BackgroundColor %> background--{$LinkedElement.BackgroundColor}<% end_if %>
	<% else %>
		$ShortClassName.LowerCase
		<% if $isFullWidth %>full-width<% end_if %>
		<% if $WidthReduced %>width-reduced<% end_if %>
		spacing-top-{$SpacingTop}
		spacing-bottom-{$SpacingBottom}
		<% if $Page.ClassName == 'App\Models\ElementPage' && $isHero && $Page.ParentID != 0 %>breadcrumbs<% end_if %>
		<% if $isHero && $Page.SiteConfig.GlobalAlert %>global-alert<% end_if %>
		<% if $AfterHero %>after-hero<% end_if %>
		<% if $BackgroundColor %> background--{$BackgroundColor}<% end_if %>
	<% end_if %>"
	<% if $ElementAnchor %>id="$ElementAnchor"<% end_if %>>
$Element
</article>
