<% vite 'src/css/persocfa.css' %>
<div class="typography">
	<div class="persos">
		<% if $Items.Count > 1 %>
			<% vite 'src/css/swiper.css', 'src/js/swiper.js' %>
			<div class="swiper-container perso-cfa" id="general-swiper-{$ID}">
				<div class="swiper-wrapper perso-cfa">
		<% end_if %>
		<% loop $Items %>
			<div class="swiper-slide perso {$Up.Layout}">
				<figure class="{$ElementLayout}<% if $ImageCover %> image-cover<% end_if %>">
					<% if $Portrait %>
						<% with $Portrait %>
							<img loading="lazy" alt="$Title" width="{$FocusFillMax(600,600).Width()}" height="{$FocusFillMax(600,600).Height()}"
								style="object-position: {$FocusFillMax(600,600).FocusPoint.PercentageX}% {$FocusFillMax(600,600).FocusPoint.PercentageY}%;"
								src="$FocusFillMax(600,600).Convert('webp').URL"
								srcset="$FocusFillMax(600,600).Convert('webp').URL 1x, $FocusFillMax(1200,1200).Convert('webp').URL 2x" />
						<% end_with %>
					<% else %>
						<img class="default" src="{$viteAsset('src/images/svg/perso-defalut.svg')}" alt="" />
					<% end_if %>
				</figure>
				<div class="txt">
					<% with $Up %>
						<% include App/Includes/ElementTitle %>
						<% if $Above %>{$Above}<% end_if %>
					<% end_with %>
					<p class="name inline">
						<strong>{$Firstname} {$Lastname}</strong>
						<% if $Position %><br/>
							<span class="position">$Position</span>
						<% end_if %>
					</p>
					<p>
						<% if $EMail %><a class="mail" href="mailto:{$EMail}">{$EMail}</a><% end_if %>
						<% if $Telephone %><a class="phone" href="tel:{$Telephone.TelEnc}">{$Telephone}</a><% end_if %>
						<% if $EMail && $Telephone %>
							<a class="vcard" href="/_vc/{$ID}" title="vCard">vCard</a>
							<% if $CurrentMember %>
								<a class="qrcode" href="/_pqr/{$ID}" target="_blank" title="vCard">QR-Code</a>
							<% end_if %>
						<% end_if %>
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
