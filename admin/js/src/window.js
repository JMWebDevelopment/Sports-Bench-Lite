function init() {
    tinyMCEPopup.resizeToInnerSize();
}

jQuery (document ).ready( function() {
    jQuery( '#game' ).hide();
    jQuery( '.games' ).hide();
    jQuery( '#player' ).hide();
    jQuery( '#team' ).hide();
    jQuery( '#division' ).hide();
    jQuery( '#bracket' ).hide();
    jQuery( '#game-recap' ).hide();
    jQuery( '#rivalry' ).hide();

    jQuery( '#shortcode' ).on( 'change', function () {
        var value = jQuery( '#shortcode' ).find( ':selected' ).val();

        if ( value == 'game' ) {
            jQuery( '#game' ).show();
            jQuery( '#player' ).hide();
            jQuery( '#team' ).hide();
            jQuery( '#division' ).hide();
            jQuery( '#bracket' ).hide();
            jQuery( '#game-recap' ).hide();
            jQuery( '#rivalry' ).hide();
        } else if ( value == 'player' ) {
            jQuery( '#game' ).hide();
            jQuery( '#player' ).show();
            jQuery( '#team' ).hide();
            jQuery( '#division' ).hide();
            jQuery( '#bracket' ).hide();
            jQuery( '#game-recap' ).hide();
            jQuery( '#rivalry' ).hide();
        } else if ( value == 'team' ) {
            jQuery( '#game' ).hide();
            jQuery( '#player' ).hide();
            jQuery( '#team' ).show();
            jQuery( '#division' ).hide();
            jQuery( '#bracket' ).hide();
            jQuery( '#game-recap' ).hide();
            jQuery( '#rivalry' ).hide();
        } else if ( value == 'division' ) {
            jQuery( '#game' ).hide();
            jQuery( '#player' ).hide();
            jQuery( '#team' ).hide();
            jQuery( '#division' ).show();
            jQuery( '#bracket' ).hide();
            jQuery( '#game-recap' ).hide();
            jQuery( '#rivalry' ).hide();
        } else if ( value == 'bracket' ) {
            jQuery( '#game' ).hide();
            jQuery( '#player' ).hide();
            jQuery( '#team' ).hide();
            jQuery( '#division' ).hide();
            jQuery( '#bracket' ).show();
            jQuery( '#game-recap' ).hide();
            jQuery( '#rivalry' ).hide();
        } else if ( value == 'rivalry' ) {
            jQuery( '#game' ).hide();
            jQuery( '#player' ).hide();
            jQuery( '#team' ).hide();
            jQuery( '#division' ).hide();
            jQuery( '#bracket' ).hide();
            jQuery( '#game-recap' ).hide();
            jQuery( '#rivalry' ).show();
        } else if ( value == 'game-recap' || value == 'game-recap-sidebar' ) {
            jQuery( '#game' ).hide();
            jQuery( '#player' ).hide();
            jQuery( '#team' ).hide();
            jQuery( '#division' ).hide();
            jQuery( '#bracket' ).hide();
            jQuery( '#game-recap' ).show();
            jQuery( '#rivalry' ).hide();
        } else {
            jQuery( '#game' ).hide();
            jQuery( '#player' ).hide();
            jQuery( '#team' ).hide();
            jQuery( '#division' ).hide();
            jQuery( '#bracket' ).hide();
            jQuery( '#game-recap' ).hide();
            jQuery( '#rivalry' ).hide();
        }
    } );

    var current = '';

    jQuery( '#shortcode-season' ).on( 'change', function () {
        var value = jQuery( '#shortcode-season' ).find( ':selected' ).val();

        jQuery( current ).attr( 'disabled',false );
        jQuery( current ).hide();
        var season = '#shortcode-game-' + value;
        jQuery( season ).show();
        jQuery( season ).attr( 'disabled',false );
        current = season;
    });
    jQuery( '#shortcode-recap-season' ).on( 'change', function () {
        var value = jQuery( '#shortcode-recap-season' ).find( ':selected' ).val();

        jQuery( current ).attr( 'disabled',false );
        jQuery( current ).hide();
        var season = '#shortcode-game-recap-' + value;
        jQuery( season ).show();
        jQuery( season ).attr( 'disabled',false );
        current = season;
    });
});

function insertsportsbenchshortcode() {
    var tagtext;
    var shortcode = jQuery( '#shortcode' ).val();
    if ( shortcode == 'game' ) {
        var season = jQuery( '#shortcode-season' ).find( ':selected' ).val();
        var game_id = jQuery( '#shortcode-game-' + season ).val();
        console.log(game_id);
        tagtext = "[sports-bench-game game_id=" + game_id + "]";
    } else if ( shortcode == 'player' ) {
        var player_id = jQuery( '#shortcode-player' ).val();
        tagtext = "[sports-bench-player player_id=" + player_id + "]";
    } else if ( shortcode == 'team' ) {
        var team_id = jQuery( '#shortcode-team' ).val();
        tagtext = "[sports-bench-team team_id=" + team_id + "]";
    } else if ( shortcode == 'division' ) {
        var division_id = jQuery( '#shortcode-division' ).val();
        tagtext = "[sports-bench-list-division division_id=" + division_id + "]";
    } else if ( shortcode == 'scoreboard' ) {
        tagtext = "[sports-bench-scoreboard]";
    } else if ( shortcode == 'standings' ) {
        jQuery( '#sports-bench-standings' ).show();
        tagtext = "[sports-bench-standings]";
    } else if ( shortcode == 'stats' ) {
        jQuery( '#sports-bench-stats' ).show();
        tagtext = "[sports-bench-stats]";
    } else if ( shortcode == 'bracket' ) {
        var bracket_id = jQuery( '#shortcode-bracket' ).val();
        tagtext = "[sports-bench-bracket bracket_id=" + bracket_id + "]";
    } else if ( shortcode == 'rivalry' ) {
        var team_one_id = jQuery( '#shortcode-rivalry-team-one' ).val();
        var team_two_id = jQuery( '#shortcode-rivalry-team-two' ).val();
        var recent_games = jQuery( '#shortcode-rivalry-recent-games' ).val();
        tagtext = "[sports-bench-rivalry team_one_id=" + team_one_id + " team_two_id=" + team_two_id + " recent_games=" + recent_games + "]";
    } else if ( shortcode == 'game-recap' ) {
        var season = jQuery( '#shortcode-recap-season' ).find( ':selected' ).val();
        var game_id = jQuery( '#shortcode-game-recap-' + season ).val();
        //var game_id = jQuery( '[name="shortcode-game-recap"]' ).val();
        tagtext = "[sports-bench-game-recap game_id=" + game_id + "]";
    } else if ( shortcode == 'game-recap-sidebar' ) {
        var season = jQuery( '#shortcode-recap-season' ).find( ':selected' ).val();
        var game_id = jQuery( '#shortcode-game-recap-' + season ).val();
        tagtext = "[sports-bench-game-recap-sidebar game_id=" + game_id + "]";
    } else if ( shortcode == 'player-page' ) {
        tagtext = "[sports-bench-player-page]";
    } else if ( shortcode == 'team-page' ) {
        tagtext = "[sports-bench-team-page]";
    } else if ( shortcode == 'stat-search' ) {
        tagtext = "[sports-bench-stat-search]";
    } else if ( shortcode == 'box-score' ) {
        tagtext = "[sports-bench-box-score]";
    } else {
        tagtext = "";
    }

    if ( window.tinyMCE ) {
        window.tinyMCE.execCommand( 'mceInsertContent', false, tagtext );
        //Peforms a clean up of the current editor HTML.
        //tinyMCEPopup.editor.execCommand('mceCleanup');
        //Repaints the editor. Sometimes the browser has graphic glitches.
        tinyMCEPopup.editor.execCommand( 'mceRepaint' );
        tinyMCEPopup.close();
    }

    return;
}
