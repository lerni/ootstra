<!DOCTYPE html>
<html lang="{$ContentLocale}">
<head>
	$MetaTags(false)
	<% if $MetaTitle %>
		<title>$MetaTitle</title>
	<% else %>
		<title>$DefaultMetaTitle</title>
	<% end_if %>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<% if not $MetaDescription %>
		<% if $DefaultMetaDescription %><meta name="Description" content="$DefaultMetaDescription" /><% end_if %>
	<% end_if %>
	<% include App/Includes/Favicon %>
	<link rel="preload" as="font" type="font/woff2" crossorigin href="{$viteAsset('src/fonts/figtree-v9-latin-regular.woff2')}">
	<link rel="preload" as="font" type="font/woff2" crossorigin href="{$viteAsset('src/fonts/figtree-v9-latin-600.woff2')}">
	<% vite 'src/css/style.css', 'src/js/app.js' %>
</head>
<body class="{$ShortClassName($this, true)}">
	{$Layout}
	<% include App/Includes/Footer %>
	<% if $isHomePage %>$OrganisationSchema.RAW<% end_if %>
	$BreadcrumbListSchema.RAW
</body>
</html>
