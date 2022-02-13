/**
 * Block dependencies
 */
 import icon from '../icon';
 import SelectTeam from '../select-team';
 import SelectPlayer from '../select-player';
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
	 'sportsbench/player', {
		 title: __('Sports Bench Player'),
		 icon: icon,
		 category: 'sports-bench-blocks',
		 keywords: [ __( 'Sports' ), __( 'Bench' ), __( 'player' ) ],
 
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
			 teams: {
				 type: 'array',
			 },
			 player_id: {
				 type: 'int',
			 },
			 player_string: {
				 type: 'string',
			 },
			 players: {
				 type: 'array',
			 }
		 },
 
		 edit( { attributes, setAttributes, focus, setFocus, className } ) {
			 const { getTeam, hasTeam, team_id, team_string, teams, player_id, player_string, players } = attributes;
 
			 function onSelectTeam( option ){
				 console.log('change team');
				 if( option === null ){
					 getTeams().then( function( options ) {
						 setAttributes({
							 team_id: "",
							 team_string: "",
							 getTeam: false,
							 teams: options
						 });
					 });
					 getPlayers().then( function( options ) {
						 setAttributes({
							 players: options
						 });
					 });
				 } else {
					 getTeams().then( function( options ) {
						 setAttributes({
							 team_id: option.value,
							 team_string: option.label,
							 getTeam: true,
							 teams: options
						 });
						 getPlayers( option.value ).then( function( options ) {
							 console.log(options);
							 setAttributes({
								 players: options
							 });
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
						 console.log(json);
						 var options = json.map( function(opt, i){
							 return {value: opt.team_id, label: opt.team_name}
						 })
						 options.push( {value: 0, label: 'Free Agents'} );
						 return options;
					 })
					 .catch(function(e) {
						 console.log(e);
					 });
 
			 }
 
			 function onSelectPlayer( option ){
				 if( option === null ){
					 console.log('no player');
					 getPlayers( team_id ).then( function( options ) {
						 setAttributes({
							 player_id: "",
							 player_string: "",
							 getTeam: false,
							 players: options
						 });
					 });
				 } else {
					 getPlayers( team_id ).then( function( options ) {
						 setAttributes({
							 player_id: option.value,
							 player_string: option.label,
							 getTeam: true,
							 players: options
						 });
						 console.log( player_id );
					 });
				 }
			 }
 
			 function getPlayers( team ){
				 if ( team === null ) {
					 var teamUrl = '';
				 } else {
					 var teamUrl = '?team_id=' + team;
				 }
				 var url = sportsbench_globals.rest_url + 'sportsbench/players/' + teamUrl;
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
							 return {value: opt.player_id, label: opt.player_first_name + ' ' + opt.player_last_name}
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
 
			 var selectTeamValue = { value: team_id, label: team_string }
			 const selectTeam = (
				 <SelectTeam
					 onChange={ onSelectTeam }
					 restUrl="/wp-json/sportsbench/teams/?team_name="
					 initial_value={ selectTeamValue }
					 nonce={ sportsbench_globals.nonce }
				 />
			 );
 
			 var selectPlayerValue = { value: player_id, label: player_string };
			 const selectPlayer = (
				 <Select
					 onChange={ onSelectPlayer }
					 value={player_id}
					 //initial_value={ selectPlayerValue }
					 nonce={ sportsbench_globals.nonce }
					 options={ players }
				 />
			 );
 
			 const controls = (
				 <InspectorControls key="inspector">
					 <div class="blocks-base-control">
						 <label class="blocks-base-control_label">{__('Select a Team')}</label>
						 { selectTeam }
						 <label class="blocks-base-control_label">{__('Select a Player')}</label>
						 { selectPlayer }
					 </div>
				 </InspectorControls>
			 );
 
			 return [
				 controls,
				 <div className={className}>
					 <h2>{__('Sports Bench Player')}</h2>
					 <p>{__('The player block isn\'t editable. You can select the player to show in the block attributes in the right-hand column of the editor.')}</p>
				 </div>
			 ];
		 },
 
		 save() {
			 // Rendering in PHP
			 return null;
		 },
	 }
 );
 