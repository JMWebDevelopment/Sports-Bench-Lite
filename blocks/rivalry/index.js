/**
 * Block dependencies
 */
 import icon from '../icon';
 import SelectTeam from '../select-team';
 import Input from '../input';
 //import './style.scss';
 import './editor.scss';
 
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
	 'sportsbench/rivalry', {
		 title: __('Sports Bench Rivalry'),
		 icon: icon,
		 category: 'sports-bench-blocks',
		 keywords: [ __( 'Sports' ), __( 'Bench' ), __( 'rivalry' ) ],
 
		 attributes: {
			 getTeam: {
				 type: 'boolean',
				 default: true,
			 },
			 hasTeam: {
				 type: 'boolean',
				 default: false,
			 },
			 team_one_id: {
				 type: 'int',
			 },
			 team_one_string: {
				 type: 'string',
			 },
			 teams_one: {
				 type: 'array',
			 },
			 team_two_id: {
				 type: 'int',
			 },
			 team_two_string: {
				 type: 'string',
			 },
			 teams_two: {
				 type: 'array',
			 },
			 recent_games: {
				 type: 'int',
				 default: 5,
			 }
		 },
 
		 edit( { attributes, setAttributes, focus, setFocus, className } ) {
			 const { getTeam, hasTeam, team_one_id, team_one_string, teams_one, team_two_id, team_two_string, teams_two, recent_games } = attributes;
 
			 function onSelectFirstTeam( option ){
				 console.log('change team');
				 if( option === null ){
					 getTeams().then( function( options ) {
						 setAttributes({
							 team_one_id: "",
							 team_one_string: "",
							 getTeam: false,
							 teams_one: options
						 });
					 });
				 } else {
					 console.log('There is an option');
					 getTeams().then( function( options ) {
						 setAttributes({
							 team_one_id: option.value,
							 team_one_string: option.label,
							 getTeam: true,
							 teams_one: options
						 });
					 });
				 }
			 }
 
			 function onSelectSecondTeam( option ){
				 console.log('change team');
				 if( option === null ){
					 getTeams().then( function( options ) {
						 setAttributes({
							 team_two_id: "",
							 team_two_string: "",
							 getTeam: false,
							 teams_two: options
						 });
					 });
				 } else {
					 console.log('There is an option');
					 getTeams().then( function( options ) {
						 setAttributes({
							 team_two_id: option.value,
							 team_two_string: option.label,
							 getTeam: true,
							 teams_two: options
						 });
					 });
				 }
			 }
 
			 const onChangeInput = ( event ) => {
				 setAttributes( { recent_games: event.target.value } );
			 };
 
			 var props = { attributes, setAttributes, focus, setFocus, className };
 
			 function getTeams(){
				 var url = '/wp-json/sportsbench/teams/';
				 return fetch( url, {
					 credentials: 'same-origin',
					 method: 'get',
					 headers: {
						 Accept: 'application/json',
						 'Content-Type': 'application/json',
						 'X-WP-Nonce': sportsbench_globals.nonce
					 }})
					 .then( handleFetchErrors )
					 .then( ( response ) => response.json() )
					 .then( ( json ) => {
						 console.log(json);
						 var options = json.map( function(opt, i){
							 return {value: opt.team_id, label: opt.team_name}
						 })
						 return options;
					 })
					 .catch(function(e) {
						 console.log(e);
					 });
 
			 }
 
			 function handleFetchErrors( response ) {
				 if (!response.ok) {
					 console.log('fetch error, status: ' + response.statusText);
				 }
				 return response;
			 }
 
			 var selectTeamOneValue = { value: team_one_id, label: team_one_string }
			 const selectFirstTeam = (
				 <SelectTeam
					 onChange={ onSelectFirstTeam }
					 restUrl="/wp-json/sportsbench/teams/?team_name="
					 initial_value={ selectTeamOneValue }
					 nonce={ sportsbench_globals.nonce }
				 />
			 );
 
			 var selectTeamTwoValue = { value: team_two_id, label: team_two_string }
			 const selectSecondTeam = (
				 <SelectTeam
					 onChange={ onSelectSecondTeam }
					 restUrl="/wp-json/sportsbench/teams/?team_name="
					 initial_value={ selectTeamTwoValue }
					 nonce={ sportsbench_globals.nonce }
				 />
			 );
 
			 const recentGames = (
				 <Input
					 id="recent-games"
					 labelText={__('Number of Recent Games')}
					 { ...{ onChangeInput, ...props } }
				 />
			 );
 
			 const controls = (
				 <InspectorControls key="inspector">
					 <div class="blocks-base-control">
						 <label class="blocks-base-control_label">{__('Select the First Team')}</label>
						 { selectFirstTeam }
						 <label class="blocks-base-control_label">{__('Select the Second Team')}</label>
						 { selectSecondTeam }
						 { recentGames }
					 </div>
				 </InspectorControls>
			 );
 
			 return [
				 controls,
				 <div className={className}>
					 <h2>{__('Sports Bench Rivalry')}</h2>
					 <p>{__('The rivalry block isn\'t editable. You can select the teams and the number of games in the block attributes in the right-hand column.')}</p>
				 </div>
			 ];
		 },
 
		 save() {
			 // Rendering in PHP
			 return null;
		 },
	 }
 );
 