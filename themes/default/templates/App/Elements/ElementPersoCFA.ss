<div class="inner typography">
	<% include App/Includes/ElementTitle %>
    <div class="persos">
    <% loop $Items %>
        <div class="perso">
            <% if $Portrait %>
                <img src="$Portrait.FocusFillMax(305,400).URL" srcset="$Portrait.FocusFillMax(305,400).URL 1x, $Portrait.FocusFillMax(610,800).URL 2x" alt="{$Firstname} {$Lastname}" />
            <% else %>
				<img src="$resourceURL('themes/default/dist/images/svg/perso-defalut.svg')" alt="$Title" />
            <% end_if %>
            <div class="txt">
                <h2>{$Firstname} {$Lastname}</h2>
                <p>
                    <% if $Position %>
                        <span class="position">$Position</span>
                    <% end_if %>
                    <a href="mailto:{$EMail}"></a>
                </p>
                <a class="pseudolink" href="{$list('App\Elements\ElementPerso').First.Page.Link}#{$Anchor}"><%t App\Elements\ElementPerso.MORE "none" %></a>
            </div>
        </div>
    <% end_loop %>
</div>
