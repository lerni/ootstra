<a class='embed-thumbnail <% if ShowThumbnail %><% else %>empty<% end_if %>' target='_blank'>
<img src='$ThumbnailURL' id='{$ID}_Thumbnail' title='$ThumbnailTitle' alt='' />
</a>

<div class="fieldholder-small">
    $SourceURL
    <button 
        type="button"
        value="Add url"
        class="action btn <% if $ThumbnailURL %>btn-outline-primary<% else %>btn-primary<% end_if %> cms-content-addpage-button tool-button <% if $ThumbnailURL %>font-icon-tick<% else %>font-icon-rocket<% end_if %>"
        data-icon="add"
        role="button"
        aria-disabled="false"
        disabled="false">
        <% if $ThumbnailURL %>
            <span>Update URL</span>
        <% else %>
            <span>Add URL</span>
        <% end_if %>
    </button>
</div>
<em id='{$ID}_message' class='embedfield-message'></em>

<div class='clear'></div>
