<% vite 'src/css/perso.css' %>
<% include App/Includes/Header %>
<% include App/Includes/Navigation %>
<main class="typography">
	<nav class="breadcrumbs"><div class="inner">{$Breadcrumbs}</div></nav>
	<article class="element elementperso details horizontal-spacing spacing-top-0 spacing-bottom-2 after-hero">
		<div class="typography">
			<% with $CurrentItem %>
				<div class="persos single">
					<div id="$Anchor" class="perso">
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
						</div>
					</div>
					$PersoSchema.RAW
				</div>
				<% if $Motiation %><div class="motivation">{$Motivation}</div><% end_if %>
				<a class="parent-link back" href="$Top.Link">$Top.MenuTitle</a>
			<% end_with %>
		</div>
	</article>
</main>
