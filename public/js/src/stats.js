jQuery( function( $ ) {
    $( '.stat-button' ).each(function() {

        $( this ).on( 'click', function() {
            var mainDiv = $( this ).parent( 'div' );
            var table = mainDiv.find( '.stat-table' );
            var tableLength = table.find( 'tbody > tr' ).length;
            var stat = table.attr( 'id' );

            let loading = true;
            var data = {
                action: 'sports_bench_load_stats',
                nonce: sbloadstats.nonce,
                stat: stat,
                offset: tableLength
            };
            $.post( sbloadstats.url, data, function ( res ) {
                if ( res.success ) {
                    table.find('tbody').append( res.data );
                    loading = false;
                }
            } ).fail( function ( xhr, textStatus, e ) {
                // console.log(xhr.responseText);
            } );

        } );

    } );
});
