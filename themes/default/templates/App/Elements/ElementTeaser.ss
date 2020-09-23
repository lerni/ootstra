<% if not $isFullWidth %><div class="inner"><% end_if %>
	<% include App/Includes/ElementTitle %>
	<% if $Teasers %>
		<% if $Layout == "third" %>
			<div class="teasers third">
				<% loop $Teasers.Sort(TeaserSortOrder) %>
					<% if $RelatedPageID %><a href="$RelatedPage.Link" <% else %><span <% end_if %>class="teaser">
						<% if $Image %><figure><img src="$Image.FocusFillMax(340,170).URL" srcset="$Image.FocusFillMax(340,170).URL 1x, $Image.FocusFillMax(680,340).URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $Title %><h4>$Title</h4><% end_if %>
							<% if $Text %><p>$Text</p><% end_if %>
						</div>
						<% if $RelatedPageID %><span class="pseudolink"><% if $Action %>{$Action}<% else %><%t App\Models\Teaser.MORE "none" %><% end_if %></span><% end_if %>
					<% if $RelatedPageID %></a><% else %></span><% end_if %>
				<% end_loop %>
			</div>
		<% end_if %>
		<% if $Layout == "halve" %>
			<div class="teasers halve">
				<% loop $Teasers.Sort(TeaserSortOrder) %>
					<% if $RelatedPageID %><a href="$RelatedPage.Link" <% else %><span <% end_if %>class="teaser $Layout">
						<% if $Image %><figure><img src="$Image.FocusFillMax(480,400).URL" srcset="$Image.FocusFillMax(480,400).URL 1x, $Image.FocusFillMax(960,800).URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $Title %><h4>$Title</h4><% end_if %>
							<div class="accordion">
								<% if $Text %><p>$Text</p><% end_if %>
								<% if $RelatedPageID %><span class="pseudolink"><% if $Action %>{$Action}<% else %><%t App\Models\Teaser.MORE "none" %><% end_if %></span><% end_if %>
							</div>
						</div>
					<% if $RelatedPageID %></a><% else %></span><% end_if %>
				<% end_loop %>
			</div>
		<% end_if %>
		<% if $Layout == "full" %>
			<div class="teasers full">
				<% loop $Teasers.Sort(TeaserSortOrder) %>
					<% if $RelatedPageID %><a href="$RelatedPage.Link" <% else %><span <% end_if %>class="teaser $Layout">
						<% if $Image %><figure><img src="$Image.FocusFillMax(1400,600).URL" srcset="$Image.FocusFillMax(1400,600).URL 1x, $Image.FocusFillMax(2800,1200).URL 2x" alt="$Title" /></figure><% end_if %>
						<div class="txt">
							<% if $Title %><h4>$Title</h4><% end_if %>
							<div class="accordion">
								<% if $Text %><p>$Text</p><% end_if %>
								<% if $RelatedPageID %><span class="pseudolink"><% if $Action %>{$Action}<% else %><%t App\Models\Teaser.MORE "none" %><% end_if %></span><% end_if %>
							</div>
						</div>
					<% if $RelatedPageID %></a><% else %></span><% end_if %>
				<% end_loop %>
			</div>
		<% end_if %>
	<% end_if %>
<% if not $isFullWidth %></div><% end_if %>
