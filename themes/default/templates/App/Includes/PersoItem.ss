<article id="$Anchor" class="perso" data-departments="<% loop $Departments %>$Title.URLEnc <% end_loop %>">
	<figure>
		<% if $Portrait %>
			<img loading="lazy" height="$Portrait.FocusFillMax(600,600).Height()" width="$Portrait.FocusFillMax(600,600).Width()" src="$Portrait.FocusFillMax(600,600).Convert('webp').URL" srcset="$Portrait.FocusFillMax(600,600).Convert('webp').URL 1x, $Portrait.FocusFillMax(1024,1024).Convert('webp').URL 2x" alt="{$Firstname} {$Lastname}" />
		<% else %>
			<img class="default" src="{$viteAsset('src/images/svg/perso-defalut-381-232.svg')}" alt="" />
		<% end_if %>
		<% if $EMail && $Telephone %><img class="qr-code" src="/_pqr/{$ID}" alt="qrcode linking vCard" /><% end_if %>
	</figure>
	<div class="txt">
		<h2>{$Firstname} {$Lastname}</h2>
		<% if $Position %><div class="position">$Position.Markdowned</div><% end_if %>
		<% if $EMail && $Telephone %><address class="coordinates">
			<% if $EMail && $Telephone %><a class="vcard" href="/_vc/{$ID}" title="vCard">vCard</a><% end_if %>
			<% if $EMail %><a class="mail" href="mailto:{$EMail}" title="{$EMail}">{$EMail}</a><% end_if %>
			<% if $Telephone %><a class="phone" href="tel:{$Telephone.TelEnc}" title="{$Telephone}">{$Telephone}</a><% end_if %>
		</address><% end_if %>
		<%-- <a href="{$Link}">{$Link}</a> --%>
	</div>
</article>
