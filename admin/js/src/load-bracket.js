jQuery( function( $ ) {

	if ( 'double' === $( '#bracket-format' ).find( ':selected' ).val() ) {
		$('#num-teams option[value="2"]').hide();
		$('#num-teams option[value="6"]').hide();
		$('#num-teams option[value="8"]').hide();
		$('#num-teams option[value="12"]').hide();
		$('#num-teams option[value="16"]').hide();
		$('#num-teams option[value="32"]').hide();
		$('#num-teams option[value="64"]').hide();
	} else {
		$('#num-teams option[value="2"]').show();
		$('#num-teams option[value="6"]').show();
		$('#num-teams option[value="8"]').show();
		$('#num-teams option[value="12"]').show();
		$('#num-teams option[value="16"]').show();
		$('#num-teams option[value="32"]').show();
		$('#num-teams option[value="64"]').show();
	}

	$('#bracket-format').on( 'change', function() {
		if ( $('#bracket-format').find(":selected").val() == 'double' ) {
			$('#num-teams option[value="2"]').hide();
			$('#num-teams option[value="6"]').hide();
			$('#num-teams option[value="8"]').hide();
			$('#num-teams option[value="12"]').hide();
			$('#num-teams option[value="16"]').hide();
			$('#num-teams option[value="32"]').hide();
			$('#num-teams option[value="64"]').hide();
		} else {
			$('#num-teams option[value="2"]').show();
			$('#num-teams option[value="6"]').show();
			$('#num-teams option[value="8"]').show();
			$('#num-teams option[value="12"]').show();
			$('#num-teams option[value="16"]').show();
			$('#num-teams option[value="32"]').show();
			$('#num-teams option[value="64"]').show();
		}
	} );

	$('#create-bracket').on('click', function () {
		let num_teams = $('#num-teams').find(":selected").val();
		let bracket_format = $('#bracket-format').find(":selected").val();
		let loading = true;
		let data = {
			action: 'sports_bench_load_bracket',
			nonce: sbloadbracket.nonce,
			num_teams: num_teams,
			bracket_format: bracket_format
		};
		$.post( sbloadbracket.url, data, function ( res ) {
			if ( res.success ) {
				var bracket = res.data;
				jQuery( '.form-series-container' ).html( bracket );

				$( '.format-select' ).map( function () {

					if ( $(this).val() == 'single-game' ) {
						$(this).parents('.playoff-series').find('.two-legs').hide();
						$(this).parents('.playoff-series').find('.three-games').hide();
						$(this).parents('.playoff-series').find('.five-games').hide();
						$(this).parents('.playoff-series').find('.seven-games').hide();
					} else if ( $(this).val() == 'two-legs' ) {
						$(this).parents('.playoff-series').find('.two-legs').show();
						$(this).parents('.playoff-series').find('.three-games').hide();
						$(this).parents('.playoff-series').find('.five-games').hide();
						$(this).parents('.playoff-series').find('.seven-games').hide();
					} else if ( $(this).val() == 'best-of-three' ) {
						$(this).parents('.playoff-series').find('.two-legs').show();
						$(this).parents('.playoff-series').find('.three-games').show();
						$(this).parents('.playoff-series').find('.five-games').hide();
						$(this).parents('.playoff-series').find('.seven-games').hide();
					} else if ( $(this).val() == 'best-of-five' ) {
						$(this).parents('.playoff-series').find('.two-legs').show();
						$(this).parents('.playoff-series').find('.three-games').show();
						$(this).parents('.playoff-series').find('.five-games').show();
						$(this).parents('.playoff-series').find('.seven-games').hide();
					} else if ( $(this).val() == 'best-of-seven' ) {
						$(this).parents('.playoff-series').find('.two-legs').show();
						$(this).parents('.playoff-series').find('.three-games').show();
						$(this).parents('.playoff-series').find('.five-games').show();
						$(this).parents('.playoff-series').find('.seven-games').show();
					} else {
						$(this).parents('.playoff-series').find('.two-legs').hide();
						$(this).parents('.playoff-series').find('.three-games').hide();
						$(this).parents('.playoff-series').find('.five-games').hide();
						$(this).parents('.playoff-series').find('.seven-games').hide();
					}

				});

				loading = false;
			}
		} ).fail( function ( xhr, textStatus, e ) {
			console.log(xhr.responseText);
		} );
		return false;
	});

	$( '.format-select' ).map( function () {

		if ( $(this).val() == 'single-game' ) {
			$(this).parents('.playoff-series').find('.two-legs').hide();
			$(this).parents('.playoff-series').find('.three-games').hide();
			$(this).parents('.playoff-series').find('.five-games').hide();
			$(this).parents('.playoff-series').find('.seven-games').hide();
		} else if ( $(this).val() == 'two-legs' ) {
			$(this).parents('.playoff-series').find('.two-legs').show();
			$(this).parents('.playoff-series').find('.three-games').hide();
			$(this).parents('.playoff-series').find('.five-games').hide();
			$(this).parents('.playoff-series').find('.seven-games').hide();
		} else if ( $(this).val() == 'best-of-three' ) {
			$(this).parents('.playoff-series').find('.two-legs').show();
			$(this).parents('.playoff-series').find('.three-games').show();
			$(this).parents('.playoff-series').find('.five-games').hide();
			$(this).parents('.playoff-series').find('.seven-games').hide();
		} else if ( $(this).val() == 'best-of-five' ) {
			$(this).parents('.playoff-series').find('.two-legs').show();
			$(this).parents('.playoff-series').find('.three-games').show();
			$(this).parents('.playoff-series').find('.five-games').show();
			$(this).parents('.playoff-series').find('.seven-games').hide();
		} else if ( $(this).val() == 'best-of-seven' ) {
			$(this).parents('.playoff-series').find('.two-legs').show();
			$(this).parents('.playoff-series').find('.three-games').show();
			$(this).parents('.playoff-series').find('.five-games').show();
			$(this).parents('.playoff-series').find('.seven-games').show();
		} else {
			$(this).parents('.playoff-series').find('.two-legs').hide();
			$(this).parents('.playoff-series').find('.three-games').hide();
			$(this).parents('.playoff-series').find('.five-games').hide();
			$(this).parents('.playoff-series').find('.seven-games').hide();
		}

	});

	$( document.body ).on( 'change', '.format-select', function () {

		if ( $(this).val() == 'single-game' ) {
			$(this).parents('.playoff-series').find('.two-legs').hide();
			$(this).parents('.playoff-series').find('.three-games').hide();
			$(this).parents('.playoff-series').find('.five-games').hide();
			$(this).parents('.playoff-series').find('.seven-games').hide();
		} else if ( $(this).val() == 'two-legs' ) {
			$(this).parents('.playoff-series').find('.two-legs').show();
			$(this).parents('.playoff-series').find('.three-games').hide();
			$(this).parents('.playoff-series').find('.five-games').hide();
			$(this).parents('.playoff-series').find('.seven-games').hide();
		} else if ( $(this).val() == 'best-of-three' ) {
			$(this).parents('.playoff-series').find('.two-legs').show();
			$(this).parents('.playoff-series').find('.three-games').show();
			$(this).parents('.playoff-series').find('.five-games').hide();
			$(this).parents('.playoff-series').find('.seven-games').hide();
		} else if ( $(this).val() == 'best-of-five' ) {
			$(this).parents('.playoff-series').find('.two-legs').show();
			$(this).parents('.playoff-series').find('.three-games').show();
			$(this).parents('.playoff-series').find('.five-games').show();
			$(this).parents('.playoff-series').find('.seven-games').hide();
		} else if ( $(this).val() == 'best-of-seven' ) {
			$(this).parents('.playoff-series').find('.two-legs').show();
			$(this).parents('.playoff-series').find('.three-games').show();
			$(this).parents('.playoff-series').find('.five-games').show();
			$(this).parents('.playoff-series').find('.seven-games').show();
		}

	});
});
