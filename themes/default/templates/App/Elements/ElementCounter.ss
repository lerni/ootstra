<% require themedCSS("dist/css/counter") %>
<% require javascript("themes/default/dist/js/countup.js") %>
<% include App/Includes/ElementTitle %>
<% if $CountItems %>
	<ul class="graphs">
		<% loop $CountItems.Sort("SortOrder") %>
			<li class="graph undiscovered">
				<span class="counter"><% if $Prefix %>{$Prefix}<% end_if %><span id="count-{$ID}" class="counter-digit" data-id="count-{$ID}" data-value="{$Value}">$Value</span><% if $Unit %>{$Unit}<% end_if %></span>
				<p>{$Title}</p>
				{$Text.Markdowned}
			</li>
		<% end_loop %>
	</ul>
<% end_if %>
