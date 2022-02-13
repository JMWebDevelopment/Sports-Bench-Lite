jQuery( function( $ ) {

    $( '#sports-bench-stat-search-form' ).submit( function(e) {
		e.preventDefault();
        if ( $( '.sports-bench-search-results' ).length > 0 ) {
            var offset = $( '.sports-bench-search-results tr' ).length;
        } else {
            var offset = 0;
        }
        var mainDiv = $( '#sports-bench-results' );
        var player_first_name = $( '#sports-bench-player-first-name' ).val();
        var player_last_name = $( '#sports-bench-player-last-name' ).val();
        var stat_type = $( '#sports-bench-stat-type' ).val();
        var comparison = $( '#sports-bench-stat-direction' ).val();
        var stat = $( '#sports-bench-stat' ).val();
        var stat_total = $( '#sports-bench-stat-total' ).val();
        var team = $( '#sports-bench-team' ).val();
        var season = $( '#sports-bench-season' ).val();

        if ( '' === stat ) {
            alert('Please select a stat to search.');
            return;
        }

        let loading = true;
        var data = {
            action: 'sports_bench_search_stats',
            nonce: sbsearchstats.nonce,
            player_first_name: player_first_name,
            player_last_name: player_last_name,
            stat: stat,
            stat_type: stat_type,
            stat_total: stat_total,
            compare: comparison,
            offset: offset,
            team: team,
            season: season,
        };
        console.log(data);
        $.post( sbsearchstats.url, data, function ( res ) {
            console.log(res);
            if ( res.success ) {
                if ( offset > 0 ) {
                    $('.sports-bench-search-results').append(res.data);
                    var count = $( '.sports-bench-search-results tr' ).length;
                    if ( 0 !== ( count % 10 ) ) {
                        console.log( 'no more ' + count );
                        $('#sports-bench-search-results-load').remove();
                    }
                } else {
                    $('.sports-bench-search-results').remove();
                    $('#sports-bench-search-results-load').remove();
                    mainDiv.append(res.data);
                }
                loading = false;
            }
        } ).fail( function ( xhr, textStatus, e ) {
            // console.log(xhr.responseText);
        } );
		return false;

    } );
    $( '#sports-bench-stat-clear' ).on( 'click', function() {
        $( '#sports-bench-player-first-name' ).val( '' );
        $( '#sports-bench-player-last-name' ).val( '' );
        $( '#sports-bench-stat-type' ).val( '' );
        $( '#sports-bench-stat-direction' ).val( '' );
        $( '#sports-bench-stat' ).val( '' );
        $( '#sports-bench-stat-total' ).val( '' );
		$( '#sports-bench-team' ).val( '' );
        $( '#sports-bench-season' ).val( '' );
        $( '.sports-bench-search-results' ).remove();
        $( '#sports-bench-search-results-load' ).remove();
    } );

    $( document ).on( 'click', '#sports-bench-search-results-load', function() {
        if ( $( '.sports-bench-search-results' ).length > 0 ) {
            var offset = $( '.sports-bench-search-results tr' ).length;
        } else {
            var offset = 0;
        }
        var mainDiv = $( '#sports-bench-results' );
        var player_first_name = $( '#sports-bench-player-first-name' ).val();
        var player_last_name = $( '#sports-bench-player-last-name' ).val();
        var stat_type = $( '#sports-bench-stat-type' ).val();
        var comparison = $( '#sports-bench-stat-direction' ).val();
        var stat = $( '#sports-bench-stat' ).val();
        var stat_total = $( '#sports-bench-stat-total' ).val();
		var team = $( '#sports-bench-team' ).val();
        var season = $( '#sports-bench-season' ).val();

        if ( '' === stat ) {
            alert('Please select a stat to search.');
            return;
        }

        let loading = true;
        var data = {
            action: 'sports_bench_search_stats',
            nonce: sbsearchstats.nonce,
            player_first_name: player_first_name,
            player_last_name: player_last_name,
            stat: stat,
            stat_type: stat_type,
            stat_total: stat_total,
            compare: comparison,
            offset: offset,
			team: team,
            season: season,
        };
        console.log(data);
        $.post( sbsearchstats.url, data, function ( res ) {
            console.log(res);
            if ( res.success ) {
                if ( offset > 0 ) {
                    $('.sports-bench-search-results tbody').append(res.data);
                    var count = $( '.sports-bench-search-results tr' ).length;
                    console.log( count % 10 );
                    if ( 0 !== ( count % 10 ) ) {
                        console.log( 'no more ' + count );
                        $('#sports-bench-search-results-load').remove();
                    }
                } else {
                    $('.sports-bench-search-results').remove();
                    $('#sports-bench-search-results-load').remove();
                    mainDiv.append(res.data);
                }
                loading = false;
            }
        } ).fail( function ( xhr, textStatus, e ) {
            // console.log(xhr.responseText);
        } );
    } );
});
