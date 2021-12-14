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
	<script src="$resourceURL('/_resources/themes/default/thirdparty/instant-page.js')" nonce="{$Nonce}" type="module"></script>
	<% require themedCSS('dist/css/style') %>
	<style type="text/css" nonce="{$Nonce}">
		@font-face {<%-- https://google-webfonts-helper.herokuapp.com/fonts --%>
			font-family: 'IBM Plex Sans';
			font-style: normal;
			font-weight: 200;
			font-display: swap;
			src: local(''),
				url("$resourceURL('themes/default/dist/webfonts/ibm-plex-sans-v9-latin-200.woff2')") format('woff2'),
				url("$resourceURL('themes/default/dist/webfonts/ibm-plex-sans-v9-latin-200.woff')") format('woff');
		}
		@font-face {
			font-family: 'IBM Plex Sans';
			font-style: normal;
			font-weight: 400;
			font-display: swap;
			src: local(''),
				url("$resourceURL('themes/default/dist/webfonts/ibm-plex-sans-v9-latin-regular.woff2')") format('woff2'),
				url("$resourceURL('themes/default/dist/webfonts/ibm-plex-sans-v9-latin-regular.woff')") format('woff');
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
