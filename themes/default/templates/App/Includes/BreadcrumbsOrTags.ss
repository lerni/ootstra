<% if $ClassName == 'App\Elements\ElementHero' && $Page.hasHero() || $ClassName == 'App\Models\ElementPage' %>
    <% with $Page %>
        <nav class="breadcrumbs">
            <div class="inner">{$Breadcrumbs}</div>
        </nav>
    <% end_with %>
<% end_if %>
<% if ($Page.ClassName == 'SilverStripe\Blog\Model\BlogPost' || $Page.ClassName == 'SilverStripe\Blog\Model\Blog') && $ClassName == 'App\Elements\ElementHero' %>
    <% with $Page %>
        <% if $CategoriesWithState.Count > 0 %>
            <nav class="blog-post-meta inner">
                <% if $CategoriesWithState %>
                    <p class="blog-post-meta cats">
                        <a href="$Parent.Link" class="all" title="$Parent.Title"><%t SilverStripe\Blog\Model\Blog.Allcategories %></a>
                        <% loop $CategoriesWithState %>
                            <a href="$Link" class="$LinkingMode" title="$Title">$Title</a>
                        <% end_loop %>
                    </p>
                <% end_if %>
            </nav>
        <% end_if %>
    <% end_with %>
<% end_if %>
