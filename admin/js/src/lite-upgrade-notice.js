jQuery( document ).ready( function() {

	jQuery( document ).on( 'click', '.sports-bench-lite-upgrade-notice', function() {
		console.log('close notice');
		const data = {
			action: 'sports_bench_lite_dismiss_upgrade_notice',
		};

		jQuery.post( sbliteupgrade.url, data, function( res ) {
			console.log(res);
		} );
	} );
} );
