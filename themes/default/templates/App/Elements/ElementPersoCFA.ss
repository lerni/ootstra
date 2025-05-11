<% require themedCSS("dist/css/persocfa") %>
<div class="typography">
	<div class="persos">
		<% if $Items.Count > 1 %>
			<% require themedCSS("dist/css/swiper") %>
			<% require javascript("themes/default/dist/js/swiper.js") %>
			<div class="swiper-container perso-cfa" id="general-swiper-{$ID}">
				<div class="swiper-wrapper perso-cfa {$Layout}">
		<% end_if %>
		<% loop $Items %>
		<div class="swiper-slide perso">
			<figure>
				<% if $Portrait %>
					<img loading="lazy" height="$Portrait.FocusFillMax(305,400).Height()" width="$Portrait.FocusFillMax(305,400).Width()" src="$Portrait.FocusFillMax(305,400).Convert('webp').URL" srcset="$Portrait.FocusFillMax(305,400).Convert('webp').URL 1x, $Portrait.FocusFillMax(610,800).Convert('webp').URL 2x" alt="{$Firstname} {$Lastname}" />
				<% else %>
					<img class="default" src="$resourceURL('themes/default/dist/images/svg/perso-defalut.svg')" alt="" />
				<% end_if %>
			</figure>
			<div class="txt">
				<% with $Up %><% include App/Includes/ElementTitle %><% end_with %>
				<p class="name inline"><strong>{$Firstname} {$Lastname}</strong></p>
				<% if $Position %>
					<span class="position">$Position</span>
				<% end_if %>
				<p>
					<span class="links">
						<% if $EMail %><a class="mail" href="mailto:{$EMail}">{$EMail}</a><% end_if %>
						<% if $Telephone %><a class="phone" href="tel:{$Telephone.TelEnc}">{$Telephone}</a><% end_if %>
						<% if $EMail && $Telephone %>
							<a class="vcard" href="/_vc/{$ID}" title="vCard">vCard</a>
							<% if $CurrentMember %>
								<a class="qrcode" href="/_pqr/{$ID}" target="_blank" title="vCard">QR-Code</a>
							<% end_if %>
						<% end_if %>
					</span>
				</p>
			</div>
		</div>
	<% end_loop %>
	<% if $Items.Count > 1 %>
		</div>
	</div>
	<% end_if %>
	</div>
</div>
