<?php
/**
 * Creates the series class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Base;

use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Team;

/**
 * The core series class.
 *
 * This is used for playoff series in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Series {

	/**
	 * The id of the series.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $series_id;

	/**
	 * The id of the series' bracket.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $bracket_id;

	/**
	 * The format of the series.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $series_format;

	/**
	 * The id of the first team in the series.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $team_one_id;

	/**
	 * The seed of the first team in the series.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $team_one_seed;

	/**
	 * The id of the second team in the series.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $team_two_id;

	/**
	 * The seed of the second team in the series.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $team_two_seed;

	/**
	 * The ids of the games in the series.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_ids;

	/**
	 * The round of the series.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $playoff_round;

	/**
	 * The id of the series opposite of the current series in the bracket.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $opposite_series;

	/**
	 * Creates the new Series object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param int $series_id      The ID of the playoff series to create the object for.
	 */
	public function __construct( $series_id ) {
		global $wpdb;
		$table  = SB_TABLE_PREFIX . 'playoff_series';
		$series = Database::get_results( $wpdb->prepare( "SELECT * FROM $table WHERE series_id = %d;", $series_id ) );

		if ( $series ) {
			$this->series_id     = $series[0]->series_id;
			$this->bracket_id    = $series[0]->bracket_id;
			$this->series_format = $series[0]->series_format;
			$this->playoff_round = $series[0]->playoff_round;
			$this->team_one_id   = $series[0]->team_one_id;
			$this->team_one_seed = $series[0]->team_one_seed;
			$this->team_two_id   = $series[0]->team_two_id;
			$this->team_two_seed = $series[0]->team_two_seed;
			$this->game_ids      = $series[0]->game_ids;

		}
	}

	/**
	 * Returns the series id.
	 *
	 * @since 2.0
	 *
	 * @return int      The series id.
	 */
	public function get_series_id() {
		return $this->series_id;
	}

	/**
	 * Returns the bracket id.
	 *
	 * @since 2.0
	 *
	 * @return int      The bracket id.
	 */
	public function get_bracket_id() {
		return $this->bracket_id;
	}

	/**
	 * Returns the series format.
	 *
	 * @since 2.0
	 *
	 * @return string      The series format.
	 */
	public function get_series_format() {
		return $this->series_format;
	}

	/**
	 * Returns the playoff round.
	 *
	 * @since 2.0
	 *
	 * @return int      The playoff round.
	 */
	public function get_playoff_round() {
		return $this->playoff_round;
	}

	/**
	 * Returns the first team id.
	 *
	 * @since 2.0
	 *
	 * @return int      The first team id.
	 */
	public function get_team_one_id() {
		return $this->team_one_id;
	}

	/**
	 * Returns the first team seed.
	 *
	 * @since 2.0
	 *
	 * @return int      The first team seed.
	 */
	public function get_team_one_seed() {
		return $this->team_one_seed;
	}

	/**
	 * Returns the second team id.
	 *
	 * @since 2.0
	 *
	 * @return int      The second team id.
	 */
	public function get_team_two_id() {
		return $this->team_two_id;
	}

	/**
	 * Returns the second team seed.
	 *
	 * @since 2.0
	 *
	 * @return int      The second team seed.
	 */
	public function get_team_two_seed() {
		return $this->team_two_seed;
	}

	/**
	 * Returns the game ids for the series.
	 *
	 * @since 2.0
	 *
	 * @return array      The game ids for the series.
	 */
	public function get_game_ids() {
		return $this->game_ids;
	}

	/**
	 * Gets the score for the series.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The score for the series.
	 */
	public function get_series_score() {

		$team_one_score = 0;
		$team_two_score = 0;
		$team_one       = new Team( (int) $this->team_one_id );
		$team_two       = new Team( (int) $this->team_two_id );
		$score          = false;
		$num_games      = 1;
		$games          = $this->game_ids;
		$games          = explode( ', ', $games );
		$decided        = false;

		foreach ( $games as $game ) {
			if ( 0 !== $game ) {
				$the_game = new Game( (int) $game );
				if ( 'final' === $the_game->get_game_status() ) {
					if ( 'single-game' === $this->series_format ) {
						if ( 1 === $num_games ) {
							if ( $the_game->get_game_away_final() > $the_game->get_game_home_final() || ( $the_game->get_shootout( $the_game->get_game_away_id() ) > $the_game->get_shootout( $the_game->get_game_home_id() ) ) ) {
								if ( $the_game->get_game_away_id() === $this->team_one_id ) {
									$score = $team_one->get_team_location() . ' ' . esc_html__( 'advances ', 'sports-bench' ) . $the_game->get_game_away_final() . '–' . $the_game->get_game_home_final();
								} else {
									$score = $team_two->get_team_location() . ' ' . esc_html__( 'advances ', 'sports-bench' ) . $the_game->get_game_away_final() . '–' . $the_game->get_game_home_final();
								}
							} elseif ( $the_game->get_game_home_final() > $the_game->get_game_away_final() || ( $the_game->get_shootout( $the_game->get_game_home_id() ) > $the_game->get_shootout( $the_game->get_game_away_id() ) ) ) {
								if ( $the_game->get_game_home_id() === $this->team_one_id ) {
									$score = $team_one->get_team_location() . ' ' . esc_html__( 'advances ', 'sports-bench' ) . $the_game->get_game_home_final() . '–' . $the_game->get_game_away_final();
								} else {
									$score = $team_two->get_team_location() . ' ' . esc_html__( 'advances ', 'sports-bench' ) . $the_game->get_game_home_final() . '–' . $the_game->get_game_away_final();
								}
							}
						}
					} elseif ( 'two-legs' === $this->series_format ) {
						if ( $num_games == 1 ) {
							if ( $the_game->get_game_away_id() === $this->team_one_id ) {
								$team_one_score += $the_game->get_game_away_final();
								$team_two_score += $the_game->get_game_home_final();
							} else {
								$team_one_score += $the_game->get_game_home_final();
								$team_two_score += $the_game->get_game_away_final();
							}
							if ( $team_one_score > $team_two_score ) {
								$score = $team_one->get_team_location() . ' ' . esc_html__( 'leads ', 'sports-bench' ) . $team_one_score . '–' . $team_two_score;
							} elseif ( $team_one_score < $team_two_score ) {
								$score = $team_two->get_team_location() . ' ' . esc_html__( 'leads ', 'sports-bench' ) . $team_two_score . '–' . $team_one_score;
							} else {
								$score = esc_html__( 'Series tied ', 'sports-bench' ) . $team_one_score . '–' . $team_two_score;
							}
						} elseif ( 2 === $num_games ) {
							if ( $the_game->get_game_away_id() == $this->team_one_id ) {
								$team_one_score += $the_game->get_game_away_final();
								$team_two_score += $the_game->get_game_home_final();
							} else {
								$team_one_score += $the_game->get_game_home_final();
								$team_two_score += $the_game->get_game_away_final();
							}
							if ( $team_one_score > $team_two_score ) {
								$score = $team_one->get_team_location() . ' ' . esc_html__( 'advances ', 'sports-bench' ) . $team_one_score . '–' . $team_two_score;
							} elseif ( $team_two_score > $team_one_score ) {
								$score = $team_two->get_team_location() . ' ' . esc_html__( 'advances ', 'sports-bench' ) . $team_two_score . '–' . $team_one_score;
							} else {
								if ( $the_game->get_shootout( $the_game->get_game_away_id() ) > $the_game->get_shootout( $the_game->get_game_home_id() ) ) {
									if ( $the_game->get_game_away_id() === $this->team_one_id ) {
										if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
											$score = $team_one->get_team_location() . ' ' . esc_html__( 'advances on PKs, ', 'sports-bench' ) . $the_game->get_shootout( $the_game->get_game_away_id() ) . '–' . $the_game->get_shootout( $the_game->get_game_home_id() );
										} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
											$score = $team_one->get_team_location() . ' ' . esc_html__( 'advances on shootout, ', 'sports-bench' ) . $the_game->get_shootout( $the_game->get_game_away_id() ) . '–' . $the_game->get_shootout( $the_game->get_game_home_id() );
										}
									} else {
										if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
											$score = $team_two->get_team_location() . ' ' . esc_html__( 'advances on PKs, ', 'sports-bench' ) . $the_game->get_shootout( $the_game->get_game_away_id() ) . '–' . $the_game->get_shootout( $the_game->get_game_home_id() );
										} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
											$score = $team_two->get_team_location() . ' ' . esc_html__( 'advances on shootout, ', 'sports-bench' ) . $the_game->get_shootout( $the_game->get_game_away_id() ) . '–' . $the_game->get_shootout( $the_game->get_game_home_id() );
										}
									}
								} elseif ( $the_game->get_shootout( $the_game->get_game_home_id() ) > $the_game->get_shootout( $the_game->get_game_away_id() ) ) {
									if ( $the_game->get_game_home_id() === $this->team_one_id ) {
										if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
											$score = $team_one->get_team_location() . ' ' . esc_html__( 'advances on PKs, ', 'sports-bench' ) . $the_game->get_shootout( $the_game->get_game_home_id() ) . '–' . $the_game->get_shootout( $the_game->get_game_away_id() );
										} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
											$score = $team_one->get_team_location() . ' ' . esc_html__( 'advances on shootout, ', 'sports-bench' ) . $the_game->get_shootout( $the_game->get_game_home_id() ) . '–' . $the_game->get_shootout( $the_game->get_game_away_id() );
										}
									} else {
										if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
											$score = $team_two->get_team_location() . ' ' . esc_html__( 'advances on PKs, ', 'sports-bench' ) . $the_game->get_shootout( $the_game->get_game_home_id() ) . '–' . $the_game->get_shootout( $the_game->get_game_away_id() );
										} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
											$score = $team_two->get_team_location() . ' ' . esc_html__( 'advances on shootout, ', 'sports-bench' ) . $the_game->get_shootout( $the_game->get_game_home_id() ) . '–' . $the_game->get_shootout( $the_game->get_game_away_id() );
										}
									}
								}
							}
						}
					} else {
						if ( $the_game->get_game_away_final() > $the_game->get_game_home_final() || ( $the_game->get_shootout( $the_game->get_game_away_id() ) > $the_game->get_shootout( $the_game->get_game_home_id() ) ) && false === $decided ) {
							if ( $the_game->get_game_away_id() === $this->team_one_id ) {
								$team_one_score++;
							} else {
								$team_two_score++;
							}
							if ( $team_one_score > $team_two_score ) {
								$score = $team_one->get_team_location() . ' ' . esc_html__( 'leads ', 'sports-bench' ) . $team_one_score . '–' . $team_two_score;
							} elseif ( $team_one_score < $team_two_score ) {
								$score = $team_two->get_team_location() . ' ' . esc_html__( 'leads ', 'sports-bench' ) . $team_two_score . '–' . $team_one_score;
							} else {
								$score = esc_html__( 'Series tied ', 'sports-bench' ) . $team_one_score . '–' . $team_two_score;
							}
						} elseif ( $the_game->get_game_home_final() > $the_game->get_game_away_final() || ( $the_game->get_shootout( $the_game->get_game_home_id() ) > $the_game->get_shootout( $the_game->get_game_away_id() ) ) && false === $decided ) {
							if ( $the_game->get_game_home_id() === $this->team_one_id ) {
								$team_one_score++;
							} else {
								$team_two_score++;
							}
							if ( $team_one_score > $team_two_score ) {
								$score = $team_one->get_team_location() . ' ' . esc_html__( 'leads ', 'sports-bench' ) . $team_one_score . '–' . $team_two_score;
							} elseif ( $team_one_score < $team_two_score ) {
								$score = $team_two->get_team_location() . ' ' . esc_html__( 'leads ', 'sports-bench' ) . $team_two_score . '–' . $team_one_score;
							} else {
								$score = esc_html__( 'Series tied ', 'sports-bench' ) . $team_one_score . '–' . $team_two_score;
							}
						}
						if ( 'best-of-three' === $this->series_format ) {
							if ( 2 === $team_one_score ) {
								$score   = $team_one->get_team_location() . ' ' . esc_html__( 'advances ', 'sports-bench' ) . $team_one_score . '–' . $team_two_score;
								$decided = true;
							}
							if ( 2 === $team_two_score ) {
								$score   = $team_two->get_team_location() . ' ' . esc_html__( 'advances ', 'sports-bench' ) . $team_two_score . '–' . $team_one_score;
								$decided = true;
							}
						} elseif ( 'best-of-five' === $this->series_format ) {
							if ( 3 === $team_one_score ) {
								$score   = $team_one->get_team_location() . ' ' . esc_html__( 'advances ', 'sports-bench' ) . $team_one_score . '–' . $team_two_score;
								$decided = true;
							}
							if ( 3 === $team_two_score ) {
								$score   = $team_two->get_team_location() . ' ' . esc_html__( 'advances ', 'sports-bench' ) . $team_two_score . '–' . $team_one_score;
								$decided = true;
							}
						} elseif ( 'best-of-seven' === $this->series_format ) {
							if ( 4 === $team_one_score ) {
								$score   = $team_one->get_team_location() . ' ' . esc_html__( 'advances ', 'sports-bench' ) . $team_one_score . '–' . $team_two_score;
								$decided = true;
							}
							if ( 4 === $team_two_score ) {
								$score   = $team_two->get_team_location() . ' ' . esc_html__( 'advances ', 'sports-bench' ) . $team_two_score . '–' . $team_one_score;
								$decided = true;
							}
						}
					}
				}
			}
			$num_games++;
		}

		return $score;
	}

	/**
	 * Gets the winner of the series.
	 *
	 * @since 2.0.0
	 *
	 * @return int      The id of the team that won the series.
	 */
	public function get_series_winner() {

		$team_one_score = 0;
		$team_two_score = 0;
		$winner         = false;
		$num_games      = 1;
		$games          = $this->game_ids;
		$games          = explode( ', ', $games );
		$decided        = false;

		foreach ( $games as $game ) {
			if ( 0 !== $game ) {
				$the_game = new Sports_Bench_Game( (int) $game );
				if ( 'final' === $the_game->get_game_status() ) {
					if ( 'single-game' === $this->series_format ) {
						if ( 1 === $num_games ) {
							if ( $the_game->get_game_away_final() > $the_game->get_game_home_final() || ( $the_game->get_shootout( $the_game->get_game_away_id() ) > $the_game->get_shootout( $the_game->get_game_home_id() ) ) ) {
								if ( $the_game->get_game_away_id() === $this->team_one_id ) {
									$winner = $this->team_one_id;
								} else {
									$winner = $this->team_two_id;
								}
							} elseif ( $the_game->get_game_home_final() > $the_game->get_game_away_final() || ( $the_game->get_shootout( $the_game->get_game_home_id() ) > $the_game->get_shootout( $the_game->get_game_away_id() ) ) ) {
								if ( $the_game->get_game_home_id() === $this->team_one_id ) {
									$winner = $this->team_one_id;
								} else {
									$winner = $this->team_two_id;
								}
							}
						}
					} elseif ( 'two-legs' === $this->series_format ) {
						if ( 1 === $num_games ) {
							if ( $the_game->get_game_away_id() === $this->team_one_id ) {
								$team_one_score += $the_game->get_game_away_final();
								$team_two_score += $the_game->get_game_home_final();
							} else {
								$team_one_score += $the_game->get_game_home_final();
								$team_two_score += $the_game->get_game_away_final();
							}
						} elseif ( 2 === $num_games ) {
							if ( $the_game->get_game_away_id() === $this->team_one_id ) {
								$team_one_score += $the_game->get_game_away_final();
								$team_two_score += $the_game->get_game_home_final();
							} else {
								$team_one_score += $the_game->get_game_home_final();
								$team_two_score += $the_game->get_game_away_final();
							}
							if ( $team_one_score > $team_two_score ) {
								$winner = $this->team_one_id;
							} elseif ( $team_two_score > $team_one_score ) {
								$winner = $this->team_two_id;
							} else {
								if ( $the_game->get_shootout( $the_game->get_game_away_id() ) > $the_game->get_shootout( $the_game->get_game_home_id() ) ) {
									if ( $the_game->get_game_away_id() === $this->team_one_id ) {
										$winner = $this->team_one_id;
									} else {
										$winner = $this->team_two_id;
									}
								} elseif ( $the_game->get_shootout( $the_game->get_game_home_id() ) > $the_game->get_shootout( $the_game->get_game_away_id() ) ) {
									if ( $the_game->get_game_home_id() === $this->team_one_id ) {
										$winner = $this->team_one_id;
									} else {
										$winner = $this->team_two_id;
									}
								}
							}
						}
					} else {
						if ( $the_game->get_game_away_final() > $the_game->get_game_home_final() || ( $the_game->get_shootout( $the_game->get_game_away_id() ) > $the_game->get_shootout( $the_game->get_game_home_id() ) ) && $decided == false ) {
							if ( $the_game->get_game_away_id() == $this->team_one_id ) {
								$team_one_score++;
							} else {
								$team_two_score++;
							}
						} elseif ( $the_game->get_game_home_final() > $the_game->get_game_away_final() || ( $the_game->get_shootout( $the_game->get_game_home_id() ) > $the_game->get_shootout( $the_game->get_game_away_id() ) ) && $decided == false ) {
							if ( $the_game->get_game_home_id() === $this->team_one_id ) {
								$team_one_score++;
							} else {
								$team_two_score++;
							}
						}
						if ( 'best-of-three' === $this->series_format ) {
							if ( 2 === $team_one_score ) {
								$winner  = $this->team_one_id;
								$decided = true;
							}
							if ( 2 === $team_two_score ) {
								$winner  = $this->team_two_id;
								$decided = true;
							}
						} elseif ( 'best-of-five' === $this->series_format ) {
							if ( 3 === $team_one_score ) {
								$winner  = $this->team_one_id;
								$decided = true;
							}
							if ( 3 === $team_two_score ) {
								$winner  = $this->team_two_id;
								$decided = true;
							}
						} elseif ( 'best-of-seven' === $this->series_format ) {
							if ( 4 === $team_one_score ) {
								$winner  = $this->team_one_id;
								$decided = true;
							}
							if ( 4 === $team_two_score ) {
								$winner  = $this->team_two_id;
								$decided = true;
							}
						}
					}
				}
			}
			$num_games++;
		}

		return $winner;
	}

	/**
	 * Gets the score for a team in the series.
	 *
	 * @since 2.0.0
	 *
	 * @param string $team      Either team-one or team-two to get the score for that team in the series.
	 * @return int              The score for the team in the series.
	 */
	public function get_team_score( $team ) {

		if ( 'team-one' === $team ) {
			$team_id = $this->team_one_id;
		} else {
			$team_id = $this->team_two_id;
		}

		$games = $this->game_ids;
		$games = explode( ', ', $games );

		$score = 0;

		foreach ( $games as $game ) {
			if ( 0 !== $game ) {
				$the_game = new Game( (int) $game );
				if ( 'final' === $the_game->get_game_status() ) {
					if ( 'single-game' === $this->series_format ) {
						if ( $team_id === $the_game->get_game_away_id() ) {
							$score = $the_game->get_game_away_final();
							if ( $the_game->get_shootout( $team_id ) ) {
								$score = $score . ' (' . $the_game->get_shootout( $team_id ) . ')';
							}
						} else {
							$score = $the_game->get_game_home_final();
							if ( $the_game->get_shootout( $team_id ) ) {
								$score = $score . ' (' . $the_game->get_shootout( $team_id ) . ')';
							}
						}
					} elseif ( 'two-legs' === $this->series_format ) {
						if ( $team_id === $the_game->get_game_away_id() ) {
							$score += $the_game->get_game_away_final();
							if ( $the_game->get_shootout( $team_id ) ) {
								$score = $score . ' (' . $the_game->get_shootout( $team_id ) . ')';
							}
						} else {
							$score += $the_game->get_game_home_final();
							if ( $the_game->get_shootout( $team_id ) ) {
								$score = $score . ' (' . $the_game->get_shootout( $team_id ) . ')';
							}
						}
					} else {
						if ( $team_id === $the_game->get_game_away_id() ) {
							if ( $the_game->get_game_away_final() > $the_game->get_game_home_final() ) {
								$score++;
							}
						} else {
							if ( $the_game->get_game_away_final() < $the_game->get_game_home_final() ) {
								$score++;
							}
						}
					}
				}
			}
		}

		return $score;

	}


}
