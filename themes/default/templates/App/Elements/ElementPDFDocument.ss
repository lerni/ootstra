<% include App/Includes/ElementTitle %>
<div class="typography">
	<% if $Document %>
		<a target="_blank" rel="noopener" class="pdf-download" href="$Document.Link">
			<img src="$Document.PDFThumbnail(1).FocusFillMax(300,424).URL" srcset="$Document.PDFThumbnail(1).FocusFillMax(300,424).URL 1x, $Document.PDFThumbnail(1).FocusFillMax(600,848).URL 2x" alt="Vorschau Seite 1 $Document.Title - $Document.Caption">
		</a>
	<% end_if %>
</div>
