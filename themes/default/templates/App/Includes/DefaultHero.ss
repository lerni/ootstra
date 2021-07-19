<article class="element elementhero default spacing-bottom-2<% if $Top.ClassName == 'App\Models\ElementPage' && $Top.ParentID != 0 %> breadcrumbs<% end_if %>">
	<figure>
		<% if $SiteConfig.DefaultHeaderImageID %>
			<% with $SiteConfig.DefaultHeaderImage %>
				<img sizes="100vw" alt="$Title"
					height="$FocusFillMax(1440,360).Height()"
					width="$FocusFillMax(1440,360).Width()"
					style="object-position: {$FocusFillMax(1440,360).PercentageX}% {$FocusFillMax(1440,360).PercentageY}%;"
					src="$FocusFillMax(1440,360).URL"
					srcset="$FocusFillMax(480,120).URL 480w,
						$FocusFillMax(640,160).URL 640w,
						$FocusFillMax(720,180).URL 720w,
						$FocusFillMax(800,200).URL 800w,
						$FocusFillMax(1000,250).URL 1000w,
						$FocusFillMax(1200,300).URL 1200w,
						$FocusFillMax(1440,360).URL 1440w,
						$FocusFillMax(1600,400).URL 1600w,
						$FocusFillMax(2000,500).URL 2000w,
						$FocusFillMax(2600,650).URL 2600w" />
			<% end_with %>
		<% end_if %>
	</figure>
</article>
