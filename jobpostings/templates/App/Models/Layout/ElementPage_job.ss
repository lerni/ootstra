<% include App/Includes/Header %>
<main class="typography">
	<% with $Job %>
		<% if $HeaderImage %>
			<article class="element elementhero spacing-bottom-2">
				<figure>
					<% with $HeaderImage %><img sizes="100vw" alt="$Title"
						height="$FocusFillMax(1440,360).Height()"
						width="$FocusFillMax(1440,360).Width()"
						style="object-position: {$FocusFillMax(1440,360).FocusPoint.PercentageX}% {$FocusFillMax(1440,360).FocusPoint.PercentageY}%;"
						src="$FocusFillMax(1440,360).URL"
						srcset="$FocusFillMax(480,120).URL 480w,
							$FocusFillMax(640,160).URL 640w,
							$FocusFillMax(800,20).URL 800w,
							$FocusFillMax(1000,250).URL 1000w,
							$FocusFillMax(1200,300).URL 1200w,
							$FocusFillMax(1440,360).URL 1440w,
							$FocusFillMax(1600,400).URL 1600w,
							$FocusFillMax(1800,450).URL 1800w,
							$FocusFillMax(2000,500).URL 2000w,
							$FocusFillMax(2600,650).URL 2600w" />
					<% end_with %>
				</figure>
			</article>
		<% else %>
			<% include App/Includes/DefaultHero Page=$Me %>
		<% end_if %>
		<article id="$URLSegment" class="element elementjobs show spacing-bottom-2">
			<div class="inner">
				<% if not $LastFor %>
					<div class="alert alert-warning"><%t Kraftausdruck\Models\JobPosting.expired 'expired' %></div>
				<% end_if %>
				$Description
				<% if $InseratID %><a class="download" href="$Inserat.Link">$Inserat.Title</a><% end_if %>
				<a href="$Parent.Link" class="parent-link back">$Parent.Parent.OwnerPage.MenuTitle</a>
				$JobPostingSchema.RAW
				$Parent.Page.OrganisationSchema.RAW
			</div>
		</article>
		<% if $ContactPerso %>
			<article class="element elementpersocfa elementjobpostingcfa background--green-lighter spacing-top-2 spacing-bottom-2">
				<div class="inner">
				<% with $ContactPerso %>
					<p><strong>{$JobDefaults.CFA}</strong></p>
					<div class="persos">
					<div class="perso">
						<figure>
						<% if $Portrait %>
							<img style="object-position: {$Portrait.FocusFillMax(340,253).Focuspoint.PercentageX}% {$Portrait.FocusFillMax(340,253).Focuspoint.PercentageY}%;" height="$Portrait.FocusFillMax(340,253).Height()" width="$Portrait.FocusFillMax(340,253).Width()" src="$Portrait.FocusFillMax(340,253).URL" srcset="$Portrait.FocusFillMax(340,253).URL 1x, $Portrait.FocusFillMax(640,506).URL 2x" alt="{$Firstname} {$Lastname}" />
						<% else %>
							<img src="$resourceURL('themes/default/dist/images/svg/perso-defalut.svg')" alt="$Title" />
						<% end_if %>
						</figure>
						<div class="txt">
							<h2>{$Firstname} {$Lastname}</h2>
							<% if $Position %><p class="position">{$Position}</p><% end_if %>
							<p>{$Top.Text}</p>
							<% with $SiteConfig.Locations.First() %>
								<% if $Telephone %><a href="tel:{$Telephone.TelEnc}">{$Telephone}</a><% end_if %>
							<% end_with %>
							<% if $EMail %><a href="mailto:{$EMail}">{$EMail}</a><% end_if %>
						</div>
					</div>
					</div>
				<% end_with %>
				</div>
			</article>
		<% end_if %>
	<% end_with %>
</main>
