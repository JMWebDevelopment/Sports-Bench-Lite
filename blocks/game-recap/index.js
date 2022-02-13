/**
 * Block dependencies
 */
 import icon from '../icon';
 import SelectSeason from '../select-season';
 import SelectGame from '../select-game';
 //import './style.scss';
 import './editor.scss';
 import React from 'react';
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
	 'sportsbench/game-recap', {
		 title: __('Sports Bench Game Recap'),
		 icon: icon,
		 category: 'sports-bench-blocks',
		 keywords: [ __( 'Sports' ), __( 'Bench' ), __( 'game' ) ],
 
		 attributes: {
			 getSeason: {
				 type: 'boolean',
				 default: true,
			 },
			 hasSeason: {
				 type: 'boolean',
				 default: false,
			 },
			 game_season: {
				 type: 'string',
			 },
			 game_season_label: {
				 type: 'string',
				 default: 'Select a Season'
			 },
			 season: {
				 type: 'array',
			 },
			 games: {
				 type: 'array',
			 },
			 game_id: {
				 type: 'int',
			 },
			 game_label: {
				 type: 'string',
				 default: ''
			 },
		 },
 
		 edit( { attributes, setAttributes, focus, setFocus, className } ) {
			 const { getSeason, hasSeason, game_season, season, teams, games, game_id, players, game_season_label, game_label } = attributes;
 
			 function onSelectSeason( option ){
				 if( option === null ){
					 getSeasons().then( function( options ) {
						 setAttributes({
							 game_season: "",
							 game_season_label: "Select a Season",
							 getTeam: false,
							 seasons: options
						 });
					 });
					 getGames().then( function( options ) {
						 setAttributes({
							 games: options
						 });
					 });
				 } else {
					 getSeasons().then( function( options ) {
						 setAttributes({
							 game_season: option.value,
							 game_season_label: option.label,
							 getTeam: true,
							 seasons: options
						 });
					 });
					 getGames( option.value ).then( function( options ) {
						 setAttributes({
							 games: options
						 });
					 });
				 }
			 }
 
			 function getSeasons(){
				 var url = '/wp-json/sportsbench/games/?game_season=true';
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
							 if ( opt === 'Select a Season' ) {
								 return {value: '', label: opt}
							 } else {
								 return {value: opt, label: opt}
							 }
						 })
						 return options;
					 })
					 .catch(function(e) {
						 console.log(e);
					 });
 
			 }
 
			 function onSelectGame( option ){
				 if( option === null ){
					 getGames( season ).then( function( options ) {
						 setAttributes({
							 game_id: "",
							 game_label: "",
							 getTeam: false,
							 games: options
						 });
					 });
				 } else {
					 getGames( season ).then( function( options ) {
						 setAttributes({
							 game_id: option.value,
							 game_label: option.label,
							 getTeam: true,
							 games: options
						 });
					 });
				 }
			 }
 
			 function getGames( season ){
				 if ( season === null || season === undefined ) {
					 var teamUrl = '';
				 } else {
					 var teamUrl = '?game_season=' + season;
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
							 return {value: opt.game_id, label: opt.game_date + ': ' + opt.game_away_team + ' at ' + opt.game_home_team}
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
 
			 var selectSeasonValue = { value: game_season, label: game_season_label };
			 const selectSeason = (
				 <SelectSeason
					 onChange={ onSelectSeason }
					 restUrl="/wp-json/sportsbench/games?seasons=true"
					 initial_value={ selectSeasonValue }
					 nonce={ sportsbench_globals.nonce }
				 />
			 );
 
			 var selectGameValue = { value: game_season, label: game_label };
			 const selectGame = (
				 <Select
					 onChange={ onSelectGame }
					 value={ game_id }
					 nonce={ sportsbench_globals.nonce }
					 options={ games }
				 />
			 );
 
			 const controls = (
				 <InspectorControls key="inspector">
					 <div class="blocks-base-control">
						 <label class="blocks-base-control_label">{__('Select a Season')}</label>
						 { selectSeason }
						 <label class="blocks-base-control_label">{__('Select a Game')}</label>
						 { selectGame }
					 </div>
				 </InspectorControls>
			 );
 
			 return [
				 controls,
				 <div className={className}>
					 <h2>{__('Sports Bench Game Recap')}</h2>
					 <p>{__('The game recap block isn\'t editable. You can select the game in the block attributes in the right-hand column of the editor.')}</p>
				 </div>
			 ];
		 },
 
		 save() {
			 // Rendering in PHP
			 return null;
		 },
	 }
 );
 