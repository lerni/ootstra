<% require themedCSS("dist/css/contentsections") %>
<% include App/Includes/ElementTitle %>
<% if $ContentParts %>
<div class="typography">
	<% if $Layout == "NumberedList" %>
		<ol class="content-parts numbered-list">
			<% loop $ContentParts.Sort("SortOrder") %>
				<li>
					<span class="number">{$Pos}</span>
					<div class="txt">
						<% if $ShowTitle %><h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>>$Title</h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>><% end_if %>
						$Text
					</div>
				</li>
			<% end_loop %>
		</ol>
	<% else_if $Layout == "Textblocks" %>
		<ul class="content-parts text-blocks">
			<% loop $ContentParts.Sort("SortOrder") %>
				<li>
					<% if $ShowTitle %><h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>>$Title</h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>><% end_if %>
					$Text
				</li>
			<% end_loop %>
		</ul>
	<% else %>
		<%-- <details><summary></summary></details> --%>
		<ul class="content-parts accordion" role="presentation">
			<% loop $ContentParts.Sort("SortOrder") %>
				<li>
					<h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %> id="{$Title.URLEnc}" class="flip">
						<button aria-expanded="<% if $DefaultOpen %>true<% else %>false<% end_if %>">
							{$Title}
							<svg aria-hidden="true" focusable="false" viewBox="0 0 400 230" class="trigger" version="1.1" xmlns="http://www.w3.org/2000/svg">
								<g stroke="inherit" stroke-width="inherit" stroke-linecap="inherit">
									<line class="line first" x1="30" y1="30" x2="200" y2="200"></line>
									<line class="line second" x1="200" y1="200" x2="370" y2="30"></line>
								</g>
							</svg>
							<%-- <svg aria-hidden="true" focusable="false" viewBox="0 0 200 200" class="trigger" version="1.1" xmlns="http://www.w3.org/2000/svg">
								<g stroke="inherit" stroke-width="inherit" stroke-linecap="inherit">
									<line class="line first" x1="100" y1="30" x2="100" y2="170"></line>
									<line class="line second" x1="30" y1="100" x2="170" y2="100"></line>
								</g>
							</svg> --%>
						</button>
					</h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>>
					<div class="flip" <% if not $DefaultOpen %>hidden<% end_if %> role="region">
						$Text
					</div>
				</li>
			<% end_loop %>
		</ul>
	<% end_if %>
</div>
<% end_if %>
<% if $FAQParts %>$FAQSchema.RAW<% end_if %>
