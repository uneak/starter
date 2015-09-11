
function expandWidget( content ) {
    content.children( '.widget-content' ).slideDown( 'fast', function() {
        $(this).css( 'display', '' );
        content.removeClass( 'widget-collapsed' );
    });
}

function collapseWidget( content ) {
    content.children('.widget-content' ).slideUp( 'fast', function() {
        content.addClass( 'widget-collapsed' );
        $(this).css( 'display', '' );
    });
}
