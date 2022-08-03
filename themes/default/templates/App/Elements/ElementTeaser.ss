<% require themedCSS("dist/css/teaser") %>
<% include App/Includes/ElementTitle %>
<% if $Teasers %>
	<% if $Layout == "third" %>
		<div class="teasers third">
			<% loop $Teasers.Sort(TeaserSortOrder) %>
				<% if $RelatedPageID %><a href="$RelatedPage.Link" <% else %><div <% end_if %>class="teaser">
					<% if $Image %><figure><img <% if not $First %>loading="lazy" <% end_if %>width="$Image.FocusFillMax(340,170).Width()" height="$Image.FocusFillMax(340,170).Height()" src="$Image.FocusFillMax(340,170).URL" srcset="$Image.FocusFillMax(340,170).URL 1x, $Image.FocusFillMax(680,340).URL 2x" alt="$Title" /></figure><% end_if %>
					<div class="txt">
						<% if $Title %><h3>$Title</h3><% end_if %>
						<% if $Text %>$Text.Markdowned<% end_if %>
					</div>
					<% if $RelatedPageID %><span class="pseudolink"><% if $Action %>{$Action}<% else %><%t App\Models\Teaser.MORE "Learn more" %><% end_if %></span><% end_if %>
				<% if $RelatedPageID %></a><% else %></div><% end_if %>
			<% end_loop %>
		</div>
	<% end_if %>
	<% if $Layout == "halve" %>
		<div class="teasers halve">
			<% loop $Teasers.Sort(TeaserSortOrder) %>
				<% if $RelatedPageID %><a href="$RelatedPage.Link" <% else %><div <% end_if %>class="teaser $Layout">
					<% if $Image %><figure><img <% if not $First %>loading="lazy" <% end_if %>width="$Image.FocusFillMax(480,400).Width()" height="$Image.FocusFillMax(480,400).Height()" src="$Image.FocusFillMax(480,400).URL" srcset="$Image.FocusFillMax(480,400).URL 1x, $Image.FocusFillMax(960,800).URL 2x" alt="$Title" /></figure><% end_if %>
					<div class="txt">
						<% if $Title %><h3>$Title</h3><% end_if %>
						<div class="accordion">
							<% if $Text %>$Text.Markdowned<% end_if %>
							<% if $RelatedPageID %><span class="pseudolink"><% if $Action %>{$Action}<% else %><%t App\Models\Teaser.MORE "Learn more" %><% end_if %></span><% end_if %>
						</div>
					</div>
				<% if $RelatedPageID %></a><% else %></div><% end_if %>
			<% end_loop %>
		</div>
	<% end_if %>
	<% if $Layout == "full" %>
		<div class="teasers full">
			<% loop $Teasers.Sort(TeaserSortOrder) %>
				<% if $RelatedPageID %><a href="$RelatedPage.Link" <% else %><div <% end_if %>class="teaser $Layout">
					<% if $Image %><figure><img <% if not $First %>loading="lazy" <% end_if %>width="$Image.FocusFillMax(1400,600).Width()" height="$Image.FocusFillMax(1400,600).Height()" src="$Image.FocusFillMax(1400,600).URL" srcset="$Image.FocusFillMax(1400,600).URL 1x, $Image.FocusFillMax(2800,1200).URL 2x" alt="$Title" /></figure><% end_if %>
					<div class="txt">
						<% if $Title %><h3>$Title</h3><% end_if %>
						<div class="accordion">
							<% if $Text %>$Text.Markdowned<% end_if %>
							<% if $RelatedPageID %><span class="pseudolink"><% if $Action %>{$Action}<% else %><%t App\Models\Teaser.MORE "Learn more" %><% end_if %></span><% end_if %>
						</div>
					</div>
				<% if $RelatedPageID %></a><% else %></div><% end_if %>
			<% end_loop %>
		</div>
	<% end_if %>
<% end_if %>
