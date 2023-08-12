<% include App/Includes/Header %>
<main>
	<% if not $hasHero %>
		<% include App/Includes/DefaultHero Page=$Me %>
	<% end_if %>
	<nav class="breadcrumbs"><div class="inner">{$Breadcrumbs}</div></nav>
	<article class="element elementperso horizontal-spacing spacing-top-0 spacing-bottom-2 after-hero">
		<div class="typography">
			<% with $Product %>
				<div class="product item is-visible" id="$Title.URLEnc" data-tags="<% loop $Categories %>$Title.URLEnc <% end_loop %>">
					<div class="txt">
						<% if $Categories.Count %><span class="tags"><% loop $Categories %>$Title<% if not $last %> | <% end_if %><% end_loop %></span><% end_if %>
						<% if $RelatedPage %>
							<a href="$RelatedPage.Link"><h4>$Title</h4></a>
						<% else %>
							<h4>$Title</h4>
						<% end_if %>
						$Description
						<% if $IsAvailable %>
							<span class="product-item">
								<input type="radio" name="{$ArticleNo}" value="{$ArticleNo}" id="{$ArticleNo}" checked>
								<label for="{$ArticleNo}">
									{$Unit}
									<span class="separator">|</span>
									<% if $Price %>{$Price.Nice(2)} <%t Kraftausdruck\Basket\Basket.Currency %><% end_if %>
								</label>
								<div class="prod-check"></div>
							</span>
							<% if $Variation %><span class="product-item">
								<input type="radio" name="{$ArticleNo}" value="{$Variation.Title}" id="{$Variation.Title}">
								<label for="{$Variation.Title}">
									{$Variation.Unit}
									<span class="separator">|</span>
									<% if $Variation.Price %>{$Variation.Price.Nice(2)} <%t Kraftausdruck\Basket\Basket.Currency %><% end_if %>
								</label>
								<div class="prod-check"></div>
							</span><% end_if %>
							<div>
								<div class="quantity">
									<span class="add-down add-action">-</span>
									<input type="number" min="1" max="99" name="quantity" value="1" aria-label="Anzahl"/>
									<span class="add-up add-action">+</span>
								</div>
								<span class="button--white-hg add--product-item"><%t Kraftausdruck\Basket\Basket.BasketAddTo "in den Warenkorb" %></span>
							</div>
						<% else %>
							<div>
								<%t Kraftausdruck\Basket\Basket.NotAvailable "Zurzeit nicht lieferbar" %>
							</div>
						<% end_if %>
					</div>
					<div class="figure">
						<% if $Images.Count > 1 %>
							<div class="product-swiper swiper-container article" data-id="{$pos}" id="article-swiper{$pos}">
								<div class="swiper-wrapper">
									<% loop $Images.Sort("ImageSortOrder ASC") %>
										<div class="swiper-slide">
										<img <% if not $First %>loading="lazy" <% end_if %>height="480" width="480" src="$FocusFillMax(480,480).URL" srcset="$FocusFillMax(480,480).URL 1x, $FocusFillMax(960,960).URL 2x" alt="$Title" />
										</div>
									<% end_loop %>
								</div>
								<div class="swiper-button-prev article" id="article-swiper-prev{$pos}"></div>
								<div class="swiper-button-next article" id="article-swiper-next{$pos}"></div>
							</div>
						<% else %>
							<% loop $Images %>
								<img <% if not $First %>loading="lazy" <% end_if %>height="480" width="480" src="$FocusFillMax(480,480).URL" srcset="$FocusFillMax(480,480).URL 1x, $FocusFillMax(960,960).URL 2x" alt="$Title" />
							<% end_loop %>
						<% end_if %>
					</div>
				</div>
			<% end_with %>
			<a class="parent-link back" href="$Parent.Link">$Parent.MenuTitle</a>
		</div>
	</article>
</main>
