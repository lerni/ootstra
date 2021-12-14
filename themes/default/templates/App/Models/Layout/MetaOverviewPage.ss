<% include App/Includes/Header %>
<main class="typography">
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	<div class="inner">
		<% with $SiteConfig %>
			<div id="default-meta" class="item default">
				<h3><%t App\Models\MetaOverviewPage.DefaultItemTitle 'Default values in $SiteConfig' %> <a target="_blank" href="$Link">$Link</a> &#x2192; <a href="/admin/settings/">edit</a></h3>
				<p>
					<% if $MetaTitle %>
						<span><strong>$MetaTitle</strong> ($MetaTitle.Length)</span><br>
					<% else %>
						<i class="color-gray">$Title</i> <span>(Default Meta-Title -> \$Page.Title | \$SiteConfig.Title)</span><br>
					<% end_if %>
				</p>
			<%-- todo: once we have default slide on SiteConfig add it here as default --%>
			</div>
		<% end_with %>
		<% loop $MetaOverview %>
			<% include App/Includes/MetaItem %>
		<% end_loop %>
	</div>
</main>
