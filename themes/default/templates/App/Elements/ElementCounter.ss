<% vite 'src/css/counter.css', 'src/js/countup.js' %>
<% if $ShowTitle %><div class="typography<% if $isFullWidth %> inner<% end_if %>"><% end_if %>
	<% include App/Includes/ElementTitle %>
<% if $ShowTitle %></div><% end_if %>
<% if $CountItems %>
	<ul class="graphs">
		<% loop $CountItems.Sort("SortOrder") %>
			<li class="graph undiscovered">
				<span class="counter"><% if $Prefix %>{$Prefix}<% end_if %><span id="count-{$ID}" class="counter-digit" data-id="count-{$ID}" data-value="{$Value}">$Value</span><% if $Unit %> {$Unit}<% end_if %></span>
				<p>{$Title}</p>
				{$Text.Markdowned}
			</li>
		<% end_loop %>
	</ul>
<% end_if %>
