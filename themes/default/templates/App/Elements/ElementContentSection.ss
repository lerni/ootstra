<% vite 'src/css/contentsections.css', 'src/js/flip.js' %>
<% if $ShowTitle %><div class="typography<% if $isFullWidth %> inner<% end_if %>"><% end_if %>
	<% include App/Includes/ElementTitle %>
<% if $ShowTitle %></div><% end_if %>
<% if $ContentParts %>
<div class="typography">
	<% if $Layout == "NumberedList" %>
		<ol class="content-parts numbered-list">
			<% loop $ContentParts.Sort("SortOrder") %>
				<li<% if $Title %> id="$Title.URLEnc"<% end_if %>>
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
				<li<% if $Title %> id="$Title.URLEnc"<% end_if %>>
					<% if $ShowTitle %><h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>>$Title</h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>><% end_if %>
					$Text
				</li>
			<% end_loop %>
		</ul>
	<% else %>
		<div class="content-parts accordion">
			<% loop $ContentParts.Sort("SortOrder") %>
				<details <% if $DefaultOpen %>open<% end_if %> <% if $Title %>id="$Title.URLEnc"<% end_if %>>
					<summary>
						<h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>>
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
						</h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>>
					</summary>
					<div class="content">
						$Text
					</div>
				</details>
			<% end_loop %>
		</div>
	<% end_if %>
</div>
<% end_if %>
<% if $FAQParts %>$FAQSchema.RAW<% end_if %>
