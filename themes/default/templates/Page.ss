<!DOCTYPE html>
<html lang="{$ContentLocale}" class="nojs">
<head>
	$MetaTags(false)
	<% if $MetaTitle %>
		<title>$MetaTitle</title>
	<% else %>
		<title>$DefaultMetaTitle</title>
	<% end_if %>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<% if not $MetaDescription %>
		<% if $DefaultMetaDescription %><meta name="Description" content="$DefaultMetaDescription" /><% end_if %>
	<% end_if %>
	<% include App/Includes/Favicon %>
	<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@200;400&display=swap" rel="stylesheet">
	<% require themedCSS('dist/css/style') %>
	<style type="text/css">
		@font-face {
			font-family: "icons";
			src:url("$resourceURL('app/fonts/icons.woff2')") format('woff2'),
			url("$resourceURL('app/fonts/icons.woff')") format('woff');
			font-style: normal;
		}
	</style>
</head>
<body class="{$ClassName.ShortName.LowerCase}">
	{$Layout}
	<% include App/Includes/Footer %>
	<% if $isHomePage %>$LocalBusinessSchema.RAW<% end_if %>
</body>
</html>
