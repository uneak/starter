// iosSwitcher ???
(function( $ ) {

    'use strict';

    if ( $.isFunction( $.fn.confirmation ) ) {

        $.extend( $.fn.confirmation.Constructor.DEFAULTS, {
            btnOkIcon 		: 'fa fa-check',
            btnCancelIcon 	: 'fa fa-times'
        });

    }

}).apply(this, [ jQuery ]);