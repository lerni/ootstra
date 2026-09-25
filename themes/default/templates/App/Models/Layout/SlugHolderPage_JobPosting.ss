<% vite 'src/css/jobs.css', 'src/css/persocfa.css', 'src/css/swiper.css', 'src/js/swiper.js' %>
<% include App/Includes/Header %>
<main>
	<% with $CurrentItem %>
		<% if $Slides %>
			<article class="element elementhero spacing-bottom-2 full-width<% if $SiteConfig.GlobalAlert %> global-alert<% end_if %>"><% include App/Includes/Slides Items=$Slides %></article>
		<% else_if $SiteConfig.DefaultHeaderSlides.Count() %>
			<% include App/Includes/DefaultHero Page=$Me %>
		<% end_if %>
		<% if $SiteConfig.GlobalAlert %><article class="global-alert">
			<div class="typography inner">$SiteConfig.GlobalAlert</div>
		</article><% end_if %>

		<nav class="breadcrumbs"><div class="inner">{$Breadcrumbs}</div></nav>

		<article id="$URLSegment" class="element elementjobs horizontal-spacing width-reduced spacing-top-1 spacing-bottom-2">
			<div class="typography">
				<% if not $LastFor %>
					<div class="alert alert-warning"><%t Kraftausdruck\Models\JobPosting.expired 'expired' %></div>
				<% end_if %>
				<h1 class="element-title">{$Title}</h1>
				$Description
				$JobPostingSchema.RAW
			</div>
		</article>

		<% if $Inserat %><article class="element pdf-download background--section horizontal-spacing spacing-top-2 spacing-bottom-2">
			<div class="swiper multiple" data-id="{$ID}" id="hero-swiper-{$ID}">
				<div class="swiper-wrapper">
					<% if $Inserat.PDFImage('webp', 1000, 1) %>
						<a href="{$Inserat.URL}" class="swiper-slide" target="_blank" rel="noopener noreferrer">
							<img width="500" height="707"
								src="$Inserat.PDFImage('webp', 1000, 1).FillMax(500,707).URL"
								srcset="$Inserat.PDFImage('webp', 1000, 1).FillMax(500,707).URL 1x, $Inserat.PDFImage('webp', 1000, 1).FillMax(1000,1414).URL 2x"
								alt="{$Title}" />
						</a>
					<% end_if %>
					<% if $Inserat.PDFImage('webp', 1000, 2) %>
						<a href="{$Inserat.URL}" class="swiper-slide" target="_blank" rel="noopener noreferrer">
							<img width="500" height="707"
								src="$Inserat.PDFImage('webp', 1000, 2).FillMax(500,707).URL"
								srcset="$Inserat.PDFImage('webp', 1000, 2).FillMax(500,707).URL 1x, $Inserat.PDFImage('webp', 1000, 2).FillMax(1000,1414).URL 2x"
								alt="{$Title}" />
						</a>
					<% end_if %>
					<% if $Inserat.PDFImage('webp', 1000, 3) %>
						<a href="{$Inserat.URL}" class="swiper-slide" target="_blank" rel="noopener noreferrer">
							<img width="500" height="707"
								src="$Inserat.PDFImage('webp', 1000, 3).FillMax(500,707).URL"
								srcset="$Inserat.PDFImage('webp', 1000, 3).FillMax(500,707).URL 1x, $Inserat.PDFImage('webp', 1000, 3).FillMax(1000,1414).URL 2x"
								alt="{$Title}" />
						</a>
					<% end_if %>
					<% if $Inserat.PDFImage('webp', 1000, 4) %>
						<a href="{$Inserat.URL}" class="swiper-slide" target="_blank" rel="noopener noreferrer">
							<img width="500" height="707"
								src="$Inserat.PDFImage('webp', 1000, 4).FillMax(500,707).URL"
								srcset="$Inserat.PDFImage('webp', 1000, 4).FillMax(500,707).URL 1x, $Inserat.PDFImage('webp', 1000, 4).FillMax(1000,1414).URL 2x"
								alt="{$Title}" />
						</a>
					<% end_if %>
					<% if $Inserat.PDFImage('webp', 1000, 5) %>
						<a href="{$Inserat.URL}" class="swiper-slide" target="_blank" rel="noopener noreferrer">
							<img width="500" height="707"
								src="$Inserat.PDFImage('webp', 1000, 5).FillMax(500,707).URL"
								srcset="$Inserat.PDFImage('webp', 1000, 5).FillMax(500,707).URL 1x, $Inserat.PDFImage('webp', 1000, 5).FillMax(1000,1414).URL 2x"
								alt="{$Title}" />
						</a>
					<% end_if %>
				</div>
			</div>
			<div class="typography">
				<a class="button center" href="{$Inserat.URL}" target="_blank" rel="noopener noreferrer">PDF-Öffnen</a>
			</div>
		</article><% end_if %>

		<% if $Up.JobApplicationForm %>
			<article id="jobapplicationform" class="element horizontal-spacing spacing-top-2 spacing-bottom-2">
				<div class="typography">
					<% if $Up.JobApplicationSuccess %>
						$JobDefaults.AfterSubmissionHTML
					<% else %>
						<% if $JobDefaults.CallForActionForm %><h1 class="element-title">{$JobDefaults.CallForActionForm}</h1><% end_if %>
						$Up.JobApplicationForm
					<% end_if %>
				</div>
			</article>
		<% end_if %>

		<% if $ContactPerso %>
		<article class="element horizontal-spacing elementpersocfa spacing-top-2 spacing-bottom-2<% if $SectionColor %> background--section<% end_if %>">
			<div class="typography">
				<div class="persos">
					<% with $ContactPerso %>
						<div class="swiper-slide perso {$Up.Layout}">
							<figure>
								<div>
								<% if $Portrait %>
									<% with $Portrait %>
										<img loading="lazy" alt="$Title" width="{$FocusFillMax(300,300).Width()}" height="{$FocusFillMax(300,300).Height()}"
											<% if $FocusPoint.PercentageX != 50 || $FocusPoint.PercentageY != 50 %>style="object-position: {$FocusFillMax(300,300).FocusPoint.PercentageX}% {$FocusFillMax(300,300).FocusPoint.PercentageY}%;"<% end_if %>
											src="$FocusFillMax(300,300).Convert('webp').URL"
											srcset="$FocusFillMax(300,300).Convert('webp').URL 1x, $FocusFillMax(600,600).Convert('webp').URL 2x" />
									<% end_with %>
								<% else %>
									<img class="default" src="{$viteAsset('src/images/svg/perso-defalut.svg')}" alt="" />
								<% end_if %>
								</div>
							</figure>

							<div class="txt">
								<% with $Up %>
									<h3>{$JobDefaults.CFA}</h3>
								<% end_with %>
								<p class="name inline">
									<strong>{$Firstname} {$Lastname}</strong>
									<% if $Position %><br/>
										<span class="position">$Position</span>
									<% end_if %>
								</p>
								<p>
									<% if $EMail %><a class="mail" href="mailto:{$EMail}">{$EMail}</a><% end_if %>
									<% if $Telephone %><a class="phone" href="tel:{$Telephone.TelEnc}">{$Telephone}</a><% end_if %>
									<% if $EMail && $Telephone %>
										<a class="vcard" href="/_vc/{$ID}" title="vCard">vCard</a>
										<% if $CurrentMember %>
											<a class="qrcode" href="/_pqr/{$ID}" target="_blank" title="vCard">QR-Code</a>
										<% end_if %>
									<% end_if %>
								</p>
							</div>
						</div>
					<% end_with %>
				</div>
			</div>
		</article><% end_if %>
	<% end_with %>
</main>
