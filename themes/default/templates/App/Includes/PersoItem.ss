<div id="$Anchor" class="expandable__cell perso is-collapsed">
	<div class="item--basic">
		<% if $Portrait %>
			<img src="$Portrait.FocusFillMax(305,400).URL" srcset="$Portrait.FocusFillMax(305,400).URL 1x, $Portrait.FocusFillMax(610,800).URL 2x" alt="{$Firstname} {$Lastname}" />
		<% else %>
			<img class="default" src="$resourceURL('themes/default/dist/images/svg/perso-defalut.svg')" alt="" />
		<% end_if %>
		<div class="txt">
			<h2>{$Firstname} {$Lastname}</h2>
			<p>
				<% if $Position %>
					<span class="position">$Position</span>
				<% end_if %>
			</p>
			<span class="pseudolink"><%t App\Elements\ElementPerso.MORE "none" %></span>
		</div>
		<div class="arrow--up"></div>
	</div>
	<div class="item--expand">
		<a href="#item-{$ID}" class="expand__close"></a>
		<h2>{$Firstname} {$Lastname}</h2>
		<p>
			<% if $Position %>
				<span class="position">$Position</span>
			<% end_if %>
		</p>
		<div class="columned">
			<div class="col">$Motivation</div>
			<div class="col">
				$Motivation2
				<p>
					<a class="vcard" href="{$Link}element/{$ElementID}/vcard/{$ID}">vCard</a><br/>
					<a href="mailto:{$EMail}">{$EMail}</a>
				</p>
			</div>
		</div>
	</div>
</div>
