jQuery( function( $ ) {

    let openSeasons = [];
    
    $( '.player-name' ).click( function() {
		console.log('clicked');

        var player_id = $( '#sports-bench-player-id' ).text();
		console.log(player_id);

        var row = $( this ).parent( 'tr' );
        var parentTable = $( this ).parents( 'table' );

        var info = $( this ).text().split("|");
        var season = info[ 0 ].trim();
        var team = info[ 1 ].trim().toLocaleLowerCase().replace( /\s+/g, '-' );
        var len = openSeasons.length;

        if ( $( parentTable ).hasClass( 'baseball' ) ) {

            if ( $( parentTable ).hasClass( 'batting' ) ) {
                var statGroup = 'batting';
            } else {
                var statGroup = 'pitching';
            }

            if ( len > 0 ) {

                var found = false;
                for ( i = 0; i < len; i++ ) {
                    if ( openSeasons[ i ][ 0 ] == season && openSeasons[ i ][ 1 ] == team && openSeasons[ i ][ 2 ] == statGroup ) {
                        found = true;
                        var ind = i;
                    }
                }

                if ( found == true ) {
                    var openSeason = '.season-' + season;
                    $( openSeason ).map( function () {
                        $( this ).hide( 500, function () {
                            $( this ).html('');
                        }) ;
                    } )
                    openSeasons.splice( ind, 1 );

                } else {
                    let loading = true;
                    if ( player_id != 'undefined' ) {
                        if ( player_id != sbloadseasons.player ) {
                            var player = player_id;
                        } else {
                            var player = sbloadseasons.player;
                        }
                    } else {
                        var player = sbloadseasons.player;
                    }
                    var data = {
                        action: 'sports_bench_load_seasons',
                        nonce: sbloadseasons.nonce,
                        season: season,
                        team: team,
                        stat_group: statGroup,
                        player: player
                    };
                    $.post( sbloadseasons.url, data, function ( res ) {
                        if ( res.success ) {
                            row.after( res.data );
                            jQuery( '.new-stats-row' ).hide( 0 ).show( 1000 );
                            loading = false;
                        }
                    } ).fail( function ( xhr, textStatus, e ) {

                    } );

                    var clicked = [ season, team, statGroup ];
                    openSeasons.push( clicked );

                }

            } else {
                let loading = true;
                if ( player_id != 'undefined' ) {
                    if ( player_id != sbloadseasons.player ) {
                        var player = player_id;
                    } else {
                        var player = sbloadseasons.player;
                    }
                } else {
                    var player = sbloadseasons.player;
                }
                var data = {
                    action: 'sports_bench_load_seasons',
                    nonce: sbloadseasons.nonce,
                    season: season,
                    team: team,
                    stat_group: statGroup,
                    player: player
                };
                $.post( sbloadseasons.url, data, function ( res ) {
                    if ( res.success ) {
                        row.after( res.data );
                        jQuery( '.new-stats-row' ).hide( 0 ).show( 1000 );
                        loading = false;
                    }
                } ).fail( function ( xhr, textStatus, e ) {
                    // console.log(xhr.responseText);
                } );

                var clicked = [ season, team, statGroup ];
                openSeasons.push( clicked );

            }


        } else if ( $( parentTable ).hasClass( 'hockey' ) ) {

            if ( $( parentTable ).hasClass( 'normal' ) ) {
                var statGroup = 'normal';
            } else {
                var statGroup = 'goalie';
            }

            if ( len > 0 ) {

                var found = false;
                for ( let i = 0; i < len; i++ ) {
                    if ( openSeasons[ i ][ 0 ] == season && openSeasons[ i ][ 1 ] == team && openSeasons[ i ][ 2 ] == statGroup ) {
                        found = true;
                        var ind = i;
                    }
                }

                if ( found == true ) {
                    row.nextAll( '.new-stats-row' ).hide( 500, function () {
                        row.nextAll( '.new-stats-row' ).html( '' );
                    });
                    openSeasons.splice( ind, 1 );

                } else {
                    if ( player_id != 'undefined' ) {
                        if ( player_id != sbloadseasons.player ) {
                            var player = player_id;
                        } else {
                            var player = sbloadseasons.player;
                        }
                    } else {
                        var player = sbloadseasons.player;
                    }
                    let loading = true;
                    var data = {
                        action: 'sports_bench_load_seasons',
                        nonce: sbloadseasons.nonce,
                        season: season,
                        team: team,
                        stat_group: statGroup,
                        player: player
                    };
                    $.post( sbloadseasons.url, data, function ( res ) {
                        if ( res.success ) {
                            row.after( res.data );
                            jQuery( '.new-stats-row' ).hide( 0 ).show( 1000 );
                            loading = false;
                        }
                    } ).fail( function ( xhr, textStatus, e ) {
                        // console.log(xhr.responseText);
                    } );

                    var clicked = [ season, team, statGroup ];
                    openSeasons.push( clicked );

                }

            } else {
                let loading = true;
                if ( player_id != 'undefined' ) {
                    if ( player_id != sbloadseasons.player ) {
                        var player = player_id;
                    } else {
                        var player = sbloadseasons.player;
                    }
                } else {
                    var player = sbloadseasons.player;
                }
                var data = {
                    action: 'sports_bench_load_seasons',
                    nonce: sbloadseasons.nonce,
                    season: season,
                    team: team,
                    stat_group: statGroup,
                    player: player
                };
                $.post( sbloadseasons.url, data, function ( res ) {
                    if ( res.success ) {
                        row.after( res.data );
                        jQuery( '.new-stats-row' ).hide( 0 ).show( 1000 );
                        loading = false;
                    }
                } ).fail( function ( xhr, textStatus, e ) {
                    // console.log(xhr.responseText);
                } );

                var clicked = [ season, team, statGroup ];
                openSeasons.push( clicked );

            }


        } else if ( $( parentTable ).hasClass( 'football' ) ) {

            if ( $( parentTable ).hasClass( 'passing' ) ) {
                var statGroup = 'passing';
            } else if ( $( parentTable ).hasClass( 'rushing' ) ) {
                var statGroup = 'rushing';
            } else if ( $( parentTable ).hasClass( 'receiving' ) ) {
                var statGroup = 'receiving';
            } else if ( $( parentTable ).hasClass( 'defense' ) ) {
                var statGroup = 'defense';
            }else if ( $( parentTable ).hasClass( 'kicking' ) ) {
                var statGroup = 'kicking';
            } else {
                var statGroup = 'returns';
            }

            if ( len > 0 ) {

                var found = false;
                for ( let i = 0; i < len; i++) {
                    if ( openSeasons[ i ][ 0 ] == season && openSeasons[ i ][ 1 ] == team && openSeasons[ i ][ 2 ] == statGroup ) {
                        found = true;
                        var ind = i;
                    }
                }

                if (found == true) {
                    row.nextAll( '.new-stats-row' ).hide( 500, function () {
                        row.nextAll( '.new-stats-row' ).html( '' );
                    });
                    openSeasons.splice( ind, 1 );

                } else {
                    if ( player_id != 'undefined' ) {
                        if ( player_id != sbloadseasons.player ) {
                            var player = player_id;
                        } else {
                            var player = sbloadseasons.player;
                        }
                    } else {
                        var player = sbloadseasons.player;
                    }
                    let loading = true;
                    var data = {
                        action: 'sports_bench_load_seasons',
                        nonce: sbloadseasons.nonce,
                        season: season,
                        team: team,
                        stat_group: statGroup,
                        player: player
                    };
                    $.post( sbloadseasons.url, data, function ( res ) {
                        if ( res.success ) {
                            row.after( res.data );
                            jQuery( '.new-stats-row' ).hide( 0 ).show( 1000 );
                            loading = false;
                        }
                    } ).fail( function ( xhr, textStatus, e ) {
                        // console.log(xhr.responseText);
                    } );

                    var clicked = [ season, team, statGroup ];
                    openSeasons.push( clicked );

                }

            } else {
                let loading = true;
                if ( player_id != 'undefined' ) {
                    if ( player_id != sbloadseasons.player ) {
                        var player = player_id;
                    } else {
                        var player = sbloadseasons.player;
                    }
                } else {
                    var player = sbloadseasons.player;
                }
                var data = {
                    action: 'sports_bench_load_seasons',
                    nonce: sbloadseasons.nonce,
                    season: season,
                    team: team,
                    stat_group: statGroup,
                    player: player
                };
                $.post( sbloadseasons.url, data, function ( res ) {
                    if ( res.success ) {
                        row.after( res.data );
                        jQuery( '.new-stats-row' ).hide( 0 ).show( 1000 );
                        loading = false;
                    }
                } ).fail( function ( xhr, textStatus, e ) {
                    // console.log(xhr.responseText);
                } );

                var clicked = [ season, team, statGroup ];
                openSeasons.push( clicked );

            }


        } else {
            if (len > 0) {

                var found = false;
                for (let i = 0; i < len; i++) {
                    if (openSeasons[ i ][ 0 ] == season && openSeasons[ i ][ 1 ] == team) {
                        found = true;
                        var ind = i;
                    }
                }

                if ( found == true ) {
                    row.nextAll( '.new-stats-row' ).hide( 500, function () {
                        row.nextAll( '.new-stats-row' ).html( '' );
                    });
                    openSeasons.splice( ind, 1 );

                } else {
                    if ( player_id != '' ) {
                        if ( player_id != sbloadseasons.player ) {
                            var player = player_id;
                        } else {
                            var player = sbloadseasons.player;
                        }
                    } else {
                        var player = sbloadseasons.player;
                    }
                    let loading = true;
                    var data = {
                        action: 'sports_bench_load_seasons',
                        nonce: sbloadseasons.nonce,
                        season: season,
                        team: team,
                        player: player
                    };
                    $.post( sbloadseasons.url, data, function ( res ) {
                        if ( res.success ) {
							console.log( res );
                            row.after( res.data );
                            jQuery( '.new-stats-row' ).hide( 0 ).show( 1000 );
                            loading = false;
                        }
                    } ).fail( function ( xhr, textStatus, e ) {
                        // console.log(xhr.responseText);
                    } );

                    var clicked = [ season, team ];
                    openSeasons.push( clicked );

                }

            } else {
                let loading = true;
                if ( player_id != '' ) {
                    if ( player_id != sbloadseasons.player ) {
                        var player = player_id;
                    } else {
                        var player = sbloadseasons.player;
                    }
                } else {
                    var player = sbloadseasons.player;
                }
                var data = {
                    action: 'sports_bench_load_seasons',
                    nonce: sbloadseasons.nonce,
                    season: season,
                    team: team,
                    player: player
                };
                $.post( sbloadseasons.url, data, function ( res ) {
                    if ( res.success ) {
						console.log( res );
                        row.after( res.data );
                        jQuery( '.new-stats-row' ).hide( 0 ).show( 1000 );
                        loading = false;
                    }
                } ).fail( function ( xhr, textStatus, e ) {
                    // console.log(xhr.responseText);
                } );

                var clicked = [ season, team ];
                openSeasons.push( clicked );

            }
        }
        
    });
    
});
