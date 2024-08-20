<div id="$Anchor" class="expandable__cell perso is--collapsed">
	<div class="item--basic">
		<% if $Portrait %>
			<img loading="lazy" height="$Portrait.FocusFillMax(305,400).Height()" width="$Portrait.FocusFillMax(305,400).Width()" src="$Portrait.FocusFillMax(305,400).WebP.URL" srcset="$Portrait.FocusFillMax(305,400).WebP.URL 1x, $Portrait.FocusFillMax(610,800).WebP.URL 2x" alt="{$Firstname} {$Lastname}" />
		<% else %>
			<img class="default" src="$resourceURL('themes/default/dist/images/svg/perso-defalut.svg')" alt="" />
		<% end_if %>
		<div class="txt">
			<h2>{$Firstname} {$Lastname}</h2>
			<% if $Position %>
				<span class="position">$Position.Markdowned</span>
			<% end_if %>
			<span class="link forth"><%t App\Elements\ElementPerso.MORE "Curriculum Vitae" %></span>
		</div>
		<div class="arrow--up"></div>
	</div>
	<div class="item--expand">
		<a href="#item-{$ID}" class="expand__close" aria-label="<%t App\Models\Perso.CLOSE 'Close details' %> {$Title}"></a>
		<h2>{$Firstname} {$Lastname}</h2>
		<p>
			<% if $Position %>
				<span class="position">$Position</span>
			<% end_if %>
		</p>
		<div class="columned">
			<div class="col">$Motivation</div>
			<div class="col">
				<p>
					<% if $EMail %><a class="vcard" href="{$Top.Element.Controller.Link('vcard')}/{$ID}">vCard</a><br/><% end_if %>
					<% if $EMail %><span data-feather="mail"></span><a href="mailto:{$EMail}">{$EMail}</a><% end_if %>
				</p>
			</div>
		</div>
	</div>
</div>

<%-- simple
<div id="$Anchor" class="perso">
	<% if $Portrait %>
		<img loading="lazy" height="$Portrait.FocusFillMax(305,400).Height()" width="$Portrait.FocusFillMax(305,400).Width()" src="$Portrait.FocusFillMax(305,400).WebP.URL" srcset="$Portrait.FocusFillMax(305,400).WebP.URL 1x, $Portrait.FocusFillMax(610,800).WebP.URL 2x" alt="{$Firstname} {$Lastname}" />
	<% else %>
		<img class="default" src="$resourceURL('themes/default/dist/images/svg/perso-defalut.svg')" alt="" />
	<% end_if %>
	<div class="txt">
		<h2>{$Firstname} {$Lastname}</h2>
		<% if $Position %><div class="position">$Position.Markdowned</div><% end_if %>
		<% if $EMail && $Telephone %><p class="coordinates">
			<% if $EMail && $Telephone %><a class="vcard" href="{$Top.Element.Controller.Link}/vcard/{$ID}" title="vCard"></a><% end_if %>
			<% if $EMail %><a href="mailto:{$EMail}" title="{$EMail}"><span data-feather="mail"></span></a><% end_if %>
			<% if $Telephone %><a href="tel:{$Telephone.TelEnc}" title="{$Telephone}"><span data-feather="phone"></span></a><% end_if %>
		</p><% end_if %>
	</div>
</div> --%>
