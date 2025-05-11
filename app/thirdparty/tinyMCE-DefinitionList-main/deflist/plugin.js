/**
 * Definition List plugin for tinyMCE editor - Version 6
 *
 * The tinyMCE core 'lists' plugin basically contains the entire functionality for 
 * inserting definition lists - although unfortunately neither a toolbar button nor
 * a menu entry is defined for this :-(
 * (i've no idea, why this little step wasn't done inside of the existing plugin...).
 *
 * To toggle the button state correctly, some internal functions are required, which 
 * would make it very complex to implement the desired button via 
 * `tinymce.init('{... setup => ...}')`  
 *
 * For this reason, this additional plugin was created, in which the mentioned internal 
 * helper functions were copied from the above plugin and also the `InsertDefinitionList`
 * command implemented there is called directly.
 *
 * @author S.Kientzler <s.kientzler@online.de>
 * @link https://github.com/Stefanius67/tinyMCE-DefinitionList
 */

tinymce.PluginManager.add('deflist', function(editor, url){
    
    if (!editor.hasPlugin('lists')) {
        console.error('Please use the Lists plugin together with the Definition List plugin.');
    }

    /*--------------------------------------------- 
     * Helpers copied from the core lists plugin
     *-----------------------------+++++++---------*/
    const isNullable = a => a === null || a === undefined;
    const isNonNullable = a => !isNullable(a);
    
    
    class Optional {
      constructor(tag, value) {
        this.tag = tag;
        this.value = value;
      }
      static some(value) {
        return new Optional(true, value);
      }
      static none() {
        return Optional.singletonNone;
      }
      fold(onNone, onSome) {
        if (this.tag) {
          return onSome(this.value);
        } else {
          return onNone();
        }
      }
      isSome() {
        return this.tag;
      }
      isNone() {
        return !this.tag;
      }
      map(mapper) {
        if (this.tag) {
          return Optional.some(mapper(this.value));
        } else {
          return Optional.none();
        }
      }
      bind(binder) {
        if (this.tag) {
          return binder(this.value);
        } else {
          return Optional.none();
        }
      }
      exists(predicate) {
        return this.tag && predicate(this.value);
      }
      forall(predicate) {
        return !this.tag || predicate(this.value);
      }
      filter(predicate) {
        if (!this.tag || predicate(this.value)) {
          return this;
        } else {
          return Optional.none();
        }
      }
      getOr(replacement) {
        return this.tag ? this.value : replacement;
      }
      or(replacement) {
        return this.tag ? this : replacement;
      }
      getOrThunk(thunk) {
        return this.tag ? this.value : thunk();
      }
      orThunk(thunk) {
        return this.tag ? this : thunk();
      }
      getOrDie(message) {
        if (!this.tag) {
          throw new Error(message !== null && message !== void 0 ? message : 'Called getOrDie on None');
        } else {
          return this.value;
        }
      }
      static from(value) {
        return isNonNullable(value) ? Optional.some(value) : Optional.none();
      }
      getOrNull() {
        return this.tag ? this.value : null;
      }
      getOrUndefined() {
        return this.value;
      }
      each(worker) {
        if (this.tag) {
          worker(this.value);
        }
      }
      toArray() {
        return this.tag ? [this.value] : [];
      }
      toString() {
        return this.tag ? `some(${ this.value })` : 'none()';
      }
    }
    Optional.singletonNone = new Optional(false);
   
    const findUntil = (xs, pred, until) => {
      for (let i = 0, len = xs.length; i < len; i++) {
        const x = xs[i];
        if (pred(x, i)) {
          return Optional.some(x);
        } else if (until(x, i)) {
          break;
        }
      }
      return Optional.none();
    };
    const matchNodeNames = regex => node => isNonNullable(node) && regex.test(node.nodeName);
    const isListNode = matchNodeNames(/^(OL|UL|DL)$/);
    const isTableCellNode = matchNodeNames(/^(TH|TD)$/);
    
    const isCustomList = list => /\btox\-/.test(list.className);
    const inList = (parents, listName) => findUntil(parents, isListNode, isTableCellNode).exists(list => list.nodeName === listName && !isCustomList(list));
    const isWithinNonEditable = (editor, element) => element !== null && !editor.dom.isEditable(element);
    const isWithinNonEditableList = (editor, element) => {
      const parentList = editor.dom.getParent(element, 'ol,ul,dl');
      return isWithinNonEditable(editor, parentList);
    };

    const setNodeChangeHandler = (editor, nodeChangeHandler) => {
      const initialNode = editor.selection.getNode();
      nodeChangeHandler({
        parents: editor.dom.getParents(initialNode),
        element: initialNode
      });
      editor.on('NodeChange', nodeChangeHandler);
      return () => editor.off('NodeChange', nodeChangeHandler);
    };

    const setupToggleButtonHandler = (editor, listName) => api => {
        const toggleButtonHandler = e => {
            api.setActive(inList(e.parents, listName));
            api.setEnabled(!isWithinNonEditableList(editor, e.element) && editor.selection.isEditable());
        };
        api.setEnabled(editor.selection.isEditable());
        return setNodeChangeHandler(editor, toggleButtonHandler);
    };
    /*-------------------------------------- 
     * End of helpers from the lists plugin
     *--------------------------------------*/

	editor.options.register('deflist_iconsize', {
		processor: 'number',
		default: 24,
	});

    // our internal button definitions
    const size = editor.options.get('deflist_iconsize');
    const defaultIcon = {
        'deflist':
            '<svg height="' + size + '" width="' + size + '" viewBox="0 0 100 100">' +
            '  <rect x="8" y="12" width="60" height="9" rx="4"/>' +
            '  <rect x="25" y="29" width="64" height="5" rx="2"/>' +
            '  <rect x="25" y="41" width="64" height="5" rx="2"/>' +
            '  <rect x="8" y="56" width="60" height="9" rx="4"/>' +
            '  <rect x="25" y="73" width="64" height="5" rx="2"/>' +
            '  <rect x="25" y="85" width="64" height="5" rx="2"/>' +
            
            '</svg>',
        'deflist_title':
            '<svg height="' + size + '" width="' + size + '" viewBox="0 0 100 100">' +
            '  <rect x="8" y="12" width="60" height="9" rx="4"/>' +
            '  <rect fill="#707070" x="25" y="29" width="64" height="5" rx="2"/>' +
            '  <rect fill="#707070" x="25" y="41" width="64" height="5" rx="2"/>' +
            '  <rect x="8" y="56" width="60" height="9" rx="4"/>' +
            '  <rect fill="#707070" x="25" y="73" width="64" height="5" rx="2"/>' +
            '  <rect fill="#707070" x="25" y="85" width="64" height="5" rx="2"/>' +
            '</svg>',
        'deflist_descr':
            '<svg height="' + size + '" width="' + size + '" viewBox="0 0 100 100">' +
            '  <rect fill="#707070" x="8" y="12" width="60" height="9" rx="4"/>' +
            '  <rect x="25" y="29" width="64" height="5" rx="2"/>' +
            '  <rect x="25" y="41" width="64" height="5" rx="2"/>' +
            '  <rect fill="#707070" x="8" y="56" width="60" height="9" rx="4"/>' +
            '  <rect x="25" y="73" width="64" height="5" rx="2"/>' +
            '  <rect x="25" y="85" width="64" height="5" rx="2"/>' +
            '</svg>',
    };

    // ... that can be overridden in the options with either
    // - an own svg definition (MUST start with '<svg'!))
    // - an icon name that corresponds to an icon
    //   1. in the icon pack  
    //      https://www.tiny.cloud/docs/tinymce/6/editor-icon-identifiers
    //   2. in a custom icon pack
    //      https://www.tiny.cloud/docs/tinymce/6/creating-an-icon-pack
    //   3. or added using the `addIcon` API
    //      https://www.tiny.cloud/docs/tinymce/6/apis/tinymce.editor.ui.registry/#addIcon
	editor.options.register('deflist_icon',       { processor: 'string', default: ''});
	editor.options.register('deflist_title_icon', { processor: 'string', default: ''});
	editor.options.register('deflist_descr_icon', { processor: 'string', default: ''});

    const icons = editor.ui.registry.getAll().icons;
    const getIcon = (name) => {
        const value = editor.options.get(name + '_icon');
        if (value !== '') {
            // value for the icon is set in the options
            if (value.trim().substring(0, 4).toLowerCase() === '<svg') {
                // direct SVG -> add new icon to the registry
                editor.ui.registry.addIcon(name, value);
                return name;
            } else {
                // existing icon from the registry
                return value;
            }
        } else if (name in editor.ui.registry.getAll().icons){
            // no icon specified in the options but default icon is registered
            return name;
        } else {
            // neither a value set in the options nor a default icon registered
            editor.ui.registry.addIcon(name, defaultIcon[name]);
            return name;
        }
    };
    const iconDL = getIcon('deflist');
    const iconDT = getIcon('deflist_title');
    const iconDD = getIcon('deflist_descr');
    
    // Toolbar splitbutton
    editor.ui.registry.addSplitButton('deflist', {
        tooltip: 'Definition-list',
        icon: iconDL,
        fetch: callback => {
            const curnode = editor.selection.getNode();
            // see https://www.tiny.cloud/docs/tinymce/6/custom-split-toolbar-button/#choice-menu-items
            const items = [
                {
                    type: 'choiceitem',
                    value: 'dt',
                    icon: iconDT,
                    text: 'Definition-list title',
                    enabled: editor.selection.getNode().nodeName.toLowerCase() == 'dd',
                }, {
                    type: 'choiceitem',
                    value: 'dd',
                    icon: iconDD,
                    text: 'Definition-list description',
                    enabled: editor.selection.getNode().nodeName.toLowerCase() == 'dt',
                }
            ];
            callback(items);
        },
        onAction: (_) => tinymce.activeEditor.execCommand('InsertDefinitionList', false, {}),
        onItemAction: (api, value) => {
            // console.log('Definition-list splitbutton: ' + value);
            if (value === 'dd') {
                tinymce.activeEditor.execCommand('Indent', false, {});
            } else {
                tinymce.activeEditor.execCommand('Outdent', false, {});
            }
        },
        onSetup: setupToggleButtonHandler(editor, 'DL')
    });
    
    // menuitems to use in the contextmenu
    editor.ui.registry.addMenuItem('deflist_title', {
        icon: iconDT,
        text: 'Definition-list title',
        onAction: () => {
            tinymce.activeEditor.execCommand('Outdent', false, {});            
        }
    });
    editor.ui.registry.addMenuItem('deflist_descr', {
        icon: iconDD,
        text: 'Definition-list description',
        onAction: () => {
            tinymce.activeEditor.execCommand('Indent', false, {});
        }
    });
    editor.ui.registry.addContextMenu('deflist', {
        update: (element) => {
            if (element.nodeName.toLowerCase() == 'dt') {
                return 'deflist_descr';
            }
            if (element.nodeName.toLowerCase() == 'dd') {
                return 'deflist_title';
            }
            return '';
        }
    });               
});

/**
 * at first step only the german translation is available
 */
tinymce.PluginManager.requireLangPack('deflist', 'de');
