/**
 * Block dependencies
 */
 import icon from '../icon';
 import SelectTeam from '../select-team';
 //import './style.scss';
 import './editor.scss';
 import Select from 'react-select';
 
 /**
  * Internal block libraries
  */
 const { __ } = wp.i18n;
 const {
	 registerBlockType,
	 blockEditRender,
	 Spinner
 } = wp.blocks; // Import registerBlockType() from wp.blocks
 const {
	 InspectorControls
 } = wp.editor;
 
 //this is where block control componants go! a-ha!
 const { ToggleControl, SelectControl } = InspectorControls;
 
 registerBlockType(
	 'sportsbench/stats', {
		 title: __('Sports Bench Stats'),
		 icon: icon,
		 category: 'sports-bench-blocks',
		 keywords: [ __( 'Sports' ), __( 'Bench' ), __( 'stats' ) ],
 
		 attributes: {
			 getTeam: {
				 type: 'boolean',
				 default: true,
			 },
			 hasTeam: {
				 type: 'boolean',
				 default: false,
			 },
			 team_id: {
				 type: 'int',
			 },
			 team_string: {
				 type: 'string',
			 },
			 items: {
				 type: 'array',
			 },
		 },
 
		 edit( { attributes, setAttributes, focus, setFocus, className } ) {
			 const { getTeam, hasTeam, team_id, team_string, items } = attributes;
 
			 function onSelectItems( option ){
				 if( option === null ){
					 setAttributes({
						 items: option
					 });
				 } else {
					 setAttributes({
						 items: option
					 });
				 }
			 }
 
			 function handleFetchErrors( response ) {
				 if (!response.ok) {
					 console.log('fetch error, status: ' + response.statusText);
				 }
				 return response;
			 }
 
			 if ( sportsbench_globals.sport === 'baseball' ) {
				 var itemOptions = [
					 { value: 'at_bats', label: 'At Bats' },
					 { value: 'hits', label: 'Hits' },
					 { value: 'batting_average', label: 'Batting Average' },
					 { value: 'runs', label: 'Runs' },
					 { value: 'rbis', label: 'RBI' },
					 { value: 'doubles', label: 'Doubles' },
					 { value: 'triples', label: 'Triples' },
					 { value: 'homeruns', label: 'Home Runs' },
					 { value: 'strikeouts', label: 'Strikeouts' },
					 { value: 'walks', label: 'Walks' },
					 { value: 'hit_by_pitch', label: 'Hit By Pitch' },
					 { value: 'wins', label: 'Wins' },
					 { value: 'saves', label: 'Saves' },
					 { value: 'innings_pitched', label: 'Innings Pitched' },
					 { value: 'pitcher_strikeouts', label: 'Pitcher Strikeouts' },
					 { value: 'pitcher_walks', label: 'Pitcher Walks' },
					 { value: 'hit_batters', label: 'Hit Batters' },
					 { value: 'runs_allowed', label: 'Runs Allowed' },
					 { value: 'earned_runs', label: 'Earned Runs' },
					 { value: 'era', label: 'ERA' },
					 { value: 'hits_allowed', label: 'Hits Allowed' },
					 { value: 'homeruns_allowed', label: 'Home Runs Allowed' },
					 { value: 'pitch_count', label: 'Pitch Count' }
				 ];
			 } else if ( sportsbench_globals.sport === 'basketball' ) {
				 var itemOptions = [
					 { value: 'started', label: 'Starts' },
					 { value: 'minutes', label: 'Minutes' },
					 { value: 'points', label: 'Points' },
					 { value: 'points_per_game', label: 'Points Per Game' },
					 { value: 'shooting_percentage', label: 'Shooting Percentage' },
					 { value: 'ft_percentage', label: 'Free Throw Percentage' },
					 { value: '3p_percentage', label: '3-Point Percentage' },
					 { value: 'off_rebound', label: 'Offensive Rebounds' },
					 { value: 'def_rebound', label: 'Defensive Rebounds' },
					 { value: 'rebounds', label: 'Total Rebounds' },
					 { value: 'assists', label: 'Assists' },
					 { value: 'steals', label: 'Steals' },
					 { value: 'blocks', label: 'Blocks' },
					 { value: 'to', label: 'Turnovers' },
					 { value: 'fouls', label: 'Fouls' },
					 { value: 'plus_minus', label: 'Plus/Minus' }
				 ];
			 } else if ( sportsbench_globals.sport === 'football' ) {
				 var itemOptions = [
					 { value: 'completions', label: 'Completions' },
					 { value: 'attempts', label: 'Attempts' },
					 { value: 'comp_percentage', label: 'Completion Percentage' },
					 { value: 'pass_yards', label: 'Passing Yards' },
					 { value: 'pass_tds', label: 'Passing Touchdowns' },
					 { value: 'pass_ints', label: 'Interceptions' },
					 { value: 'rushes', label: 'Rushes' },
					 { value: 'rush_yards', label: 'Rushing Yards' },
					 { value: 'rush_tds', label: 'Rushing Touchdowns' },
					 { value: 'rush_fumbles', label: 'Rushing Fumbles' },
					 { value: 'catches', label: 'Catches' },
					 { value: 'receiving_yards', label: 'Receiving Yards' },
					 { value: 'receiving_tds', label: 'Receiving Touchdowns' },
					 { value: 'receiving_fumbles', label: 'Receiving Fumbles' },
					 { value: 'tackles', label: 'Tackles' },
					 { value: 'tfl', label: 'Tackles For Loss' },
					 { value: 'sacks', label: 'Sacks' },
					 { value: 'pbu', label: 'Pass Breakups' },
					 { value: 'ints', label: 'Interceptions' },
					 { value: 'tds', label: 'Defensive Touchdowns' },
					 { value: 'ff', label: 'Forced Fumbles' },
					 { value: 'fr', label: 'Fumbles Recovered' },
					 { value: 'blocked', label: 'Blocked Kicks' },
					 { value: 'yards', label: 'Defensive Return Yards' },
					 { value: 'fgm', label: 'Made Field Goals' },
					 { value: 'fg_percentage', label: 'Field Goal Percentage' },
					 { value: 'xpm', label: 'Made Extra Points' },
					 { value: 'xp_percentage', label: 'Extra Point Percentage' },
					 { value: 'touchbacks', label: 'Touchbacks' },
					 { value: 'returns', label: 'Returns' },
					 { value: 'return_yards', label: 'Return Yards' },
					 { value: 'return_tds', label: 'Return Touchdowns' },
					 { value: 'return_fumbles', label: 'Return Fumbles' }
				 ];
			 } else if ( sportsbench_globals.sport === 'hockey' ) {
				 var itemOptions = [
					 { value: 'goals', label: 'Goals' },
					 { value: 'assists', label: 'Assists' },
					 { value: 'shots', label: 'Shots' },
					 { value: 'sog', label: 'Shots on Goal' },
					 { value: 'fouls', label: 'Fouls' },
					 { value: 'fouls_suffered', label: 'Fouls Suffered' },
					 { value: 'shots_faced', label: 'Shots Faced' },
					 { value: 'shots_saved', label: 'Shots Saved' },
					 { value: 'goals_allowed', label: 'Goals Allowed' },
					 { value: 'goals_against_average', label: 'Goals Against Average' }
				 ];
			 } else if ( sportsbench_globals.sport === 'rugby' ) {
				 var itemOptions = [
					 { value: 'tries', label: 'Tries' },
					 { value: 'assists', label: 'Assists' },
					 { value: 'conversions', label: 'Conversions' },
					 { value: 'penalty_goals', label: 'Penalty Goals' },
					 { value: 'drop_kicks', label: 'Drop Kicks' },
					 { value: 'points', label: 'Points' },
					 { value: 'penalties_conceeded', label: 'Penalties Conceded' },
					 { value: 'meters_run', label: 'Meters Run' },
					 { value: 'red_cards', label: 'Red Cards' },
					 { value: 'yellow_cards', label: 'Yellow Cards' }
				 ];
			 } else if ( sportsbench_globals.sport === 'soccer' ) {
				 var itemOptions = [
					 { value: 'goals', label: 'Goals' },
					 { value: 'assists', label: 'Assists' },
					 { value: 'shots', label: 'Shots' },
					 { value: 'sog', label: 'Shots on Goal' },
					 { value: 'fouls', label: 'Fouls' },
					 { value: 'fouls_suffered', label: 'Fouls Suffered' },
					 { value: 'shots_faced', label: 'Shots Faced' },
					 { value: 'shots_saved', label: 'Shots Saved' },
					 { value: 'goals_allowed', label: 'Goals Allowed' },
					 { value: 'goals_against_average', label: 'Goals Against Average' }
				 ];
			 } else {
				 var itemOptions = [
					 { value: 'sets_played', label: 'Sets Played' },
					 { value: 'points', label: 'Points' },
					 { value: 'kills', label: 'Kills' },
					 { value: 'hitting_errors', label: 'Hitting Errors' },
					 { value: 'attacks', label: 'Attacks' },
					 { value: 'hitting_percentage', label: 'Hitting Percentage' },
					 { value: 'set_attempts', label: 'Set Attempts' },
					 { value: 'set_errors', label: 'Setting Errors' },
					 { value: 'serves', label: 'Serves' },
					 { value: 'serve_errors', label: 'Serving Errors' },
					 { value: 'aces', label: 'Aces' },
					 { value: 'blocks', label: 'Blocks' },
					 { value: 'block_attempts', label: 'Block Attempts' },
					 { value: 'block_errors', label: 'Blocking Errors' },
					 { value: 'digs', label: 'Digs' },
					 { value: 'receiving_errors', label: 'Receiving Errors' }
				 ];
			 }
 
			 const selectItems = (
				 <Select
					 onChange={ onSelectItems }
					 options={itemOptions}
					 multi={true}
					 removeSelected={false}
					 value={items}
				 />
			 );
 
			 const controls = (
				 <InspectorControls key="inspector">
					 <div class="blocks-base-control">
						 <label class="blocks-base-control_label">{__('Select Stats Items to Show')}</label>
						 { selectItems }
					 </div>
				 </InspectorControls>
			 );
 
			 return [
				 controls,
				 <div className={className}>
					 <h2>{__('Sports Bench Stats')}</h2>
					 <p>{__('The stats block isn\'t editable. You can select the stats to show on the page in the block attributes in the right-hand column.')}</p>
				 </div>
			 ];
		 },
 
		 save() {
			 // Rendering in PHP
			 return null;
		 },
	 }
 );
 