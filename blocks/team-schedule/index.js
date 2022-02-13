/**
 * Block dependencies
 */
 import icon from '../icon';
 import SelectSeason from '../select-season';
 import SelectTeam from '../select-team';
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
	 'sportsbench/team-schedule', {
		 title: __('Sports Bench Team Schedule'),
		 icon: icon,
		 category: 'sports-bench-blocks',
		 keywords: [ __( 'Sports' ), __( 'Bench' ), __( 'schedule' ) ],
 
		 attributes: {
			 getSeason: {
				 type: 'boolean',
				 default: true,
			 },
			 hasSeason: {
				 type: 'boolean',
				 default: false,
			 },
			 team_id: {
				 type: 'int',
			 },
			 team_name: {
				 type: 'string',
			 },
			 team_season_label: {
				 type: 'string',
				 default: 'Select a Season'
			 },
			 teams: {
				 type: 'array',
			 },
			 team_seasons: {
				 type: 'array',
			 },
			 team_season: {
				 type: 'string',
				 default: ''
			 },
		 },
 
		 edit( { attributes, setAttributes, focus, setFocus, className } ) {
			 const { getSeason, hasSeason, team_id, team_name, teams, team_seasons, team_season, team_season_label } = attributes;
 
			 function onSelectTeam( option ){
				 if( option === null ){
					 getTeams().then( function( options ) {
						 setAttributes({
							 team_id: "",
							 team_name: "",
							 getTeam: false,
							 teams: options
						 });
					 });
					 getSeasons().then( function( options ) {
						 setAttributes({
							 team_seasons: options
						 });
					 });
				 } else {
					 getTeams().then( function( options ) {
						 setAttributes({
							 team_id: option.value,
							 team_name: option.label,
							 getTeam: true,
							 teams: options
						 });
					 });
					 getSeasons( option.value ).then( function( options ) {
						 setAttributes({
							 team_seasons: options
						 });
					 });
				 }
			 }
 
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
						 var options = json.map( function(opt, i){
							 return {value: opt.team_id, label: opt.team_name}
						 })
						 return options;
					 })
					 .catch(function(e) {
						 console.log(e);
					 });
 
			 }
 
			 function onSelectSeason( option ){
				 if( option === null ){
					 getSeasons( option ).then( function( options ) {
						 setAttributes({
							 team_season: "",
							 getTeam: false,
							 team_seasons: options
						 });
					 });
				 } else {
					 getSeasons( option ).then( function( options ) {
						 setAttributes({
							 team_season: option.value,
							 getTeam: true,
							 team_seasons: options
						 });
					 });
				 }
			 }
 
			 function getSeasons( team ){
				 if ( team === null ) {
					 return { options: [] };
				 } else {
					 var teamUrl = '?seasons=true&team_id=' + team;
				 }
				 var url = '/wp-json/sportsbench/games/' + teamUrl;
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
							 return {value: opt.team_season, label: opt.team_season}
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
 
			 var SelectTeamValue = { value: team_id, label: team_name }
			 const SelectATeam = (
				 <SelectTeam
					 onChange={ onSelectTeam }
					 restUrl="/wp-json/sportsbench/teams"
					 initial_value={ SelectTeamValue }
					 nonce={ sportsbench_globals.nonce }
				 />
			 );
 
			 var selectSeasonValue = { value: team_season, label: team_season };
			 const SelectASeason = (
				 <SelectSeason
					 onChange={ onSelectSeason }
					 restUrl="/wp-json/sportsbench/games?seasons=true"
					 initial_value={ selectSeasonValue }
					 nonce={ sportsbench_globals.nonce }
				 />
			 );
 
			 const controls = (
				 <InspectorControls key="inspector">
					 <div class="blocks-base-control">
						 <label class="blocks-base-control_label">{__('Select a Team')}</label>
						 { SelectATeam }
						 <label class="blocks-base-control_label">{__('Select a Season')}</label>
						 { SelectASeason }
					 </div>
				 </InspectorControls>
			 );
 
			 return [
				 controls,
				 <div className={className}>
					 <h2>{__('Sports Bench Team Schedule')}</h2>
					 <p>{__('The team schedule block isn\'t editable. You can select the team and the season in the block attributes in the right-hand column of the editor.')}</p>
				 </div>
			 ];
		 },
 
		 save() {
			 // Rendering in PHP
			 return null;
		 },
	 }
 );
 