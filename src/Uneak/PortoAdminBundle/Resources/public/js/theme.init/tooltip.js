// Tooltip
(function( $ ) {

    'use strict';

    if ( $.isFunction( $.fn['tooltip'] ) ) {
        $( '[data-toggle=tooltip],[rel=tooltip]' ).tooltip({ container: 'body' });
    }

}).apply( this, [ jQuery ]);

// Scroll to Top
(function(theme, $) {
    // Scroll to Top Button.
    if (typeof theme.PluginScrollToTop !== 'undefined') {
        theme.PluginScrollToTop.initialize();
    }
}).apply(this, [ window.theme, jQuery ]);