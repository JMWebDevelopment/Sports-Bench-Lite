jQuery( function( $ ) {

	let width = 0;
	let count = 0;
	$( '.scoreboard-game' ).each( function() {
		width += $( this ).outerWidth();
		count += 1;
	} );
	const gameWidth = width / count;
	$( '#scoreboard-inner' ).width( width );
	const mainWidth = Math.round( $( '#scoreboard-main' ).width() / 10 ) * 10;
	const gamesPerSlide = Math.floor( mainWidth / gameWidth );
	let gamesLeft = count - gamesPerSlide;
	const initGamesLeft = gamesLeft;

	$( '#scoreboard-bar-right' ).click( function() {
		if ( gamesLeft > 0 ) {
			$( '#scoreboard-inner' ).animate( {
				left: '-=250px',
			}, 1000, 'linear', function() {
				gamesLeft -= 1;
			} );
		}
	} );

	$( '#scoreboard-bar-left' ).click( function() {
		if ( initGamesLeft !== gamesLeft ) {
			$( '#scoreboard-inner' ).animate( {
				left: '+=250px'
			}, 1000, 'linear', function() {
				gamesLeft += 1;
			} );
		}
	} );

	//* Read the games in the banner into an array
	const currentGames = [];
	$( '#scoreboard-bar #scoreboard-main #scoreboard-inner .scoreboard-game' ).map( function() {
		let gameID = this.id;
		gameID = gameID.replace( /\D/g, '' );
		currentGames.push( gameID );
	} );

	window.setInterval( getGameInfo, 60000 );

	function getGameInfo() {
		let loading = true;
		const data = {};
		const gameIDs = currentGames.join( ',' );
		$.get( sbscoreboard.rest_url + 'sportsbench/games?game_id=' + gameIDs, data, function( res ) {
			res.forEach( function( game ) {
				const theGame = $( '#scoreboard-bar #' + game.game_id );

				if ( game.game_status === 'final' ) {
					if ( theGame.find( '.time' ).text() === 'FINAL' ) {
						return;
					} else {
						theGame.find( '.time' ).text();
						theGame.find( '.time' ).text( 'FINAL' );
						theGame.find( '.time' ).effect( 'highlight', { color: '#999999' }, 10000 );
						return;
					}
				}

				if ( game.game_status === 'scheduled' ) {
					return;
				}

				if ( game.game_current_away_score !== theGame.find( '.away-score' ).text() ) {
					theGame.find( '.away-score' ).text( game.game_current_away_score );
					theGame.find( '.away-score' ).effect( 'highlight', { color: '#999999' }, 10000 );
				}

				if ( game.game_current_home_score !== theGame.find( '.home-score' ).text() ) {
					theGame.find( '.home-score' ).text( game.game_current_home_score );
					theGame.find( '.home-score' ).effect( 'highlight', { color: '#999999' }, 10000 );
				}

				let sep;
				if ( game.game_current_time !== '' && game.game_current_period !== '' ) {
					sep = ' | ';
				} else {
					sep = '';
				}
				const time = game.game_current_time.replace( '\\', '' );
				const period = game.game_current_period;
				const timeInGame = time + sep + period;

				if ( theGame.find( '.time' ).text() === '' ) {
					theGame.find( '.time' ).text( '' );
					theGame.find( '.time' ).text( timeInGame );
					theGame.find( '.time' ).effect( 'highlight', { color: '#999999' }, 10000 );
				} else {
					if ( timeInGame !== theGame.find( '.time' ).text() ) {
						theGame.find( '.time' ).text( timeInGame );
						theGame.find( '.time' ).effect( 'highlight', {color: '#999999'}, 10000 );
					}
				}
			} );
			loading = false;
		} );
	}

	if ( jQuery( 'div' ).hasClass( 'sports-bench-scoreboard-page' ) ) {

		window.setInterval( getScoreboardGameInfo, 60000 );

		function getScoreboardGameInfo() {
			let loadedGames = [];
			$( '.sports-bench-scoreboard-page .scoreboard-game' ).map( function() {
				let gameID = this.id;
				gameID = gameID.replace( /\D/g,'' );
				gameID = gameID.replace( 'game-', '' );
				loadedGames.push( gameID );
			} );

			let loading = true;
			const gameIDs = currentGames.join( ',' );
			const data = {};
			$.get( sbscoreboard.rest_url + 'sportsbench/games?game_id=' + gameIDs, data, function( res ) {
				res.forEach( function( game ) {
					const theGame = $( '#game-' + game.game_id );

					if ( game.game_status === 'final' ) {
						if ( theGame.find( '.time' ).text() === 'FINAL' ) {
							return;
						} else {
							theGame.find( '.time' ).text( 'FINAL' );
							theGame.find( '.time' ).effect( 'highlight', { color: '#999999' }, 10000 );
							return
						}
					}

					if ( game.game_status === 'scheduled' ) {
						return;
					}

					if ( game.game_current_away_score !== theGame.find( '.away-score' ).text() ) {
						theGame.find( '.away-score' ).text( game.game_current_away_score );
						theGame.find( '.away-score' ).effect( 'highlight', { color: '#999999' }, 10000 );
					}

					if ( game.game_current_home_score !== theGame.find( '.home-score' ).text() ) {
						theGame.find( '.home-score' ).text( game.game_current_home_score );
						theGame.find( '.home-score' ).effect( 'highlight', { color: '#999999' }, 10000 );
					}

					let sep;
					if ( game.game_current_time != '' && game.game_current_period != '' ) {
						sep = ' | ';
					} else {
						sep = '';
					}
					const time = game.game_current_time.replace( '\\', '' );
					const period = game.game_current_period;
					const timeInGame = time + sep + period;

					if ( theGame.find( '.time' ).text() === '' ) {
						theGame.find( '.time' ).text( '' );
						theGame.find( '.time' ).text( timeInGame );
						theGame.find( '.time' ).effect( 'highlight', { color: '#999999' }, 10000 );
					} else {
						if ( timeInGame != theGame.find( '.time' ).text() ) {
							theGame.find( '.time' ).text( timeInGame );
							theGame.find( '.time' ).effect( 'highlight', {color: '#999999'}, 10000 );
						}
					}

				} );
				loading = false;
			} );
		}
	}

	//* Read the games in the widget into an array
	let currentWidgetGames = [];
	$( '.sports_bench_scoreboard_widget .scoreboard-game' ).map( function() {
		let gameID = this.id;
		gameID = gameID.replace( /\D/g,'' );
		gameID = gameID.replace( 'widget-game-', '' );
		currentWidgetGames.push( gameID );
	} );

	window.setInterval( getWidgetGameInfo, 60000 );

	function getWidgetGameInfo() {
		let loading = true;
		const data = {};
		const gameIDs = currentWidgetGames.join( ',' );
		$.get( sbscoreboard.rest_url + 'sportsbench/games?game_id=' + gameIDs, data, function( res ) {
			res.forEach( function( game ) {
				const theGame = $( '.sports_bench_scoreboard_widget .scoreboard-game#widget-game-' + game.game_id );

				if ( game.game_status === 'final' ) {
					if ( theGame.find( '.time' ).text() === 'FINAL' ) {
						return;
					} else {
						theGame.find( '.time' ).text( 'FINAL' );
						theGame.find( '.time' ).effect( 'highlight', { color: '#999999' }, 10000 );
						return
					}
				}

				if ( game.game_status === 'scheduled' ) {
					return;
				}

				if ( game.game_current_away_score !== theGame.find( '.away-score' ).text() ) {
					theGame.find( '.away-score' ).text( game.game_current_away_score );
					theGame.find( '.away-score' ).effect( 'highlight', { color: '#999999' }, 10000 );
				}

				if ( game.game_current_home_score !== theGame.find( '.home-score' ).text() ) {
					theGame.find( '.home-score' ).text( game.game_current_home_score );
					theGame.find( '.home-score' ).effect( 'highlight', { color: '#999999' }, 10000 );
				}

				let sep;
				if ( game.game_current_time !== '' && game.game_current_period !== '' ) {
					sep = ' | ';
				} else {
					sep = '';
				}
				const time = game.game_current_time.replace( '\\', '' );
				const period = game.game_current_period;
				const timeInGame = time + sep + period;

				if ( theGame.find( '.time' ).text() === '' ) {
					theGame.find( '.time' ).text( '' );
					theGame.find( '.time' ).text( timeInGame );
					theGame.find( '.time' ).effect( 'highlight', { color: '#999999' }, 10000 );
				} else {
					if ( timeInGame !== theGame.find('.time').text() ) {
						theGame.find( '.time' ).text( timeInGame );
						theGame.find( '.time' ).effect( 'highlight', {color: '#999999'}, 10000 );
					}
				}
			} );
			loading = false;
		} );
	}
} );
