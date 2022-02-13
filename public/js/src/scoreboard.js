jQuery( function( $ ) {
	$( '#scoreboard-page-left' ).click( function() {
		let weekdate = $( '#scoreboard-title .scoreboard-page-title' ).text();
		let current;
		if ( weekdate.includes( 'Week' ) ) {
			const week = weekdate;
			weekdate = 'week';
			current = week.replace( 'Week ', '' );
		} else {
			weekdate = 'date';
			current = $( '#hidden-date' ).text();
		}
		const direction = 'left';

		let loading = true;
		const data = {
			action: 'sports_bench_load_games',
			nonce: sbloadgames.nonce,
			weekdate: weekdate,
			current: current,
			direction: direction,
		};
		$.post( sbscoreboard.url, data, function( res ) {
			if ( res.success ) {
				const html = '<span id="hidden-date">' + res.data[ 2 ] + '</span>';
				$( '#scoreboard-title .scoreboard-page-title' ).html( res.data[ 1 ] + html );
				$( '#scoreboard-page-body' ).html();
				$( '#scoreboard-page-body' ).html( res.data[ 0 ] );
				loading = false;
			}
		} );
	} );

	$( '#scoreboard-page-right' ).click( function() {
		let weekdate = $( '#scoreboard-title .scoreboard-page-title' ).text();
		let current;
		if ( weekdate.includes( 'Week' ) ) {
			const week = weekdate;
			weekdate = 'week';
			current = week.replace( 'Week ', '' );
		} else {
			weekdate = 'date';
			current = $( '#hidden-date' ).text();
		}
		const direction = 'right';

		let loading = true;
		const data = {
			action: 'sports_bench_load_games',
			nonce: sbloadgames.nonce,
			weekdate: weekdate,
			current: current,
			direction: direction
		};
		$.post( sbscoreboard.url, data, function( res ) {
			if ( res.success ) {
				const html = '<span id="hidden-date">' + res.data[ 2 ] + '</span>';
				$( '#scoreboard-title .scoreboard-page-title' ).html( res.data[ 1 ] + html );
				$( '#scoreboard-page-body' ).html();
				$( '#scoreboard-page-body' ).html( res.data[ 0 ] );
				loading = false;
			}
		} );
	} );

	$( '#scoreboard-widget-left' ).click( function() {
		let weekdate = $( '#scoreboard-title .scoreboard-widget-title' ).text();
		let current;
		if ( weekdate.includes( 'Week' ) ) {
			const week = weekdate;
			weekdate = 'week';
			current = week.replace( 'Week ', '' );
		} else {
			weekdate = 'date';
			current = $( '#widget-hidden-date' ).text();
		}
		const direction = 'left';

		let loading = true;
		const data = {
			action: 'sports_bench_widget_load_games',
			nonce: sbloadgames.nonce,
			weekdate: weekdate,
			current: current,
			direction: direction
		};
		$.post( sbloadgames.url, data, function ( res ) {
			if ( res.success ) {
				const html = '<span id="widget-hidden-date">' + res.data[ 2 ] + '</span>';
				$( '#scoreboard-title .scoreboard-widget-title' ).html( res.data[ 1 ] + html );
				$( '#scoreboard-widget-body' ).html();
				$( '#scoreboard-widget-body' ).html( res.data[ 0 ] );
				loading = false;
			}
		} );
	} );

	$( '#scoreboard-widget-right' ).click( function() {
		let weekdate = $( '#scoreboard-title .scoreboard-widget-title' ).text();
		let current;
		if ( weekdate.includes( 'Week' ) ) {
			const week = weekdate;
			weekdate = 'week';
			current = week.replace( 'Week ', '' );
		} else {
			weekdate = 'date';
			current = $( '#widget-hidden-date' ).text();
		}
		const direction = 'right';

		let loading = true;
		const data = {
			action: 'sports_bench_widget_load_games',
			nonce: sbloadgames.nonce,
			weekdate: weekdate,
			current: current,
			direction: direction
		};
		$.post( sbloadgames.url, data, function( res ) {
			if ( res.success ) {
				const html = '<span id="widget-hidden-date">' + res.data[ 2 ] + '</span>';
				$( '#scoreboard-title .scoreboard-widget-title' ).html( res.data[ 1 ] + html );
				$( '#scoreboard-widget-body' ).html();
				$( '#scoreboard-widget-body' ).html( res.data[ 0 ] );
				loading = false;
			}
		} );
	} );
} );
