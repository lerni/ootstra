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
	<% vite 'src/css/style.css', 'src/js/app.js' %>
	<style type="text/css" nonce="{$Nonce}">
		@font-face {<%-- https://gwfh.mranftl.com/fonts --%>
			font-display: swap;
			font-family: "Figtree";
			font-style: normal;
			font-weight: 400;
			src: local(""), url("{$viteAsset('src/fonts/figtree-v5-latin-regular.woff2')}") format('woff2');
		}
		@font-face {
			font-display: swap;
			font-family: "Figtree";
			font-style: normal;
			font-weight: 600;
			src: local(""), url("{$viteAsset('src/fonts/figtree-v5-latin-600.woff2')}") format('woff2');
		}
	</style>
</head>
<body class="{$ShortClassName($this, true)}">
	{$Layout}
	<% include App/Includes/Footer %>
	<% if $isHomePage %>$OrganisationSchema.RAW<% end_if %>
	$BreadcrumbListSchema.RAW
</body>
</html>
