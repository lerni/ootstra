<% include App/Includes/Header %>
<main class="typography">
	<% with $Job %>
		<article class="element elementhero spacing-bottom-2">
			<figure>
				<% with $HeaderImage %><img sizes="100vw" alt="$Title"
					style="object-position: {$SlideImage.FocusFillMax(2600,650).PercentageX}% {$SlideImage.FocusFillMax(2600,650).PercentageY}%;"
					src="$FocusFillMax(1440,360).URL"
					srcset="$FocusFillMax(480,120).URL 480w,
						$FocusFillMax(640,160).URL 640w,
						$FocusFillMax(720,100).URL 720w,
						$FocusFillMax(800,20).URL 800w,
						$FocusFillMax(1000,250).URL 1000w,
						$FocusFillMax(1200,300).URL 1200w,
						$FocusFillMax(1440,360).URL 1440w,
						$FocusFillMax(1600,400).URL 1600w,
						$FocusFillMax(1800,450).URL 1800w,
						$FocusFillMax(2000,500).URL 2000w,
						$FocusFillMax(2200,550).URL 2200w,
						$FocusFillMax(2400,600).URL 2400w,
						$FocusFillMax(2600,650).URL 2600w" />
				<% end_with %>
			</figure>
		</article>
		<article id="{$Slug}" class="element elementjobs show spacing-bottom-2">
			<div class="inner">
				<% if not $LastFor %>
					<div class="alert alert-warning"><%t App\Models\JobPosting.expired "false" %></div>
				<% end_if %>
				$Description
				<% if $InseratID %><a class="download" href="$Inserat.Link">$Inserat.Title</a><% end_if %>
				<a href="$Parent.Link" class="parent-link back">$Parent.Parent.OwnerPage.MenuTitle</a>
				$JobPostingSchema.RAW
			</div>
		</article>
	<% end_with %>
</main>
