jQuery( function( $ ) {

	let getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
		}
		return false;
	};

	let eventIds = [];

	const game_id = getUrlParameter( 'game_id' );

	window.setInterval( getGameEvents, 60000 );

	$( '.game-events .event-id' ).each( function () {
		let eventID = $( this ).text();
		eventIds.push( eventID );
	} );

	function getGameEvents() {
		console.log('getting game events');
		$.post( {
			url: sbboxscore.url,
			data: {
				nonce: sbboxscore.nonce,
				action: 'sports_bench_box_score_ajax',
				game_id: game_id,
				event_ids: eventIds,
			},
			success: function ( response ) {
				eventIds = response.data[1];
				if ( response.data[0].length > 0 ) {
					$(response.data[0]).insertBefore( '.game-events tbody tr:first' ).fadeIn('fast');
				}
			},
			fail: function ( response ) {
				console.log( response );
			}
		});
	}

} );
