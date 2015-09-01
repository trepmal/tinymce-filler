(function() {

    // Register plugin
    tinymce.PluginManager.add( mcePhrases.pluginName /* corresponds to plugin name registered in mce_external_plugins */, function( editor, url ) {

        editor.addButton( mcePhrases.buttonName /* corresponds to button name registered in mce_buttons */, {
            type: 'listbox',
            text: mcePhrases.buttonName,
            icon: false,
            onselect: function(e) {
                editor.insertContent(this.value());
            },
            values: mcePhrases.fillers,
            onPostRender: function() {
                // default selection
                this.text( mcePhrases.default );
            }
        });
    });

})();