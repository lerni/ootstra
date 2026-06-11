<% if $ClassName != "DNADesign\Elemental\Models\BaseElement" %><article class="element horizontal-spacing
		$ShortClassName($this, true)
		<% if $isFullWidth %>full-width<% end_if %>
		<% if $PushUP %>push-up-{$PushUP}<% end_if %>
		spacing-top-{$SpacingTop}
		spacing-bottom-{$SpacingBottom}
		<% if $Page.ClassName == 'App\Models\ElementPage' && $isHero && $Page.ParentID != 0 || $Page.ClassName == 'SilverStripe\Blog\Model\BlogPost' %>breadcrumbs<% end_if %>
		<% if $isHero && $Page.SiteConfig.GlobalAlert %>global-alert<% end_if %>
		<% if $AfterHero %>after-hero<% end_if %>
		<% if $BackgroundColor %> background--{$BackgroundColor}<% end_if %>"
		<% if $Anchor %>id="$Anchor"<% end_if %>
	$Element
	<% if not $Page.IsPreview && $canEdit %><a class="preview-edit {$CurrentStage}" href="{$BaseHref}{$CMSEditLink}" target="silverstripe-cms"><span>✎</span></a><% end_if %>
</article><% end_if %>
