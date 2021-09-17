<% with Series %><?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<atom:link href="{$Up.AbsoluteBaseURLTrimmed}{$Up.Link('')}rss" rel="self" type="application/rss+xml" />
<% if $Title %><title>$Title.XML</title><% end_if %>
<link>{$Up.AbsoluteBaseURLTrimmed}{$Up.Link('')}</link>
<% if $Locale %><language>$Locale</language><% end_if %>
<% if $Copyright %><copyright>$Copyright.XML</copyright><% end_if %>
<% if $Subtitle %><itunes:subtitle>$Subtitle.XML</itunes:subtitle><% end_if %>
<% if $Author %><itunes:author>$Author.XML</itunes:author><% end_if %>
<% if $Description %><itunes:summary>{$Description.Plain.XML}</itunes:summary>
<description>{$Description.Plain.XML}</description><% end_if %>
<% if $OwnerName || $OwnerEmail %><itunes:owner>
    <% if $OwnerName %><itunes:name>$OwnerName.XML</itunes:name><% end_if %>
    <% if $OwnerEmail %><itunes:email>$OwnerEmail.XML</itunes:email><% end_if %>
</itunes:owner><% end_if %>
<% if $Image %><itunes:image href="$Image.FocusFillMax(1200,542).getAbsoluteURL" />
<image>
	<url>$Image.FocusFillMax(1200,542).getAbsoluteURL</url>
	<% if $Title %><title>$Title.XML</title><% end_if %>
	<link>{$Up.AbsoluteBaseURLTrimmed}{$Up.Link('')}</link>
</image><% end_if %><% end_with %>
<% cached 'Episodes', $List(Kraftausdruck\Models\PodcastEpisode).max('LastEdited'), $List(Kraftausdruck\Models\PodcastEpisode).count() %>
	<% loop $Episodes %><item>
		<% if $Title %><title>$Title.XML</title><% end_if %>
		<% if $Author %><itunes:author><% loop $Author.PerLineText %>$Item.Plain.XML<% if not $Last %>, <% end_if %><% end_loop %></itunes:author><% end_if %>
		<% if $Subtitle %><itunes:subtitle>$Subtitle.XML</itunes:subtitle><% end_if %>
		<% if $Description %><itunes:summary>{$Description.Plain.XML}</itunes:summary>
		<description>{$Description.Plain.XML}</description><% end_if %>
		<% if $Image %><itunes:image href="$Image.getAbsoluteURL" /><% end_if %>
		<% if $Media %><enclosure url="$Media.getAbsoluteURL" length="$Media.getAbsoluteSize" type="$Media.getMimeType" />
		<guid>$Link</guid><% end_if %>
		<% if $DatePosted %><pubDate>$DatePosted.Rfc822</pubDate><% else %><pubDate>$Created.Rfc822</pubDate><% end_if %>
		<% if $Duration %><itunes:duration>$Duration</itunes:duration><% end_if %>
		<% if $Explicit %><itunes:explicit>$Explicit</itunes:explicit><% end_if %>
	</item><% end_loop %>
<% end_cached %>
</channel>
</rss>
