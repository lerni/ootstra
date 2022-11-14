<% require themedCSS("dist/css/contentsections") %>
<% include App/Includes/ElementTitle %>
<% if $ContentParts %>
	<% if $Layout == "NumberedList" %>
		<ol class="content-part numbered-list">
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
		<dl class="content-parts text-blocks">
			<% loop $ContentParts.Sort("SortOrder") %>
				<article>
					<% if $ShowTitle %><h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>>$Title</h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>><% end_if %>
					$Text
				</article>
			<% end_loop %>
		</dl>
	<% else %>
		<%-- <details><summary></summary></details> --%>
		<dl class="content-parts accordion" role="presentation">
			<% loop $ContentParts.Sort("SortOrder") %>
				<dt class="flip"<% if $Title %> id="{$Title.URLEnc}"<% end_if %>>
					<% if $ShowTitle %><h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %> class="flip">
						<button aria-expanded="<% if $DefaultOpen %>true<% else %>false<% end_if %>">
							{$Title}<div class="trigger" aria-hidden="true" focusable="false"></div>
						</button>
					</h<% if $TitleLevel %>{$TitleLevel}<% else %>2<% end_if %>><% end_if %>
				</dt>
				<dd class="flip" <% if not $DefaultOpen %>hidden<% end_if %> role="region">
					$Text
				</dd>
			<% end_loop %>
		</dl>
	<% end_if %>
<% end_if %>
<% if $FAQParts %>$FAQSchema.RAW<% end_if %>
