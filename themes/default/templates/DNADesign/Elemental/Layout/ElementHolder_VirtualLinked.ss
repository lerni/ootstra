<% if $LinkedElement %><article class="element horizontal-spacing
		$ShortClassName($this, true)
		<% if $LinkedElement.isFullWidth %>full-width<% end_if %>
		spacing-top-{$LinkedElement.SpacingTop}
		spacing-bottom-{$LinkedElement.SpacingBottom}
		<% if $Page.ClassName == 'App\Models\ElementPage' && $isHero && $Page.ParentID != 0 || $Page.ClassName == 'SilverStripe\Blog\Model\BlogPost' %>breadcrumbs<% end_if %>
		<% if $LinkedElement.AfterHero %>after-hero<% end_if %>
		<% if $LinkedElement.BackgroundColor %> background--{$LinkedElement.BackgroundColor}<% end_if %>"
		<% if $ElementAnchor %>id="$ElementAnchor"<% end_if %>>
	$Element
</article>
<% end_if %>
