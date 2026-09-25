<article id="$Anchor" class="perso" data-departments="<% loop $Departments %>$Title.URLEnc <% end_loop %>">
	<figure>
		<% if $Portrait %>
			<img loading="lazy" height="$Portrait.FocusFillMax(400,400).Height()" width="$Portrait.FocusFillMax(400,400).Width()" src="$Portrait.FocusFillMax(400,400).Convert('webp').URL" srcset="$Portrait.FocusFillMax(400,400).Convert('webp').URL 1x, $Portrait.FocusFillMax(800,800).Convert('webp').URL 2x" alt="{$Firstname} {$Lastname}" />
		<% else %>
			<img class="default" src="{$viteAsset('src/images/svg/perso-defalut.svg')}" alt="" />
		<% end_if %>
		<% if $EMail && $Telephone && $CurrentMember %><img class="qr-code" src="/_pqr/{$ID}" alt="qrcode linking vCard" /><% end_if %>
	</figure>
	<div class="txt">
		<hgroup>
			<h2>{$Firstname} {$Lastname}</h2>
			<% if $Position %><div class="position">$Position.Markdowned</div><% end_if %>
		</hgroup>
		<% if $EMail && $Telephone %><address class="coordinates">
			<% if $EMail && $Telephone %><a class="vcard" href="/_vc/{$ID}" title="vCard">vCard</a><% end_if %>
			<% if $EMail %><a class="mail" href="mailto:{$EMail}" title="{$EMail}">{$EMail}</a><% end_if %>
			<% if $Telephone %><a class="phone" href="tel:{$Telephone.TelEnc}" title="{$Telephone}">{$Telephone}</a><% end_if %>
		</address><% end_if %>
		<% if $SocialLinks %>
			<div class="social-icons">
				<% loop $SocialLinks.sort("SortOrder") %>
					<a class="social-icon socialize" target="_blank" rel="noopener" title="$Title" href="$Url" style="mask-image: url('{$IconPath}')"></a>
				<% end_loop %>
			</div>
		<% end_if %>
		<%-- <a href="{$Link}" class="link forth">{$Link}</a> --%>
	</div>
</article>
