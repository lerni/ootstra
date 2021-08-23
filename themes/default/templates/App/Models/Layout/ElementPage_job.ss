<% include App/Includes/Header %>
<main class="typography">
	<% if $Job.HeaderImage %>
		<article class="element elementhero spacing-bottom-2">
			<figure>
				<% with $HeaderImage %><img sizes="100vw" alt="$Title"
					height="$FocusFillMax(1440,360).Height()"
					width="$FocusFillMax(1440,360).Width()"
					style="object-position: {$FocusFillMax(1440,360).PercentageX}% {$FocusFillMax(1440,360).PercentageY}%;"
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
	<% with $Job %>
		<article <% if $ElementAnchor %>id="$ElementAnchor"<% end_if %> class="element elementjobs show spacing-bottom-2">
			<div class="inner">
				<% if not $LastFor %>
					<div class="alert alert-warning"><%t Kraftausdruck\Models\JobPosting.expired %></div>
				<% end_if %>
				$Description
				<% if $InseratID %><a class="download" href="$Inserat.Link">$Inserat.Title</a><% end_if %>
				<a href="$Parent.Link" class="parent-link back">$Parent.Parent.OwnerPage.MenuTitle</a>
				$JobPostingSchema.RAW
			</div>
		</article>
	<% end_with %>
</main>
