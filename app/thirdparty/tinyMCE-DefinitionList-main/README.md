# tinyMCE-DefinitionList

 ![Latest Stable Version](https://img.shields.io/badge/release-v0.9.0-brightgreen.svg)
 ![License](https://img.shields.io/badge/license-GPLv3-blue) 
 [![Donate](https://img.shields.io/static/v1?label=donate&message=PayPal&color=orange)](https://www.paypal.me/SKientzler/5.00EUR)

- [Description](#description)
- [Installation](#installation)
  - [Usage as external plugin](#usage-as-external-plugin)
  - [Usage as internal plugin](#usage-as-internal-plugin)
- [Configuration](#configuration)
  - [Add the splitbutton to the toolbar](#add-the-splitbutton-to-the-toolbar)
  - [Activate the items in the contextmenu](#activate-the-items-in-the-contextmenu)
- [Localization](#localization)

---
## Description

**Plugin for tinyMCE (Version 6.x) to insert and edit definition lists.**

This plugin allows you to insert a split button into the toolbar of a tinyMCE editor 
to create a definition list and set headings and descriptions within this list.  

It contains:

1. **A splitbutton for the toolbar**   
   A definitionlist canbe startet with a click on the button. If the cursor/selection 
   is inside of a definitionlist, the entries kann be toggled between heading and 
   description by selection of one of the splitbutton options.
2. **Entries to the contextmenu**  
   The functionality to toggle between heading and description inside of a d
   efinitionlist can also be added to the tinyMCE's contextmenu. If the user 
   right-clicks on an item inside of a definitionlist, he can change a title 
   to a description or vise versa.

> The tinyMCE core 'lists' plugin basically contains the entire functionality for 
> inserting definition lists - although unfortunately neither a toolbar button nor
> a menu entry is defined for this :-(  
> *(i've no idea, why this little step wasn't done inside of the existing plugin...).*
>
> To toggle the button state correctly, some internal functions are required, which 
> would make it very complex to implement the desired button via 
> `tinymce.init('{... setup => ...}')`  
>
> For this reason, this additional plugin was created, in which the mentioned internal 
> helper functions were copied from the above plugin and also the `InsertDefinitionList`
> command implemented there is called directly.

## Installation

Download the latest release and copy the `deflist` folder 
1. In any path on your server as 'external plugin'
2. In the 'plugin' folder of your self hosted version of **tinyMCE** to use it as
   'internal plugin'
   
**Note:**  
This plugin uses commands and functionality from the core tinyMCE 'lists' plugin 
and therefore this plugin needs to be enabled in addition.
   
### Usage as 'external plugin'

If you are loading tinyMCE from a CDN or want to separate your custom plugins
from the core installation, you have to load placeholder as external plugin:

```JS
tinymce.init({
  selector: 'your_editor',
  plugins: '... lists ...',
  external_plugins: {
    'deflist': 'http://www.yourdomain.com/yourplugins/deflist/plugin.min.js',
  }
  ...
});
```

Loading as external plugin, you can use either the `plugin.min.js`or the `plugin.js` 
version - regardless of the version of ***tinyMCE*** (`tinymce.js / tinymce.min.js`)
you have loaded!
> The `.min.js` file is a compressed/minified version of the `.js` file. Using the 
> full version takes longer to load but the source is readable and allows debuging.

For details, especially regarding the absolute or relative path of the plugin URL, 
see:  
https://www.tiny.cloud/docs/tinymce/6/editor-important-options/#external_plugins
   
### Usage as 'internal plugin'

To load placeholder as internal plugin, the `deflist` folder **MUST** be a
subfolder of the `plugins` directory of your ***tinyMCE*** installation.

```JS
tinymce.init({
  selector: 'your_editor',
  plugins: '... lists deflist ...',
  ...
});
```

Dependent on the version of ***tinyMCE*** (`tinymce.js / tinymce.min.js`) you
are loading, the corresponding version of the plugin must be available on your
installation.

For details see:  
https://www.tiny.cloud/docs/tinymce/6/editor-important-options/#plugins

## Configuration

### Add the splitbutton to the toolbar

To add the splitbutton to the toolbar, the 'deflist' keyword can be placed at any 
position within the toolbar definition.

```JS
tinymce.init({
  selector: 'your_editor',
  external_plugins: {
    'deflist': 'http://www.yourdomain.com/yourplugins/placeholder/plugin.min.js',
  }
  toolbar: 'btn1 btn2 ... btnN | deflist',
  ...
});
```

### Activate the items in the contextmenu

To activate the items in the contextmenu (if the cursor is within a definitionlist) the
'deflist' keyword can be placed at any position within the contextmenu definition.

```JS
tinymce.init({
  selector: 'your_editor',
  external_plugins: {
    'deflist': 'http://www.yourdomain.com/yourplugins/placeholder/plugin.min.js',
  }
  contextmenu:    'item1 item2 ... itemN | deflist',
  ...
});
```

### Defining custom icons to use in the toolbar

| Option               | Type   | Description                                       | Default |
|----------------------|--------|---------------------------------------------------|---------|
| `deflist_icon`       | string | Icon for the toolbar button                       | *empty* |
| `deflist_title_icon` | string | Icon for the item to format as title              | *empty* |
| `deflist_descr_icon` | string | Icon for the item to format as description        | *empty* |
| `deflist_iconsize`   | number | Iconsize in pixel, if the internal icons are used | 24      |

The icon values can specify either an  
1. direct **SVG** definition 
   - this **MUST** start with the `<svg>` tag
   - the `<svg>` tag **MUST** contain the `height` and `width` attributes (in pixel)
   - the `xmlns` - attribute can be omitted since it is an inline **SVG**  
    (if set, it MUST contain the value `"http://www.w3.org/2000/svg"`)
2. icon name that corresponds to an icon
   - in the icon pack  
     see: https://www.tiny.cloud/docs/tinymce/6/editor-icon-identifiers
   - in a custom icon pack  
     see: https://www.tiny.cloud/docs/tinymce/6/creating-an-icon-pack
   - or added using the `addIcon` API  
     see: https://www.tiny.cloud/docs/tinymce/6/apis/tinymce.editor.ui.registry/#addIcon

If no value for an icon is specified in the options, the plugin checks, if a 
default icon (`deflist`, `deflist_title`, `deflist_descr`) is defined in the current
`editor.ui.registry` (from icon pack, custom icon pack or via `addIcon`).
If there is nothing defined, a default internal icon is used. If the internal icon is
used, the icon size can be changed using the `deflist_iconsize` to adapt the icon to 
a skin and/or theme in use, if necessary.

| Description                                | Registry-Name   | Internal icon |
|--------------------------------------------|-----------------|---------------|
| Icon for the toolbar button                | `deflist`       | <svg height="24" width="24" viewBox="0 0 100 100"><rect fill="rgb(52,52,52)" stroke="none" x="8" y="12" width="60" height="9" rx="4"/><rect fill="rgb(52,52,52)" stroke="none" x="25" y="29" width="64" height="5" rx="2"/><rect fill="rgb(52,52,52)" stroke="none" x="25" y="41" width="64" height="5" rx="2"/><rect fill="rgb(52,52,52)" stroke="none" x="8" y="56" width="60" height="9" rx="4"/><rect fill="rgb(52,52,52)" stroke="none" x="25" y="73" width="64" height="5" rx="2"/><rect fill="rgb(52,52,52)" stroke="none" x="25" y="85" width="64" height="5" rx="2"/></svg> |
| Icon for the item to format as title       | `deflist_title` | <svg height="24" width="24" viewBox="0 0 100 100"><rect fill="rgb(52,52,52)" stroke="none" x="8" y="12" width="60" height="9" rx="4"/><rect fill="rgb(192,192,192)" stroke="none" x="25" y="29" width="64" height="5" rx="2"/><rect fill="rgb(192,192,192)" stroke="none" x="25" y="41" width="64" height="5" rx="2"/><rect fill="rgb(52,52,52)" stroke="none" x="8" y="56" width="60" height="9" rx="4"/><rect fill="rgb(192,192,192)" stroke="none" x="25" y="73" width="64" height="5" rx="2"/><rect fill="rgb(192,192,192)" stroke="none" x="25" y="85" width="64" height="5" rx="2"/></svg> |
| Icon for the item to format as description | `deflist_descr` | <svg height="24" width="24" viewBox="0 0 100 100"><rect fill="rgb(192,192,192)" stroke="none" x="8" y="12" width="60" height="9" rx="4"/><rect fill="rgb(52,52,52)" stroke="none" x="25" y="29" width="64" height="5" rx="2"/><rect fill="rgb(52,52,52)" stroke="none" x="25" y="41" width="64" height="5" rx="2"/><rect fill="rgb(192,192,192)" stroke="none" x="8" y="56" width="60" height="9" rx="4"/><rect fill="rgb(52,52,52)" stroke="none" x="25" y="73" width="64" height="5" rx="2"/><rect fill="rgb(52,52,52)" stroke="none" x="25" y="85" width="64" height="5" rx="2"/></svg> |


```JS
tinymce.init({
  selector: 'your_editor',
  external_plugins: {
    'deflist': 'http://www.yourdomain.com/yourplugins/deflist/plugin.min.js',
  }
  // icon from the core icon pack
  deflist_icon: 'align-justify',	
  // icon 'custom_deflist' must be defined in a custom icon pack
  deflist_title_icon: 'custom_deflist',
  // direct SVG - just a simple darkred circle for demonstration...
  deflist_descr_icon: '<svg height="24" width="24" viewBox="0 0 100 100"><circle fill="rgb(127,0,0)" cx="50" cy="50" r="50" /></svg>',
  ...
});
```

## Localization

Currently only the german translation for the plugin is available. Following steps are
needed to create additional localizations:
1. Copy the file `de.js` in the langs folder, rename it to the language you want
   to add and make your translations.
2. Add the new language in the `plugin.js` at the last line of the plugin
   ```JS
   // add your language at this point, below e.g. fr for french translation
   tinymce.PluginManager.requireLangPack('placeholder', 'de, fr');
   ```
3. Recreate the minified `plugin.min.js` version 

> **Note:**  
> It would be great if you add your created translation file(s) to the repository 
> via pull request to make them available to other users... or just email me any new 
> translation file(s) :-)

### JS minification

[Terser 5](https://github.com/terser/terser)
: A JavaScript mangler/compressor toolkit for ES6+. Needs latest version of 
[node.js](http://nodejs.org/) to be installed to run it from the terminal. The easiest 
way then is to use the bash script 'minify' which is included in the root of this package.

[Minify-JS](https://minify-js.com/)
: Online tool uses 'Terser 5'

[JCompress](https://jscompress.com/)
: Online tool uses 'UglifyJS 3' and 'babel-minify' (doesn't support ES6)
