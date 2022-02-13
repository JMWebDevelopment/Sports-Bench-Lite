jQuery( document ).ready( function() {
	function hasValue( elem ) {
		return jQuery( elem ).filter( function() {
			return jQuery( this ).val();
		} ).length > 0;
	}

	if ( hasValue( '#player-photo' ) ) {
		jQuery( '#uploadphoto' ).hide();
		jQuery( '#removephoto' ).show();
	} else {
		jQuery( '#uploadphoto' ).show();
		jQuery( '#removephoto' ).hide();
	}

	jQuery( '#player-birthday' ).datetimepicker( {
		timepicker: false,
	} );

	jQuery( '#uploadphoto' ).on( 'click', function() {
		tb_show( 'Upload Player Photo', 'media-upload.php?type=image&TB_iframe=1' );
		return false;
	} );

	let imgurl = '';

	window.send_to_editor = function( html ) {
		imgurl = jQuery( 'img', html ).prevObject[ 0 ].src;
		jQuery( '#photo' ).attr( 'src', imgurl );
		jQuery( '#player-photo' ).val( imgurl );
		jQuery( '#placeholder-photo' ).hide();
		jQuery( '#uploadphoto' ).hide();
		jQuery( '#removephoto' ).show();
		tb_remove();
	};

	jQuery( '#removephoto' ).on( 'click', function() {
		jQuery( '#photo' ).attr( 'src', '' );
		jQuery( '#player-photo' ).val( '' );
		jQuery( '#placeholder-photo' ).show();
		jQuery( '#uploadphoto' ).show();
		jQuery( '#removephoto' ).hide();
		return false;
	} );
} );

