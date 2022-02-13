jQuery( document ).ready( function() {
	jQuery( '.cpa-color-picker' ).wpColorPicker();

	function hasValue( elem ) {
		return jQuery( elem ).filter( function() { return jQuery( this ).val(); } ).length > 0;
	}

	jQuery( '#removelogo' ).hide();

	if ( hasValue( '#team-logo' ) ) {
		jQuery( '#uploadlogo' ).hide();
		jQuery( '#removelogo' ).show();
	}

	let sender = '';

	jQuery( '#uploadlogo' ).on( 'click', function() {
		sender = jQuery( this ).attr( 'id' );
		tb_show( 'Upload Team Logo', 'media-upload.php?type=image&TB_iframe=1' );
		return false;
	} );

	window.send_to_editor = function( html ) {
		let imgurl = '';
		if ( sender === 'uploadlogo' ) {
			imgurl = jQuery( 'img', html ).prevObject[0].src;
			jQuery( '#logo' ).attr( 'src', imgurl );
			jQuery( '#team-logo' ).val( imgurl );
			jQuery( '#logo' ).show();
			jQuery( '#uploadlogo' ).hide();
			jQuery( '#placeholder-logo' ).hide();
			jQuery( '#removelogo' ).show();
			tb_remove();
		} else {
			imgurl = jQuery( 'img', html ).prevObject[0].src;
			jQuery( '#photo' ).attr( 'src', imgurl );
			jQuery( '#team-photo' ).val( imgurl );
			jQuery( '#photo' ).show();
			jQuery( '#uploadphoto' ).hide();
			jQuery( '#placeholder-photo' ).hide();
			jQuery( '#removephoto' ).show();
			tb_remove();
		}
	};

	jQuery( '#removelogo' ).on( 'click', function() {
		jQuery( '#logo' ).attr( 'src', '' );
		jQuery( '#team-logo' ).val( '' );
		jQuery( '#uploadlogo' ).show();
		jQuery( '#placeholder-logo' ).show();
		jQuery( '#removelogo' ).hide();
		return false;
	} );

	jQuery( '#removephoto' ).hide();

	if ( hasValue( '#team-photo' ) ) {
		jQuery( '#uploadphoto' ).hide();
		jQuery( '#removephoto' ).show();
	}

	jQuery( '#uploadphoto' ).on( 'click', function() {
		sender = jQuery( this ).attr( 'id' );
		tb_show( 'Upload Team Photo', 'media-upload.php?type=image&TB_iframe=2' );
		return false;
	} );

	jQuery( '#removephoto' ).on( 'click', function() {
		jQuery( '#photo' ).attr( 'src', '' );
		jQuery( '#team-photo' ).val('');
		jQuery( '#uploadphoto' ).show();
		jQuery( '#placeholder-photo' ).show();
		jQuery( '#removephoto' ).hide();
		return false;
	} );

} );
