jQuery(document).ready(function( $ ) {
	$( '.import-table-section-header' ).on( 'click', function() {
		if ( $( this ).parent( 'div' ).hasClass( 'opened' ) ) {
				$( this ).parent( 'div' ).find( '.import-table-section-body' ).slideUp( 300, 'linear' );
			$( this ).parent( 'div' ).removeClass( 'opened' );
		} else {
			$( this ).parent( 'div' ).find( '.import-table-section-body' ).slideDown( 300, 'linear' );
			$( this ).parent( 'div' ).addClass( 'opened' );
		}
	});

	$('.import-form').submit( function() {
		console.log('submitted');
		var file = $(this).find('#sports_bench_csv_upload');
		if( ! file || isCSV( file.val() ) === false ) {
			alert( sbimportcsv.must_be_csv );
			return false;
		}
		return true;
	});
});
function getExtension(filename) {
	var parts = filename.split('.');
	return parts[parts.length - 1];
}

function isCSV( file ) {
	var ext = getExtension( file );
	if  ( ext.toLowerCase() === 'csv' ) {
		return true;
	}

	return false;
}
