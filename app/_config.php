<?php

use Bigfork\Vitesse\Vite;
use SilverStripe\i18n\i18n;
use SilverStripe\Admin\CMSMenu;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Core\Config\Config;
use SilverStripe\Control\Email\Email;
use SilverStripe\TinyMCE\TinyMCEConfig;
use Wilr\GoogleSitemaps\GoogleSitemap;
use App\Utility\SnippetShortCodeProvider;
use App\Utility\LocationShortCodeProvider;
use App\Utility\VacationShortCodeProvider;
use SilverStripe\Core\Manifest\ModuleLoader;
use SilverStripe\View\Parsers\ShortcodeParser;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Core\Manifest\ModuleResourceLoader;

Email::config()->set('admin_email', Environment::getEnv('SS_ADMIN_EMAIL'));

// Set the site locale
// For multilingual sites using fluent: Commented out locale setting, as fluent will handle language configuration through its own setup.
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
        'wrapper' => true,
        'merge_siblings' => false
    ],
    [
        // Wrap selected content in a div with class of .boxed
        'title' => 'Box',
        'attributes' => ['class' => 'boxed'],
        'block' => 'div',
        'wrapper' => true,
        'merge_siblings' => false
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
        // add .back to a a
        'title' => 'Arrow-Back',
        'attributes' => ['class' => 'back'],
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
        'wrapper' => true,
        'merge_siblings' => false
    ],
    [
        // Wrap selected content in a div with class of .large
        'title' => 'large',
        'attributes' => ['class' => 'large'],
        'block' => 'div',
        'wrapper' => true,
        'merge_siblings' => false
    ],
    [
        // add .inline - no margin-bottom
        'title' => 'no bottom-margin',
        'attributes' => ['class' => 'inline'],
        'selector' => 'p,h1,h2,h3'
    ],
    [
        // add .halveinline - halve-line margin-bottom
        'title' => '½ bottom-margin',
        'attributes' => ['class' => 'halveinline'],
        'selector' => 'p,h1,h2,h3'
    ]
];

$editorCSS = Config::inst()->get(TinyMCEConfig::class, 'editor_css');
$editorPath = Vite::inst()->asset('src/css/editor.css');
if (!Vite::inst()->isRunningHot()) {
    $editorPath = Director::makeRelative($editorPath);
}
$editorCSS[] = $editorPath;
Config::modify()->set(TinyMCEConfig::class, 'editor_css', $editorCSS);

// Common plugins for all editor variants
$tinyMceModule = ModuleLoader::inst()->getManifest()->getModule('silverstripe/htmleditor-tinymce');
$tinyMceCommonPlugins = [
    'image' => null,
    'anchor' => null,
    'sslink' => $tinyMceModule->getResource('client/dist/js/TinyMCE_sslink.js'),
    'sslinkexternal' => $tinyMceModule->getResource('client/dist/js/TinyMCE_sslink-external.js'),
    'sslinkemail' => $tinyMceModule->getResource('client/dist/js/TinyMCE_sslink-email.js'),
    'emoticons',
    'charmap',
    'deflist' => ModuleResourceLoader::resourceURL('app/thirdparty/tinyMCE-DefinitionList-main/deflist/plugin.min.js')
];

// Common options for all editor variants
$tinyMceCommonOptions = [
    'style_formats' => $styles,
    'block_formats' => 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3; Heading 4=h4',
    'paste_remove_spans' => true,
    'paste_as_text' => true,
    'paste_text_sticky_default' => true,
    'paste_text_sticky' => true,
    'statusbar' => true,
    'contextmenu' => "searchreplace | sslink anchor ssmedia ssembed"
];

// -----------------------------------------------------------------------------
// Full CMS Editor Configuration
// -----------------------------------------------------------------------------
$EditorConfig = TinyMCEConfig::get('cms');
$EditorConfig->enablePlugins($tinyMceCommonPlugins);
$EditorConfig->disablePlugins(['importcss']);
$EditorConfig->setOptions($tinyMceCommonOptions);

// Full editor toolbar with all features
$EditorConfig->setButtonsForLine(1, [
    'blocks styles pastetext ssmedia ssembed | bold align | bullist numlist deflist | outdent indent | sslink anchor | emoticons charmap blockquote hr code removeformat visualblocks | undo redo'
]);
$EditorConfig->setButtonsForLine(2, '');
$EditorConfig->setOption(
    'extended_valid_elements',
    'span[data-feather],dl[*],dt[*],dd[*]'
    // 'div[*]'
);

// -----------------------------------------------------------------------------
// Simple Editor Configuration
// -----------------------------------------------------------------------------
$SimpleCfg = TinyMCEConfig::get('inlite');
$SimpleCfg->enablePlugins($tinyMceCommonPlugins);
$SimpleCfg->disablePlugins(['importcss']);
$SimpleCfg->setOptions($tinyMceCommonOptions);

// Additional plugins specific to simple editor
$phoneModule = ModuleLoader::inst()->getManifest()->getModule('firebrandhq/silverstripe-phonelink');
$SimpleCfg->enablePlugins([
    'sslinkinternal' => $tinyMceModule->getResource('client/dist/js/TinyMCE_sslink-internal.js'),
    'sslinkanchor' => $tinyMceModule->getResource('client/dist/js/TinyMCE_sslink-anchor.js'),
    'sslinkfile' => $tinyMceModule->getResource('client/dist/js/TinyMCE_sslink-file.js'),
    'sslinkphone' => $phoneModule->getResource('client/dist/js/TinyMCE_sslink-phone.js'),
]);

// Simplified toolbar with fewer options
$SimpleCfg->setButtonsForLine(1, [
    'blocks pastetext | bold align bullist numlist | sslink anchor | emoticons charmap hr code removeformat visualblocks | undo redo'
]);
$SimpleCfg->setButtonsForLine(2, '');

CMSMenu::remove_menu_item('SilverStripe-Reports-ReportAdmin');
CMSMenu::remove_menu_item('SilverStripe-CampaignAdmin-CampaignAdmin');
CMSMenu::remove_menu_item('SilverStripe-Admin-SecurityAdmin');
CMSMenu::remove_menu_item('SilverStripe-VersionedAdmin-ArchiveAdmin');
// CMSMenu::remove_menu_item('SilverStripe-SiteConfig-SiteConfigLeftAndMain');
LeftAndMain::config()->help_links = [];

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

ShortcodeParser::get('default')->register('Location', [LocationShortCodeProvider::class, 'parseLocationShortCodeProvider']);
ShortcodeParser::get('default')->register('Vacation', [VacationShortCodeProvider::class, 'parseVacationShortCodeProvider']);
ShortcodeParser::get('default')->register('Snippet', [SnippetShortCodeProvider::class, 'SnippetShortCodeProvider']);
