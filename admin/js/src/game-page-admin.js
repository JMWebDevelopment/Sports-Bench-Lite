jQuery( document ).ready( function($) {

    jQuery( '#game-day' ).datetimepicker();

    var awayId = jQuery( '#game-away-id' ).find( ':selected' ).val();
    jQuery( '.away-player-team' ).val( awayId );

    var homeId = jQuery( '#game-home-id' ).find( ':selected' ).val();
    jQuery( '.home-player-team' ).val( homeId );

    jQuery( '#game-away-id' ).change( function () {
        var awayTeam = jQuery( '#game-away_id' ).find( ':selected' ).text();
        jQuery( '#away-team-name' ).text( awayTeam )
    } );

    jQuery( '#game_home_id' ).change(function() {
        var awayTeam = jQuery( '#game_home_id' ).find( ':selected' ).text();
        jQuery( '#home-team-name' ).text( awayTeam )
    } );

    jQuery( '#add-game-event' ).on( 'click', function() {
        var row = jQuery( '.game-event-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-event-row' );
        row.removeClass( 'game-event-empty-row screen-reader-text' );
        row.insertAfter( '.game-event-row:last' );
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '.remove-game-event' ).on( 'click', function() {
        jQuery( this ).parents( 'tr' ).remove();
        return false;
    } );

    jQuery( '#add-away-1' ).on( 'click', function() {
        var row = jQuery( '.game-away-1-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-away-1-row' );
        row.removeClass( 'game-away-1-empty-row screen-reader-text' );
        row.insertAfter( '.game-away-1-row:last' );
        if ( sports_bench_update_batting_order() ) {
            var last_batter = row.prev().find( '#game_player_batting_order' ).val();
            row.find( '#game_player_batting_order' ).val( parseInt( last_batter ) + 1 );
        }
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '.remove-away-player' ).on( 'click', function() {
        jQuery( this ).parents( 'tr' ).remove();
        return false;
    } );

    jQuery( '#add-away-2' ).on( 'click', function() {
        var row = jQuery( '.game-away-2-empty-row.screen-reader-text' ).clone( true );
        if ( sports_bench_update_pitching_order() ) {
            var last_batter = row.prev().find( '#game_player_pitching_order' ).val();
            row.find( '#game_player_pitching_order' ).val( parseInt( last_batter ) + 1 );
        }
        row.addClass( 'new-row game-away-2-row' );
        row.removeClass( 'game-away-2-empty-row screen-reader-text' );
        row.insertAfter( '.game-away-2-row:last' );
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '#add-away-3' ).on( 'click', function() {
        var row = jQuery( '.game-away-3-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-away-3-row' );
        row.removeClass( 'game-away-3-empty-row screen-reader-text' );
        row.insertAfter( '.game-away-3-row:last' );
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '#add-away-4' ).on( 'click', function() {
        var row = jQuery( '.game-away-4-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-away-4-row' );
        row.removeClass( 'game-away-4-empty-row screen-reader-text' );
        row.insertAfter( '.game-away-4-row:last' );
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '#add-away-5' ).on( 'click', function() {
        var row = jQuery( '.game-away-5-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-away-5-row' );
        row.removeClass( 'game-away-5-empty-row screen-reader-text' );
        row.insertAfter( '.game-away-5-row:last' );
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '#add-away-6' ).on( 'click', function() {
        var row = jQuery( '.game-away-6-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-away-6-row' );
        row.removeClass( 'game-away-6-empty-row screen-reader-text' );
        row.insertAfter( '.game-away-6-row:last' );
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '#add-home-1' ).on( 'click', function() {
        var row = jQuery( '.game-home-1-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-home-1-row' );
        row.removeClass( 'game-home-1-empty-row screen-reader-text' );
        row.insertAfter( '.game-home-1-row:last' );
        if ( sports_bench_update_batting_order() ) {
            var last_batter = row.prev().find( '#game_player_batting_order' ).val();
            row.find( '#game_player_batting_order' ).val( parseInt( last_batter ) + 1 );
        }
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '.remove-home-player' ).on( 'click', function() {
        jQuery( this ).parents( 'tr' ).remove();
        return false;
    } );

    jQuery( '#add-home-2' ).on( 'click', function() {
        var row = jQuery( '.game-home-2-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-home-2-row' );
        row.removeClass( 'game-home-2-empty-row screen-reader-text' );
        row.insertAfter( '.game-home-2-row:last' );
        if ( sports_bench_update_pitching_order() ) {
            var last_batter = row.prev().find( '#game_player_pitching_order' ).val();
            row.find( '#game_player_pitching_order' ).val( parseInt( last_batter ) + 1 );
        }
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '#add-home-3' ).on( 'click', function() {
        var row = jQuery( '.game-home-3-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-home-3-row' );
        row.removeClass( 'game-home-3-empty-row screen-reader-text' );
        row.insertAfter( '.game-home-3-row:last' );
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '#add-home-4' ).on( 'click', function() {
        var row = jQuery( '.game-home-4-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-home-4-row' );
        row.removeClass( 'game-home-4-empty-row screen-reader-text' );
        row.insertAfter( '.game-home-4-row:last' );
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '#add-home-5' ).on( 'click', function() {
        var row = jQuery( '.game-home-5-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-home-5-row' );
        row.removeClass( 'game-home-5-empty-row screen-reader-text' );
        row.insertAfter( '.game-home-5-row:last' );
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '#add-home-6' ).on( 'click', function() {
        var row = jQuery( '.game-home-6-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-home-6-row' );
        row.removeClass( 'game-home-6-empty-row screen-reader-text' );
        row.insertAfter( '.game-home-6-row:last' );
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '.started-field' ).each( function () {
		console.log( jQuery( this ).parents( 'tr' ).find( '#game-player-start:checked' ) );
        if ( jQuery( this ).parents( 'tr' ).find( '#game-player-start:checked' ).length == '1' ) {
            jQuery( this ).parents( 'tr' ).find( '#game_player_started_hidden' ).attr( 'disabled', true );
        } else {
            jQuery( this ).parents( 'tr' ).find( '#game_player_started_hidden' ).attr( 'disabled', false );
        }
    } );

    jQuery( '.game-away-1-empty-row #game_player_started_hidden' ).attr( 'disabled', true );
    jQuery( '.game-home-1-empty-row #game_player_started_hidden' ).attr( 'disabled', true );

    jQuery( '.started-field' ).on( 'click', function () {
		console.log( jQuery( this ).parents( 'tr' ).find( '#game-player-start:checked' ) );
        if ( jQuery(this).parents('tr').find('#game-player-start:checked').length == '1' ) {
            jQuery( this ).parents('tr').find( '#game_player_started_hidden' ).attr("disabled",true);
        } else {
            jQuery( this ).parents('tr').find( '#game_player_started_hidden' ).attr("disabled",false)
        }
    } );

    jQuery( '#add-game-goal' ).on('click', function() {
        var row = jQuery( '.game-goal-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-goal-row' );
        row.removeClass( 'game-goal-empty-row screen-reader-text' );
        row.insertAfter( '.game-goal-row:last' );
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '.remove-game-goal' ).on( 'click', function() {
        jQuery( this ).parents( 'tr' ).remove();
        return false;
    } );

    jQuery( '#add-game-penalty' ).on( 'click', function() {
        var row = jQuery( '.game-penalty-empty-row.screen-reader-text' ).clone( true );
        row.addClass( 'new-row game-penalty-row' );
        row.removeClass( 'game-penalty-empty-row screen-reader-text' );
        row.insertAfter( '.game-penalty-row:last' );
        jQuery( '.new-row .new-field' ).attr( 'disabled', false );
        return false;
    } );

    jQuery( '.remove-game-penalty' ).on( 'click', function() {
        jQuery( this ).parents( 'tr' ).remove();
        return false;
    } );

	console.log(jQuery('#away-team-first-quarter').length);
    if ( jQuery('#away-team-first-quarter').length > 0 ) {
		console.log('loading basketball');

        /**
         * Changes the final score for a team in the game admin based off of inputs for each quarter
         *
         * @param team
         *
         * @since 1.0
         */
        function changeScore( team ) {
			let overtime;
            if ( team == 'Away' ) {
                if ( jQuery.isNumeric( jQuery( '#away-team-overtime' ).val() ) === false ) {
                    overtime = 0;
                } else {
                    overtime = jQuery( '#away-team-overtime' ).val();
                }
				console.log( overtime );
                var final = parseInt( jQuery( '#away-team-first-quarter' ).val() ) + parseInt( jQuery( '#away-team-second-quarter' ).val() ) + parseInt( jQuery( '#away-team-third-quarter' ).val() ) + parseInt( jQuery( '#away-team-fourth-quarter' ).val() ) + parseInt( overtime);
				jQuery( '#away-team-final' ).val( final );
            } else {
                if ( jQuery.isNumeric( jQuery( '#home-team-overtime' ).val() ) == false ) {
                    overtime = 0;
                } else {
                    overtime = jQuery( '#home-team-overtime' ).val();
                }
                var final = parseInt( jQuery( '#home-team-first-quarter' ).val() ) + parseInt( jQuery( '#home-team-second-quarter' ).val() ) + parseInt( jQuery( '#home-team-third-quarter' ).val() ) + parseInt( jQuery( '#home-team-fourth-quarter' ).val() ) + parseInt( overtime );
                jQuery( '#home-team-final' ).val( final );
            }
        }

        jQuery( '#away-team-first-quarter' ).change( function () {
            changeScore( 'Away' );
        } );

        jQuery( '#away-team-second-quarter' ).change( function () {
            changeScore( 'Away' );
        } );

        jQuery( '#away-team-third-quarter' ).change( function () {
            changeScore( 'Away' );
        } );

        jQuery( '#away-team-fourth-quarter' ).change( function () {
            changeScore( 'Away' );
        } );

        jQuery( '#away-team-overtime' ).change( function () {
            changeScore( 'Away' );
        } );

        jQuery( '#home-team-first-quarter' ).change( function () {
            changeScore( 'Home' );
        } );

        jQuery( '#home-team-second-quarter' ).change( function () {
            changeScore( 'Home' );
        } );

        jQuery( '#home-team-third-quarter' ).change( function () {
            changeScore( 'Home' );
        } );

        jQuery( '#home-team-fourth-quarter' ).change( function () {
            changeScore( 'Home' );
        } );

        jQuery( '#home-team-overtime' ).change( function () {
            changeScore( 'Home' );
        } );
    } else if ( jQuery( '#away-team-first-period' ).length > 0 ) {

        /**
         * Changes the final score for a team in the game admin based off of inputs for each quarter
         *
         * @param team
         *
         * @since 1.0
         */
        function changeScore( team ) {
            if ( team == 'Away' ) {
				let overtime;
                if ( jQuery.isNumeric( jQuery( '#away-team-overtime' ) ) === false ) {
                    overtime = 0;
                } else {
                    overtime = jQuery( '#away-team-overtime' ).val();
                }
                var final = parseInt( jQuery( '#away-team-first-period' ).val() ) + parseInt( jQuery( '#away-team-second-period' ).val() ) + parseInt( jQuery( '#away-team-third-period' ).val() ) + parseInt( overtime );
                jQuery( '#away-team-final' ).val( final );
            } else {
				let overtime;
                if ( jQuery.isNumeric( jQuery( '#home-team-overtime' ) ) == false ) {
                    overtime = 0;
                } else {
                    overtime = jQuery('#home-team-overtime').val();
                }
                var final = parseInt( jQuery( '#home-team-first-period' ).val() ) + parseInt( jQuery( '#home-team-second-period' ).val() ) + parseInt( jQuery( '#home-team-third-period' ).val() ) + parseInt( overtime );
                jQuery( '#home-team-final' ).val( final );
            }
        }

        jQuery( '#away-team-first-period' ).change( function () {
            changeScore( 'Away' );
        } );

        jQuery( '#away-team-second-period' ).change( function () {
            changeScore( 'Away' );
        } );

        jQuery( '#away-team-third-period' ).change( function () {
            changeScore( 'Away' );
        } );

        jQuery( '#away-team-overtime' ).change( function () {
            changeScore( 'Away' );
        } );

        jQuery( '#home-team-first-period' ).change( function () {
            changeScore( 'Home' );
        } );

        jQuery( '#home-team-second-period' ).change( function () {
            changeScore( 'Home' );
        } );

        jQuery( '#home-team-third-period' ).change( function () {
            changeScore( 'Home' );
        } );

        jQuery( '#home-team-overtime' ).change( function () {
            changeScore( 'Home' );
        } );

    } else if ( jQuery( '#away-team-first-half' ).length > 0 ) {
		console.log('soccer');
        /**
         * Changes the final score for a team in the game admin based off of inputs for each quarter
         *
         * @param team
         *
         * @since 1.0
         */
        function changeScore( team ) {
            if ( team === 'Away' ) {
				let overtime = 0;
				console.log( parseInt( jQuery( '#away-team-extra-time' ).val() ) );
                if ( isNaN( parseInt( jQuery( '#away-team-extra-time' ).val() ) ) ) {
                    overtime = 0;
                } else {
                    overtime = jQuery( '#away-team-extra-time' ).val();
                }
				console.log(overtime);
                let final = parseInt( jQuery( '#away-team-first-half' ).val() ) + parseInt( jQuery( '#away-team-second-half' ).val() ) + parseInt( overtime );
                jQuery('#away-team-final').val( final );
            } else {
				let overtime = 0;
				console.log( parseInt( jQuery( '#home-team-extra-time' ).val() ) );
                if ( isNaN( parseInt( jQuery( '#home-team-extra-time' ).val() ) ) ) {
                    overtime = 0;
                } else {
                    overtime = jQuery( '#home-team-extra-time' ).val();
                }
				console.log(overtime);
                let final = parseInt( jQuery( '#home-team-first-half' ).val() ) + parseInt( jQuery( '#home-team-second-half' ).val() ) + parseInt( overtime );
                jQuery( '#home-team-final' ).val( final );
            }
        }

        jQuery( '#away-team-first-half' ).change( function () {
            changeScore( 'Away' );
        } );

        jQuery( '#away-team-second-half' ).change( function () {
            changeScore( 'Away' );
        } );

        jQuery( '#away-team-extra-time' ).change( function () {
            changeScore( 'Away' );
        } );

        jQuery( '#home-team-first-half' ).change( function () {
            changeScore( 'Home' );
        } );

        jQuery( '#home-team-second-half' ).change( function () {
            changeScore( 'Home' );
        } );

        jQuery( '#home-team-extra-time' ).change( function () {
            changeScore( 'Home' );
        } );
    } else {

    }

    if ( jQuery('#game-status').find(":selected").val() == 'in_progress' ) {
        jQuery( '#in-progress-fields' ).show();
    } else {
        jQuery( '#in-progress-fields' ).hide();
    }

    jQuery('#game-status').on( 'change', function() {
       if ( jQuery('#game-status').find(":selected").val() === 'in_progress' ) {
           jQuery( '#in-progress-fields' ).show();
       } else {
           jQuery( '#in-progress-fields' ).hide();
       }
    });

    if ( '1' === jQuery('input[name="game_neutral_site"]:checked').val() ) {
        jQuery( '#neutral-site-fields' ).show();
    } else {
        jQuery( '#neutral-site-fields' ).hide();
    }

	jQuery('input[name=game_neutral_site]').on( 'change', function() {
		if ( '1' === jQuery('input[name="game_neutral_site"]:checked').val() ) {
			jQuery( '#neutral-site-fields' ).show();
			console.log('neutral site game');
		} else {
			jQuery( '#neutral-site-fields' ).hide();
			console.log('home game');
		}
	});

	jQuery( '#game-away-id' ).on( 'change', function() {
        var team_id = jQuery( '#game-away-id' ).val();
        let loading = true;
        var data = {
        };
        $.get( sbloadgames.rest_url + 'sportsbench/teams/' + team_id, data, function ( res ) {
            if ( res ) {
                var team = res;
                if (team.team_nickname == "") {
                    jQuery( '#away-team-name' ).html(team.team_location);
                    jQuery( '#away-team-location' ).html(team.team_location);
                    jQuery( '#away-team-nickname' ).html('');
                } else {
					jQuery( '#away-team-name' ).html(team.team_location);
                    jQuery( '#away-team-location' ).html(team.team_location);
                    jQuery( '#away-team-nickname' ).html(team.team_nickname);
                    jQuery( '#away-no-nickname' ).html('');
                }
                jQuery('#away-team-logo').attr('src', team.team_logo);
                //jQuery( '#away-team-stats' ).html(team.team_location);
                loading = false;
            }
        } ).fail( function ( xhr, textStatus, e ) {
            console.log(xhr.responseText);
        } );
    });

    jQuery( '#game-home-id' ).on( 'change', function() {
        var team_id = jQuery( '#game-home-id' ).val();
        let loading = true;
        var data = {
        };
        $.get( sbloadgames.rest_url + 'sportsbench/teams/' + team_id, data, function ( res ) {
            if ( res ) {
                var team = res;
                if (team.team_nickname == "") {
                    jQuery( '#home-team-name' ).html(team.team_location);
                    jQuery( '#home-team-location' ).html(team.team_location);
                    jQuery( '#home-team-nickname' ).html('');
                } else {
                    jQuery( '#home-team-location' ).html(team.team_location);
                    jQuery( '#home-team-nickname' ).html(team.team_nickname);
					jQuery( '#home-team-name' ).html(team.team_location);
                    jQuery( '#home-no-nickname' ).html('');
                }
                jQuery('#home-team-logo').attr('src', team.team_logo);
                //jQuery('#home-team-stats').html(team.team_location);
                loading = false;
            }
        } ).fail( function ( xhr, textStatus, e ) {
            console.log(xhr.responseText);
        } );
    });

	if ( jQuery( '.match-event-category' ).length ) {
		console.log('events are here');
		jQuery( '.match-event-category' ).change( function () {
			console.log('event changed');
			var eventName = jQuery( this ).find( ':selected' ).val();
			console.log( eventName );
			var parent = jQuery( this ).parents( 'tr' );
			$( parent ).find( '.primary-player-label' ).removeClass( 'show' );
			$( parent ).find( '.secondary-player-label' ).removeClass( 'show' );
			if ( 'goal' === eventName ) {
				$( parent ).find( '.goal-scored' ).each( function(index) {
					$( this ).addClass( 'show' );
					$( this ).parent().addClass( 'showed-label' );
				} );

				var teamId = jQuery( parent ).find( '.team :selected' ).val();
				var data = {
				};
				var loading = true;
				$.get( sbloadgames.rest_url + 'sportsbench/players?team_id=' + teamId, data, function ( res ) {
					if ( res ) {
						var html = '';
						html += '<option>' + sbloadgames.select_player + '</option>';
						res.forEach( function( player ) {
							html += '<option value="' + player.player_id + '">' + player.player_first_name + ' ' + player.player_last_name + '</option>';
						});
						$( parent ).find( '#match-event-secondary' ).html( '' );
						$( parent ).find( '#match-event-secondary' ).html( html );
						loading = false;
					}
				} ).fail( function ( xhr, textStatus, e ) {
					console.log(xhr.responseText);
				} );
			} else if ( 'pk-goal' === eventName ) {
				$( parent ).find( '.pk-goal-scored' ).each( function(index) {
					$( this ).addClass( 'show' );
					$( this ).parent().addClass( 'showed-label' );
				} );
			} else if ( 'pk-given' === eventName ) {
				$( parent ).find( '.pk-awarded' ).each( function(index) {
					$( this ).addClass( 'show' );
					$( this ).parent().addClass( 'showed-label' );
				} );
			} else if ( 'corner-kick' === eventName ) {
				$( parent ).find( '.ck-conceeded' ).each( function(index) {
					$( this ).addClass( 'show' );
					$( this ).parent().addClass( 'showed-label' );
				} );
			} else if ( 'foul' === eventName ) {
				$( parent ).find( '.foul-given' ).each( function(index) {
					$( this ).addClass( 'show' );
					$( this ).parent().addClass( 'showed-label' );
				} );
			} else if ( 'shot-missed' === eventName ) {
				$( parent ).find( '.shot-missed' ).each( function(index) {
					$( this ).addClass( 'show' );
					$( this ).parent().addClass( 'showed-label' );
				} );
			} else if ( 'shot-saved' === eventName ) {
				$( parent ).find( '.shot-saved' ).each( function(index) {
					$( this ).addClass( 'show' );
					$( this ).parent().addClass( 'showed-label' );
				} );
			} else if ( 'offside' === eventName ) {
				$( parent ).find( '.offside' ).each( function(index) {
					$( this ).addClass( 'show' );
					$( this ).parent().addClass( 'showed-label' );
				} );
			} else if ( 'yellow' === eventName || 'red' === eventName ) {
				$( parent ).find( '.card-given' ).each( function(index) {
					$( this ).addClass( 'show' );
					$( this ).parent().addClass( 'showed-label' );
				} );
			}
		});
	}

	if ( jQuery( '.team' ).length ) {
        jQuery( '.team' ).change( function () {
            var teamId = jQuery( this ).find( ':selected' ).val();
            var parent = jQuery( this ).parents( 'tr' );
            let loading = true;
            var data = {
            };
            $.get( sbloadgames.rest_url + 'sportsbench/players?team_id=' + teamId, data, function ( res ) {
                if ( res ) {
                    var html = '';
                    html += '<option>' + sbloadgames.select_player + '</option>';
                    res.forEach( function( player ) {
                        html += '<option value="' + player.player_id + '">' + player.player_first_name + ' ' + player.player_last_name + '</option>';
                    });
                    $( parent ).find( '#match-event-player' ).html( '' );
                    $( parent ).find( '#match-event-player' ).html( html );
                    if ( $( parent ).find( '#match-event-assist-one' ) ) {
                        $( parent ).find( '#match-event-assist-one' ).html( '' );
                        $( parent ).find( '#match-event-assist-one' ).html( html );
                        $( parent ).find( '#match-event-assist-two' ).html( '' );
                        $( parent ).find( '#match-event-assist-two' ).html( html );
                    }
                    loading = false;
                }
            } ).fail( function ( xhr, textStatus, e ) {
                console.log(xhr.responseText);
            } );
			var opponentTeamId;
			var awayTeam = jQuery( '#game-away-id' ).val();
			var homeTeam = jQuery( '#game-home-id' ).val();
			if ( awayTeam === teamId ) {
				opponentTeamId = homeTeam;
			} else {
				opponentTeamId = awayTeam;
			}
			$.get( sbloadgames.rest_url + 'sportsbench/players?team_id=' + opponentTeamId, data, function ( res ) {
                if ( res ) {
                    var html = '';
                    html += '<option>' + sbloadgames.select_player + '</option>';
                    res.forEach( function( player ) {
                        html += '<option value="' + player.player_id + '">' + player.player_first_name + ' ' + player.player_last_name + '</option>';
                    });
                    $( parent ).find( '#match-event-secondary' ).html( '' );
                    $( parent ).find( '#match-event-secondary' ).html( html );
                    loading = false;
                }
            } ).fail( function ( xhr, textStatus, e ) {
                console.log(xhr.responseText);
            } );
        } );
    }

    jQuery( "#game-away-id" ).change( function () {

		var teamId = jQuery( this ).find( ':selected' ).val();
		let loading = true;
		var data = {
		};
		$.get( sbloadgames.rest_url + 'sportsbench/players?team_id=' + teamId, data, function ( res ) {
			if ( res ) {
				var html = '';
				html += '<option value="">' + sbloadgames.select_player + '</option>';
				res.forEach( function( player ) {
					html += '<option value="' + player.player_id + '">' + player.player_first_name + ' ' + player.player_last_name + '</option>';
				});
				$( '.away-player' ).html( '' );
				$( '.away-player' ).html( html );
				loading = false;
			}
		} ).fail(function ( xhr, textStatus, e) {
			// console.log(xhr.responseText);
		} );

		$( '.away-player-team' ).val( teamId );

	} );

    jQuery( '#game-home-id' ).change( function () {

		var teamId = jQuery( this ).find( ':selected' ).val();
		let loading = true;
		var data = {
		};
		$.get( sbloadgames.rest_url + 'sportsbench/players?team_id=' + teamId, data, function ( res ) {
			if ( res ) {
				var html = '';
				html += '<option value="">' + sbloadgames.select_player + '</option>';
				res.forEach( function( player ) {
					html += '<option value="' + player.player_id + '">' + player.player_first_name + ' ' + player.player_last_name + '</option>';
				});
				$( '.home-player' ).html( '' );
				$( '.home-player' ).html( html );
				loading = false;
			}
		} ).fail( function ( xhr, textStatus, e ) {
			// console.log(xhr.responseText);
		} );

		$( '.home-player-team' ).val( teamId );

	} );


} );

function sports_bench_update_batting_order() {
    return jQuery('#game_player_batting_order').length > 0;
};

function sports_bench_update_pitching_order() {
    return jQuery('#game_player_pitching_order').length > 0;
};
