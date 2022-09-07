<% require themedCSS("dist/css/perso") %>
<% include App/Includes/Header %>
<% include App/Includes/Navigation %>
<main class="typography">
	<nav class="breadcrumbs"><div class="typography">{$Breadcrumbs}</div></nav>
	<article class="element elementperso real-url spacing-top-0 spacing-bottom-2 after-hero">
		<div class="typography">
			<% with $Perso %>
				<div class="persos single">
					<div id="$Anchor" class="perso">
						<figure>
							<% if $Portrait %>
								<img loading="lazy" height="$Portrait.FocusFillMax(400,480).Height()" width="$Portrait.FocusFillMax(400,480).Width()" src="$Portrait.FocusFillMax(400,480).URL" srcset="$Portrait.FocusFillMax(400,480).URL 1x, $Portrait.FocusFillMax(800,960).URL 2x" alt="{$Firstname} {$Lastname}" />
							<% else %>
								<img  class="default" src="$resourceURL('themes/default/dist/images/svg/perso-defalut.svg')" alt="" />
							<% end_if %>
							<img class="qrcode" src="{$QRURL.URL}">
						</figure>
						<div class="txt">
							<p class="name inlinish"><strong>{$Firstname} {$Lastname}</strong></p>
							<% if $Position %>
								<span class="position">$Position.Markdowned</span>
							<% end_if %>
							$Motivation
							<p>
								<span class="links">
									<a class="vcard" href="{$Link}element/{$ElementID}/vcard/{$ID}">vCard</a>
									<% if $EMail %><a href="mailto:{$EMail}">{$EMail}</a><% end_if %>
									<% if $Telephone %><a href="tel:{$Telephone.TelEnc}">{$Telephone}</a><% end_if %>
								</span>
							</p>
						</div>
					</div>
					$PersoSchema.RAW
				</div>
				<a class="parent-link back" href="$Top.Link">$Top.MenuTitle</a>
			<% end_with %>
		</div>
	</article>
</main>
