/*
    feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*
* feinduraSnippets/plugin.js version 0.1
*/

CKEDITOR.plugins.add('feinduraSnippets',
{
    // requires: ['fakeobjects'],
    init: function(editor)
    {
        // vars
        var pluginName = 'feinduraSnippets';


        // -> MENU BUTTON
        editor.ui.addButton('Snippets',
          {
            label: 'feindura ' + feindura_langFile['CKEDITOR_TITLE_PLUGINS']+'/'+feindura_langFile['CKEDITOR_TITLE_SNIPPETS'],
            command: pluginName,
            icon: CKEDITOR.plugins.getPath(pluginName) + 'feinduraSnippetsIcon.png'
        });

        // OPEN on DOUBLE CLICK
        editor.on('doubleclick',function(e){
          var element = e.data.element.getAscendant( 'img', true );
          if(element && element.is( 'img' ) && (element.hasClass('feinduraSnippet') || element.hasClass('feinduraPlugin'))) {
            // editor.getSelection().selectElement(element);
            editor.execCommand(pluginName);
            // :HACK: pretend to open a dialog, cancels other dialogs from opening
            e.data.dialog = '';
          }
        });

        // -> CONTEXT MENU
        if(editor.addMenuItems) {
            editor.addMenuItems(  //have to add menu item first
              {
                Snippet:  //name of the menu item
                {
                    label: feindura_langFile['CKEDITOR_TITLE_PLUGINS']+'/'+feindura_langFile['CKEDITOR_TITLE_SNIPPETS'],
                    command: pluginName,
                    icon: CKEDITOR.plugins.getPath(pluginName) + 'feinduraSnippetsIcon.png',
                    group: 'feinduraSnippetsGroup'  //have to be added in config
                }
              });
        }
        if(editor.contextMenu) {
            editor.contextMenu.addListener(function(element, selection) { //function to be run when context menu is displayed
                  if(element && element.is('img') && (element.hasClass('feinduraSnippet') || element.hasClass('feinduraPlugin')))
                    return { Snippet: CKEDITOR.TRISTATE_OFF };
                  else
                    return false;
              });
        }

        // -> DIALOG
        CKEDITOR.dialog.add(pluginName, function(){

          var dialog = function(editor){
            return {
              title : 'feindura ' + feindura_langFile['CKEDITOR_TITLE_PLUGINS']+'/'+feindura_langFile['CKEDITOR_TITLE_SNIPPETS'],
              minWidth : 100,
              minHeight : '100%',
              onOk: function() {

                // var attributes = {},
                  // removeAttributes = [],
                  // data = {},
                  // me = this,
                var editor = this.getParentEditor();

                elem = editor.document.createElement('img'); //set inital values for the input.supNote element
                // elem.setAttribute('src',feindura_basePath.replace(feindura_websitePath,'')+'library/thirdparty/ckeditor/plugins/feinduraSnippets/snippetFill.gif');
                elem.setAttribute('src','noImage.png');
                elem.setAttribute('draggable','true');
                editor.insertElement(elem);
                this.snippet = elem;

                this.commitContent(this.snippet);
              },
              onLoad : function() {
                theDialog = this;

                // Act on tab switching
                theDialog.on('selectPage', function(e) {
                  theDialog.tabs = e.data.page;
                });
              },
              onShow: function() {
                this.tabs = 'plugins';
                this.snippet = false;
                var editor = this.getParentEditor(),
                    sel = editor.getSelection();
                this.snippet = sel.getSelectedElement();

                // hide editSnippet button, when not admin or edit in website settings in deactivated
                if(!feindura_snippets_isAdmin && !feindura_snippets_editInWebsiteSettings)
                  this.getContentElement( 'snippets', 'editSnippet' ).getElement().setStyle('display','none');

                // hide tabs when no data is available (1 == ['-',''])
                if(!feinduraPluginsActive || feindura_plugins.length === 1) {
                  this.hidePage('plugins');
                  this.selectPage('snippets');
                }
                if(!feinduraSnippetsActive || feindura_snippets.length === 1) {
                  this.hidePage('snippets');
                  this.selectPage('plugins');
                }

                // pre open the right tab on startup
                if(this.snippet && this.snippet.hasClass('feinduraPlugin')) {
                  this.selectPage('plugins');
                } else if(this.snippet && this.snippet.hasClass('feinduraSnippet')) {
                  this.selectPage('snippets');
                }

                // make the width/height inputs smaller
                // this.getContentElement('plugins','feinduraPluginWidth').getElement().setStyle('width','60px');
                // this.getContentElement('plugins','feinduraPluginHeight').getElement().setStyle('width','60px');

                // update the selections
                if(this.snippet && (this.snippet.hasClass('feinduraPlugin') || this.snippet.hasClass('feinduraSnippet')))
                  this.setupContent(this.snippet);
              },
              resizable : CKEDITOR.DIALOG_RESIZE_NONE,
              contents: [{
                id : 'plugins',
                label : feindura_langFile['CKEDITOR_TITLE_PLUGINS'],
                title : feindura_langFile['CKEDITOR_TITLE_PLUGINS'],
                elements :[{
                  id : 'pluginsList',
                  type : 'select',
                  label : feindura_langFile['CKEDITOR_TEXT_PLUGINS'],
                  'default' : '',
                  items: feindura_plugins,
                  setup: function(element){
                    var select = this;
                    // update the plugins selection
                    select.clear();
                    feindura_plugins.each(function(feindura_plugin){
                      select.add(feindura_plugin[0],feindura_plugin[1]);
                    });
                    // select the current value
                    if(element !== null && element.hasClass('feinduraPlugin') && this.getDialog().tabs == 'plugins')
                      this.setValue(element.getAttribute('title'));
                  },
                  commit: function(element) {
                    if(this.getDialog().tabs == 'plugins') {
                      // remove element if "-" is selected
                      if(this.getValue() === '') {
                        element.remove();
                      // otherwise add data to element
                      } else {
                        var select = this;
                        element.addClass('feinduraPlugin');

                        // get the plugin name
                        var pluginName;
                        feindura_plugins.each(function(plugin){
                          if(plugin.contains(select.getValue())){
                            pluginName = plugin[0];
                          }
                        });

                        element.setAttribute('title',select.getValue()); // is used as the data storage
                        element.setAttribute('alt',pluginName); // is used to show the plugin name
                      }
                    }
                  }
                },
                {
                  id : 'editPlugin',
                  type : 'button',
                  label : feindura_langFile['CKEDITOR_BUTTON_EDITPLUGIN'],
                  onClick : function() {
                    // vars
                    var select              = this.getDialog().getContentElement('plugins','pluginsList');
                    var currentPluginRaw    = select.getValue();
                    var currentPlugin       = currentPluginRaw.substr(0,currentPluginRaw.indexOf('#'));
                    var currentPluginNumber = currentPluginRaw.substr(currentPluginRaw.indexOf('#')+1);

                    // get the plugin name
                    var pluginName;
                    feindura_plugins.each(function(plugin){
                      if(plugin.contains(select.getValue())){
                        pluginName = plugin[0];
                      }
                    });

                    openWindowBox('library/views/windowBox/editPlugins.php?page='+currentPage+'&category='+currentCategory+'&plugin='+currentPlugin+'&number='+currentPluginNumber,pluginName);
                  }
                }
                // {
                //   type: 'hbox',
                //   widths : [ '25%', '75%' ],
                //   children: [{
                //     type : 'text',
                //     id : 'feinduraPluginWidth',
                //     label : editor.lang[editor.config.language].common.width,
                //     size: 40,
                //     'default' : '100',
                //     setup: function(element){
                //         if(element !== null && element.hasClass('feinduraPlugin') && this.getDialog().tabs == 'plugins')
                //           this.setValue(element.getStyle('width').match(/[0-9]*/g)[0]);
                //       },
                //     commit: function(element) {
                //       if(this.getDialog().tabs == 'plugins') {
                //         element.setStyle('width',this.getValue()+this.getDialog().getContentElement('plugins','feinduraPluginWidthMeasure').getValue());
                //       }
                //     }
                //   },
                //   {
                //     type : 'select',
                //     id : 'feinduraPluginWidthMeasure',
                //     label: '&nbsp;',
                //     width: 3,
                //     'default' : '%',
                //     items: [['%','%'],['Pixel','px']],
                //     setup: function(element){
                //         if(element !== null && element.hasClass('feinduraPlugin') && this.getDialog().tabs == 'plugins')
                //           this.setValue(element.getStyle('width').replace(/[0-9]*/g,''));
                //       }
                //   }]
                // },
                // {
                //   type: 'hbox',
                //   widths : [ '25%', '75%' ],
                //   children: [{
                //     type : 'text',
                //     id : 'feinduraPluginHeight',
                //     label : editor.lang[editor.config.language].common.height,
                //     size: 40,
                //     'default' : '',
                //     setup: function(element){
                //         if(element !== null && element.hasClass('feinduraPlugin') && this.getDialog().tabs == 'plugins')
                //           this.setValue(element.getStyle('height').match(/[0-9]*/g)[0]);
                //       },
                //     commit: function(element) {
                //       if(this.getDialog().tabs == 'plugins') {
                //         element.setStyle('height',this.getValue()+this.getDialog().getContentElement('plugins','feinduraPluginHeightMeasure').getValue());
                //       }
                //     }
                //   },
                //   {
                //     type : 'select',
                //     id : 'feinduraPluginHeightMeasure',
                //     label: '&nbsp;',
                //     width: 3,
                //     'default' : '%',
                //     items: [['%','%'],['Pixel','px']],
                //     setup: function(element){
                //         if(element !== null && element.hasClass('feinduraPlugin') && this.getDialog().tabs == 'plugins')
                //           this.setValue(element.getStyle('height').replace(/[0-9]*/g,''));
                //       }
                //   }]
                // }
                ]
              },
              {
                id : 'snippets',
                label : feindura_langFile['CKEDITOR_TITLE_SNIPPETS'],
                title : feindura_langFile['CKEDITOR_TITLE_SNIPPETS'],
                elements :[{
                  id : 'snippetsList',
                  type : 'select',
                  label : feindura_langFile['CKEDITOR_TEXT_SNIPPETS'],
                  'default' : '',
                  items: feindura_snippets,
                  setup: function(element){
                    if(element !== null && element.hasClass('feinduraSnippet') && this.getDialog().tabs == 'snippets')
                      this.setValue(element.getAttribute('title'));
                  },
                  commit: function(element){
                    if(this.getDialog().tabs == 'snippets') {
                      // remove element if "-" is selected
                      if(this.getValue() === '') {
                        element.remove();
                      // otherwise add data to element
                      } else {
                        element.addClass('feinduraSnippet');
                        element.setAttribute('title',this.getValue()); // is used as the data storage
                        element.setAttribute('alt',this.getValue()); // is used to show the snippet path
                      }
                    }
                  }
                },
                {
                  id : 'editSnippet',
                  type : 'button',
                  label : feindura_langFile['CKEDITOR_BUTTON_EDITSNIPPET'],
                  onClick : function() {
                    var href = (feindura_snippets_editInWebsiteSettings) ? '?site=websiteSetup&status=snippetFiles&file=/'+ this.getDialog().getContentElement( 'snippets', 'snippetsList' ).getValue() +'#snippetsFilesAnchor'
                      : '?site=adminSetup&status=snippetFiles&file=/'+ this.getDialog().getContentElement( 'snippets', 'snippetsList' ).getValue() +'#snippetsFilesAnchor';

                    // warn when pagecontent was changed
                    if(pageContentChanged || this.getDialog().getParentEditor().checkDirty()) {
                      pageContentChangedSign();
                      openWindowBox('library/views/windowBox/unsavedPage.php?target=' + escape(href),false);

                    } else
                      window.location.href = href;
                  }
                }]
              }]
            };
          };

          return dialog(CKEDITOR);

        }); //this.path + 'dialogs/feinduraSnippets.js');

        editor.addCommand(pluginName, new CKEDITOR.dialogCommand(pluginName));

    }
    // afterInit: function(editor) {
    //    function createFakeElement(realElement) {
    //     console.log(realElement);
    //       var fakeElement = editor.createFakeParserElement(realElement, '', 'img', true);
    //          // fakeStyle = fakeElement.attributes.style || '';
    //       // fakeStyle = fakeElement.attributes.style = fakeStyle + 'width:10px;';
    //       // fakeStyle = fakeElement.attributes.style = fakeStyle + 'height:10px;';
    //       return fakeElement;
    //    }

    //    var dataProcessor = editor.dataProcessor;
    //    var dataFilter = dataProcessor && dataProcessor.dataFilter;
    //    if (dataFilter) {
    //       dataFilter.addRules({
    //          elements: {
    //             'img': function(element) { return createFakeElement(element); }
    //          }
    //       }, 2); // Low priority, it's not really necessary as nothing should touch the script before you
    //    }
    // }
});