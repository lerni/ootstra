<% include App/Includes/ElementTitle %>
<% if $CountItems %>
	<ul class="graphs">
		<% loop $CountItems.Sort("SortOrder") %>
			<li class="graph undiscovered">
				<span class="counter" data-count="$Value">$Value</span><br />
				<h4>{$Title}</h4>
				<p>{$Text}</p>
			</li>
		<% end_loop %>
	</ul>
<% end_if %>
