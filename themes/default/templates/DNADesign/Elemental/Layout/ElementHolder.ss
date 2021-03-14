<article class="element
		$ShortClassName.LowerCase
		spacing-top-{$SpacingTop}
		spacing-bottom-{$SpacingBottom}
		<% if $Page.ClassName == 'App\Models\ElementPage' && $isHero && $Page.ParentID != 0 %>breadcrumbs<% end_if %>
		<% if $isHero && $Page.SiteConfig.GlobalAlert %>global-alert<% end_if %>
		<% if $AfterHero %>after-hero<% end_if %>
		<% if $ExtraClass %>$ExtraClass<% end_if %>
		<% if $BackgroundColor %> background-{$BackgroundColor}<% end_if %>
		<% if $ClassName == 'DNADesign\ElementalVirtual\Model\ElementVirtual' %>
			<% if $LinkedElement.Page.ClassName == 'App\Models\ElementPage' && $LinkedElement.isHero %>breadcrumbs<% end_if %>
			<% if $LinkedElement.isHero && $LinkedElement.Page.SiteConfig.GlobalAlert %>global-alert<% end_if %>
			<% if $LinkedElement.AfterHero %>after-hero<% end_if %>
			<% if $LinkedElement.BoxShadow %>box-shadow<% end_if %>
			<% if $LinkedElement.ExtraClass %>$ExtraClass<% end_if %>
			<% if $LinkedElement.BackgroundColor %> background--{$LinkedElement.BackgroundColor}<% end_if %>
		<% end_if %>"
		<% if $ElementAnchor %>id="$ElementAnchor"<% end_if %>>
	$Element
</article>
