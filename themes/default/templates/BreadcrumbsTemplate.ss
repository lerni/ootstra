<% loop $Pages %>
	<% if $IsLast %>
		<span class="breadcrumb-$Pos">$MenuTitle.XML</span>
	<% else %>
		<% if not $Up.Unlinked %><a href="$Link" class="breadcrumb-$Pos"><% end_if %>
		$MenuTitle.XML
		<% if not $Up.Unlinked %></a><% end_if %>
		<span class="delimiter"></span>
	<% end_if %>
<% end_loop %>
