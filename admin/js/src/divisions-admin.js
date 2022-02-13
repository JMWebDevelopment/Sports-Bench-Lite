jQuery( document ).ready( function() {
	jQuery( '.cpa-color-picker' ).wpColorPicker();
	if ( jQuery( '#division-conference' ).find( ':selected' ).val() === 'Division' ) {
		jQuery( '#division-color-section' ).hide();
	} else {
		jQuery( '#division-conference-section' ).hide();
		jQuery( '#division-conference-id' ).attr( 'disabled', true );
	}

	jQuery( '#division-conference' ).change( function() {
		console.log( 'changed type' );
		if ( jQuery( '#division-conference' ).find( ':selected' ).val() === 'Division' ) {
			jQuery( '#division-color-section' ).hide();
			jQuery( '#division-conference-section' ).show();
			jQuery( '#division-conference-id' ).attr( 'disabled', false );
		} else {
			jQuery( '#division-conference-section' ).hide();
			jQuery( '#division-conference-id' ).attr( 'disabled', true );
			jQuery( '#division-color-section' ).show();
		}
	} );
} );
