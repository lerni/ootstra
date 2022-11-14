<style type="text/css" nonce="{$Nonce}">
	@font-face {
		font-family: "silverstripe";
		src: url("$resourceURL('vendor/silverstripe/admin/client/dist/fonts/silverstripe.woff')") format('woff');
		font-style: normal;
		font-display: block;
	}
</style>
<% include App/Includes/Header %>
<% require themedCSS("dist/css/metaoverviewpage") %>
<% require themedCSS("dist/css/fancy") %>
<% require javascript("themes/default/dist/js/fancy.js") %>
<main class="typography">
	<article class="element">
		<% with $SiteConfig %>
			<div id="default-meta" class="item default">
				<%-- todo: once we have default slide on SiteConfig add it here as default --%>
				<figure>
					<img src="$DefaultHeaderImage().Link" alt="$DefaultHeaderImage().Title">
					<figcaption class="label"><strong><%t App\Models\MetaOverviewPage.OGImageLabel 'OG Image' %>:</strong> $DefaultHeaderImage.Title</figcaption>
				</figure>
				<div class="txt">
					<a class="edit" alt="edit {$Title}" href="/admin/settings/"></a>
					<h3><%t App\Models\MetaOverviewPage.DefaultItemTitle 'Default values in $SiteConfig' %><a target="_blank" href="$Link">$Link</a></h3>
					<p>
						<% if $Title %>
							<span><strong>$Title</strong> ($Title.Length | min. 50 max. 60 but \$Page.Title is added like below)</span><br>
							<i class="color-gray">$Title</i> <span>(Default Meta-Title -> \$Page.Title | \$SiteConfig.Title)</span><br><br>
						<% else %>
							<span class="color-red"><%t App\Models\MetaOverviewPage.NoDefaultMetaTitle 'There is no default Title!' %></span><br>
						<% end_if %>
						<% if $MetaDescription %>
							<span>$MetaDescription ($MetaDescription.Length | min. 100 max. 160)</span><br>
						<% else %>
							<span class="color-red"><%t App\Models\MetaOverviewPage.NoDefaultMetaDescription 'There is no default Meta-Description!' %></span><br>
						<% end_if %>
					</p>
				</div>
			</div>
		<% end_with %>
		<% loop $MetaOverview %>
			<% include App/Includes/MetaItem %>
		<% end_loop %>
	</article>
</main>
