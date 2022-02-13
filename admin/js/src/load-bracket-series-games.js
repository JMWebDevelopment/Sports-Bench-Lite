jQuery( function( $ ) {

	$(document.body).on('change', '.series-team', function () {
		console.log( 'changed' );

		if ( $( this ).hasClass( 'team-one' ) ) {
			var team_one = $( this ).val();
			var team_two = $( this ).parents( '.playoff-series' ).find( '.team-two' ).val();
		} else {
			var team_two = $( this ).val();
			var team_one = $( this ).parents( '.playoff-series' ).find( '.team-one' ).val();
		}
		var season = $( '#bracket-season' ).val();

		var div = $( this );

		if ( (team_one == 0 || team_one == undefined ) || ( team_two == 0 || team_two == undefined ) ) {

		} else {
			let loading = true;
			var data = {
			};
			$.get( sbloadbracketseriesgames.rest_url + 'sportsbench/games?game_one_id=' + team_one + '&game_two_id=' + team_two + '&game_season=' + season, data, function ( res ) {
				if ( res ) {
					console.log(res);
					var html = '';
					html += '<option>' + sbloadbracketseriesgames.select_game + '</option>';
					res.forEach( function( game ) {
						var homeTeam = '';
						var awayTeam = '';
						var date = new Date( game.game_day );
						var months = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];
						var month = date.getMonth();
						var month = months[month];
						var day = date.getDay();
						var year = date.getFullYear();
						$.get( sbloadbracketseriesgames.rest_url + 'sportsbench/teams?team_id=' + game.game_home_id, data, function ( res ) {
							if ( res ) {
								homeTeam = res[0];
								$.get( sbloadbracketseriesgames.rest_url + 'sportsbench/teams?team_id=' + game.game_away_id, data, function ( res ) {
									if ( res ) {
										awayTeam = res[0];
										html += '<option value="' + game.game_id + '">' + month + ' ' + day+ ', ' + year + ': ' + awayTeam.team_name + ' at ' + homeTeam.team_name + '</option>';
										$( div ).parents( '.playoff-series' ).find( '.series-game' ).html( html );
									}
								});
							}
						});
					});

					loading = false;
				}
			} ).fail( function ( xhr, textStatus, e ) {
				console.log(xhr.responseText);
			} );
		}
	});

});
