jQuery( function( $ ) {

	jQuery( '#player-page-select' ).change( function () {

		var teamId = jQuery( this ).find( ':selected' ).val();
		console.log(teamId);

		let loading = true;
		var data = {
			action: 'sports_bench_load_player_list',
			nonce: sbloadplayerlist.nonce,
			team_id: teamId,
		};
		console.log(data);
		$.post( sbloadplayerlist.url, data, function ( res ) {
			console.log(res);
			if ( res.success ) {
				$( '#team-players' ).html( '' );
				$( '#team-players' ).html( res.data );
				loading = false;
			}
		} ).fail( function ( xhr, textStatus, e ) {
			console.log(xhr.responseText);
		} );

	});

});
