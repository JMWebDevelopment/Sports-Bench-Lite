jQuery( document ).ready( function( $ ) {
    $( '#sports-bench-add-item' ).on( 'click', function() {
        var row = $( '.sports-bench-empty-item.screen-reader-text' ).clone( true );
        row.addClass( 'new-row standings-item' );
        row.removeClass( 'sports-bench-empty-item screen-reader-text' );
        row.insertAfter( '.standings-item:last' );
        $( '.new-row .new-field' ).attr( 'disabled',false );
        return false;
    } );

    $( '.sports-bench-remove-item' ).on( 'click', function() {
        $( this ).parent().remove();
        return false;
    } );

    $( '#sports-bench-add-stat' ).on( 'click', function() {
        var row = $( '.sports-bench-empty-stat-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row sports-bench-stat-row' );
        row.removeClass( 'sports-bench-empty-stat-row screen-reader-text' );
        row.insertAfter( '.sports-bench-stat-row:last' );
        $( '.new-row .new-field' ).attr( 'disabled',false );
        return false;
    } );

    $( '.sports-bench-remove-stat' ).on( 'click', function() {
        $( this ).parents( 'tr' ).remove();
        return false;
    } );

    $( '#sports-bench-stats' ).sortable({
        opacity: 0.6,
        revert: true,
        cursor: 'move',
        items: 'tr'
    } );

    function tmce_getContent(editor_id, textarea_id) {
        if ( typeof editor_id == 'undefined' ) editor_id = wpActiveEditor;
        if ( typeof textarea_id == 'undefined' ) textarea_id = editor_id;

        if ( jQuery('#wp-'+editor_id+'-wrap').hasClass('tmce-active') && tinyMCE.get(editor_id) ) {
            return tinyMCE.get(editor_id).getContent();
        }else{
            return jQuery('#'+textarea_id).val();
        }
    }

    var postContent = tmce_getContent();

    if ( $( '#page_template :selected' ).text() == 'Standings' || $( '.editor-page-attributes__template #inspector-select-control-0 :selected' ).text() == 'Standings' || ( postContent !== undefined && postContent.indexOf("[sports-bench-standings]") >= 0 ) ) {
        console.log('should be showing standings');
        $( '#postdivrich' ).hide();
        $( '#sports-bench-stats' ).hide();
        $( '#sports-bench-standings' ).show();
    } else if ( $( '#page_template :selected' ).text() == 'Stats' || $( '.editor-page-attributes__template #inspector-select-control-0 :selected' ).text() == 'Stats' || ( postContent !== undefined && postContent.indexOf("[sports-bench-stats]") >= 0 ) ) {
        $( '#postdivrich' ).hide();
        $( '#sports-bench-stats' ).show();
        $( '#sports-bench-standings' ).hide();
    } else {
        console.log('nothing to show');
        $( '#sports-bench-standings' ).hide();
        $( '#sports-bench-stats' ).hide();
        $( '#postdivrich' ).show();
    }

    $( '#page_template' ).change( function() {
        console.log($( '#page_template :selected' ).text());
        if ( $( '#page_template :selected' ).text() == 'Standings' || $( '.editor-page-attributes__template #inspector-select-control-0 :selected' ).text() == 'Standings' || ( postContent !== undefined && postContent.indexOf("[sports-bench-standings]") >= 0 ) ) {
            $( '#postdivrich' ).hide();
            $( '#sports-bench-stats' ).hide();
            $( '#sports-bench-standings' ).show();
        } else if ( $( '#page_template :selected' ).text() == 'Stats' || $( '.editor-page-attributes__template #inspector-select-control-0 :selected' ).text() == 'Stats' || ( postContent !== undefined && postContent.indexOf("[sports-bench-stats]") >= 0 ) ) {
            $( '#postdivrich' ).hide();
            $( '#sports-bench-stats' ).show();
            $( '#sports-bench-standings' ).hide();
        } else {
            $( '#sports-bench-standings' ).hide();
            $( '#sports-bench-stats' ).hide();
            $( '#postdivrich' ).show();
        }
    } );

    $( '.editor-page-attributes__template #inspector-select-control-0' ).change( function() {
        console.log($( '#page_template :selected' ).text());
        if ( $( '#page_template :selected' ).text() == 'Standings' || $( '.editor-page-attributes__template #inspector-select-control-0 :selected' ).text() == 'Standings' || ( postContent !== undefined && postContent.indexOf("[sports-bench-standings]") >= 0 ) ) {
            $( '#postdivrich' ).hide();
            $( '#sports-bench-stats' ).hide();
            $( '#sports-bench-standings' ).show();
        } else if ( $( '#page_template :selected' ).text() == 'Stats' || $( '.editor-page-attributes__template #inspector-select-control-0 :selected' ).text() == 'Stats' || ( postContent !== undefined && postContent.indexOf("[sports-bench-stats]") >= 0 ) ) {
            $( '#postdivrich' ).hide();
            $( '#sports-bench-stats' ).show();
            $( '#sports-bench-standings' ).hide();
        } else {
            $( '#sports-bench-standings' ).hide();
            $( '#sports-bench-stats' ).hide();
            $( '#postdivrich' ).show();
        }
    } );

    window.setInterval(function(){
        var postContent = tmce_getContent();

        if ( $( '#page_template :selected' ).text() == 'Standings' || $( '.editor-page-attributes__template #inspector-select-control-0 :selected' ).text() == 'Standings' || ( postContent !== undefined && postContent.indexOf("[sports-bench-standings]") >= 0 ) ) {
            $( '#postdivrich' ).hide();
            $( '#sports-bench-stats' ).hide();
            $( '#sports-bench-standings' ).show();
        } else if ( $( '#page_template :selected' ).text() == 'Stats' || $( '.editor-page-attributes__template #inspector-select-control-0 :selected' ).text() == 'Stats' || ( postContent !== undefined && postContent.indexOf("[sports-bench-stats]") >= 0 ) ) {
            $( '#postdivrich' ).hide();
            $( '#sports-bench-stats' ).show();
            $( '#sports-bench-standings' ).hide();
        } else {
            $( '#sports-bench-standings' ).hide();
            $( '#sports-bench-stats' ).hide();
            $( '#postdivrich' ).show();
        }
    }, 5000);

} );
