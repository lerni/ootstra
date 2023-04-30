<form $FormAttributes class="SearchForm">
	<fieldset>
		<% loop $Fields %>
			$FieldHolder
		<% end_loop %>
		<div class="action">
			<% loop $Actions %>
				$Field
			<% end_loop %>
		</div>
	</fieldset>
</form>
<label for="Form_SearchForm_Search" class="txt">Suche</label>
