<?php

use SilverStripe\i18n\i18n;
use SilverStripe\Admin\CMSMenu;
use SilverStripe\Core\Environment;
use SilverStripe\Control\Email\Email;
use Wilr\GoogleSitemaps\GoogleSitemap;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;
use SilverStripe\CMS\Controllers\CMSPagesController;
use SilverStripe\Core\Manifest\ModuleResourceLoader;

Email::config()->set('admin_email', Environment::getEnv('SS_ADMIN_EMAIL'));

// Set the site locale
i18n::set_locale('de_CH');

// TinyMCE Config
$styles = [
    [
        // https://github.com/tinymce/tinymce/issues/9186
        'title' => 'Format',
        'selector' => '*'
    ],
    [
        // Wrap selected content in a div with class of .split-2
        'title' => '2 Spalten (auto-flow)',
        'attributes' => ['class' => 'split-2'],
        'block' => 'div',
        'wrapper' => 1
    ],
    [
        // Wrap selected content in a div with class of .boxed
        'title' => 'Box',
        'attributes' => ['class' => 'boxed'],
        'block' => 'div',
        'wrapper' => 1
    ],
    [
        // add .download to a a
        'title' => 'Download-Link',
        'attributes' => ['class' => 'download'],
        'selector' => 'a'
    ],
    [
        // add .forth to a a
        'title' => 'Arrow-Link',
        'attributes' => ['class' => 'forth'],
        'selector' => 'a'
    ],
    [
        // add .button to a a
        'title' => 'Button-Link',
        'attributes' => ['class' => 'button'],
        'selector' => 'a'
    ],
    [
        // Wrap selected content in a div with class of .small
        'title' => 'small',
        'attributes' => ['class' => 'small'],
        'block' => 'div',
        'wrapper' => 1
    ],
    [
        // Wrap selected content in a div with class of .large
        'title' => 'large',
        'attributes' => ['class' => 'large'],
        'block' => 'div',
        'wrapper' => 1
    ],
    [
        // add .inlinish - no margin-bottom
        'title' => 'no bottom-margin',
        'attributes' => ['class' => 'inlinish'],
        'selector' => 'p,h1,h2,h3'
    ],
    [
        // add .halvelinish - halve-line margin-bottom
        'title' => '½ bottom-margin',
        'attributes' => ['class' => 'halvelinish'],
        'selector' => 'p,h1,h2,h3'
    ]
];

$EditorConfig = TinyMCEConfig::get('cms');

$EditorConfig->enablePlugins([
    'image' => null,
    'anchor' => null,
    'sslinkanchor' => null,
    'sslink',
    'sslinkinternal',
    'emoticons',
    'charmap',
    // 'definitionlists' => ModuleResourceLoader::resourceURL('app/thirdparty/tinymce-definitionlist-master/definitionlist/plugin.js') // needs Buttons: ToggleDefinitionList ToggleDefinitionItem
]);
$EditorConfig->disablePlugins(['importcss']);

$editorOptions = [
    'style_formats' => $styles,
    'block_formats' => 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3; Heading 4=h4',
    'paste_remove_spans' => true,
    'paste_as_text' => true,
    'paste_text_sticky_default' => true,
    'paste_text_sticky' => true,
    'statusbar' => true,
    'contextmenu' => "searchreplace | sslink anchor ssmedia ssembed"
];
$EditorConfig->setOptions($editorOptions);

// $EditorConfig->setButtonsForLine(1, ['blocks styles pastetext ssmedia ssembed | bold bullist numlist ToggleDefinitionList ToggleDefinitionItem | alignleft aligncenter alignright alignjustify | sslink unlink anchor | charmap hr code removeformat blockquote emoticons | outdent indent | undo redo | subscript superscript']);
$EditorConfig->setButtonsForLine(1, ['blocks styles pastetext ssmedia ssembed | bold bullist numlist | alignleft aligncenter alignright alignjustify | sslink unlink anchor | charmap hr code removeformat blockquote emoticons | outdent indent | undo redo']);
$EditorConfig->setButtonsForLine(2, '');

$EditorConfig->setOption(
    'extended_valid_elements',
    'span[data-feather]'
    // 'div[*]'
);

$SimpleCfg = TinyMCEConfig::get('inlite');
$SimpleCfg->setOptions($editorOptions);
$SimpleCfg->setButtonsForLine(1, ['blocks pastetext | bold bullist numlist | alignleft aligncenter alignright alignjustify | sslink unlink anchor | charmap hr code removeformat emoticons | undo redo']);
$SimpleCfg->setButtonsForLine(2,'');

CMSMenu::remove_menu_item('SilverStripe-Reports-ReportAdmin');
CMSMenu::remove_menu_item('SilverStripe-CampaignAdmin-CampaignAdmin');
CMSMenu::remove_menu_item('SilverStripe-Admin-SecurityAdmin');
CMSMenu::remove_menu_item('SilverStripe-VersionedAdmin-ArchiveAdmin');
// CMSMenu::remove_menu_item('SilverStripe-SiteConfig-SiteConfigLeftAndMain');
CMSPagesController::config()->help_links = [];

// SilverStripe\ORM\DB::query("SET SESSION sql_mode='REAL_AS_FLOAT,PIPES_AS_CONCAT,ANSI_QUOTES,IGNORE_SPACE';");

URLSegmentFilter::config()->default_replacements = [
    '/&amp;/u' => '-und-',
    '/&/u' => '-und-',
    '/\s|\+/u' => '-', // remove whitespace/plus
    '/[_.]+/u' => '-', // underscores and dots to dashes
    '/[^A-Za-z0-9\-]+/u' => '', // remove non-ASCII chars, only allow alphanumeric and dashes
    '/[\/\?=#:]+/u' => '-', // remove forward slashes, question marks, equal signs, hashes and colons in case multibyte is allowed (and non-ASCII chars aren't removed)
    '/[\-]{2,}/u' => '-', // remove duplicate dashes
    '/^[\-]+/u' => '', // Remove all leading dashes
    '/[\-]+$/u' => '' // Remove all trailing dashes
];

// GoogleSitemap::register_dataobjects(['App\Models\Perso'], 'weekly', '1');
// GoogleSitemap::register_dataobjects(['App\Models\JobPosting'], 'weekly', '1');
