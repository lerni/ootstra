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
	<% require themedCSS('dist/css/style') %>
	<style type="text/css" nonce="{$Nonce}">
		@font-face {<%-- https://gwfh.mranftl.com/fonts --%>
			font-display: swap;
			font-family: 'Figtree';
			font-style: normal;
			font-weight: 400;
			src: url("$resourceURL('themes/default/dist/fonts/figtree-v5-latin-regular.woff2')") format('woff2');
		}
		@font-face {
			font-display: swap;
			font-family: 'Figtree';
			font-style: normal;
			font-weight: 700;
			src: url("$resourceURL('themes/default/dist/fonts/figtree-v5-latin-700.woff2')") format('woff2');
		}
		@font-face {
			font-family: "icons";
			src: url("$resourceURL('app/fonts/icons.woff2')") format('woff2'),
			url("$resourceURL('app/fonts/icons.woff')") format('woff');
			font-style: normal;
			font-display: block;
		}
	</style>
</head>
<body class="{$ClassName.ShortName.LowerCase}">
	{$Layout}
	<% include App/Includes/Footer %>
	<% if $isHomePage %>$OrganisationSchema.RAW<% end_if %>
	$BreadcrumbListSchema.RAW
</body>
</html>
