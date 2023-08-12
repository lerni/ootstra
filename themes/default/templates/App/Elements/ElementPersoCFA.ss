<% require themedCSS("dist/css/persocfa") %>
<div class="typography">
	<div class="persos">
	<% with $Items.First() %>
		<div class="perso">
			<figure>
				<% if $Portrait %>
					<img loading="lazy" height="$Portrait.FocusFillMax(305,400).Height()" width="$Portrait.FocusFillMax(305,400).Width()" src="$Portrait.FocusFillMax(305,400).URL" srcset="$Portrait.FocusFillMax(305,400).URL 1x, $Portrait.FocusFillMax(610,800).URL 2x" alt="{$Firstname} {$Lastname}" />
				<% else %>
					<img class="default" src="$resourceURL('themes/default/dist/images/svg/perso-defalut.svg')" alt="" />
				<% end_if %>
			</figure>
			<div class="txt">
				<% include App/Includes/ElementTitle %>
				<h2>{$Firstname} {$Lastname}</h2>
				<p class="name inlinish"><strong>{$Firstname} {$Lastname}</strong></p>
				<% if $Position %>
					<span class="position">$Position</span>
				<% end_if %>
				<p>
					<span class="links">
						<% if $EMail %><a href="mailto:{$EMail}">{$EMail}</a><% end_if %>
						<% if $Telephone %><a href="tel:{$Telephone.TelEnc}">{$Telephone}</a><% end_if %>
					</span>
				</p>
			</div>
		</div>
	<% end_with %>
	</div>
</div>
