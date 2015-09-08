// Word Rotate
(function( $ ) {

    'use strict';

    if ( $.isFunction($.fn[ 'themePluginWordRotate' ]) ) {

        $(function() {
            $('[data-plugin-word-rotate], .word-rotate:not(.manual)').each(function() {
                var $this = $( this ),
                    opts = {};

                var pluginOptions = $this.data('plugin-options');
                if (pluginOptions)
                    opts = pluginOptions;

                $this.themePluginWordRotate(opts);
            });
        });

    }

}).apply(this, [ jQuery ]);