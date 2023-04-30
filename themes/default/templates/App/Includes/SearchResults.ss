<% include App/Includes/Header %>
<main>
	<article class="element elementhero default spacing-bottom-2<% if $Top.ClassName == 'App\Models\ElementPage' && $Top.ParentID != 0 %> breadcrumbs<% end_if %> full-width">
		<div class="inner">
			<h1 class="dafault-title">Suchergebnisse für {$Query}</h1>
		</div>
		<div id="bgelement"></div>
	</article>
	<article class="element width-reduced spacing-top-2 spacing-bottom-1">
		<div class="typography">
			<ul class="search-results">
				<% loop $Results.Results %>
					<% if $list('Page').Filter("ID", $ID).First().ClassName != 'SilverStripe\CMS\Model\RedirectorPage' %>
					<li class="item">
						<a href="{$Link}">
							<div class="txt">
								<% if $Title %><h3>$Title</h3><% end_if %>
								<% if $getDefaultOGDescription %><p>$getDefaultOGDescription</p><% end_if %>
							</div>
							<%-- <figure>
								<% if $list('Page').Filter("ID", $ID).First().getDefaultOGImage(1).exists() %>
									<% with $list('Page').Filter("ID", $ID).First().getDefaultOGImage(1) %>
										<img width="280" height="150" src="$Pad(280,150).URL" src="$Pad(280,150).URL 1x, $Pad(560,300).URL 2x" alt="$Title" />
									<% end_with %>
								<% end_if %>
							</figure> --%>
						</a>
					</li>
					<% end_if %>
				<% end_loop %>
			</ul>
		</div>
	</article>
</main>

