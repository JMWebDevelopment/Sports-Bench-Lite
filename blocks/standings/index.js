/**
 * Block dependencies
 */
 import icon from '../icon';
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
	 'sportsbench/standings', {
		 title: __('Sports Bench Standings'),
		 icon: icon,
		 category: 'sports-bench-blocks',
		 keywords: [ __( 'Sports' ), __( 'Bench' ), __( 'standings' ) ],
 
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
			 standings: {
				 type: 'array'
			 }
		 },
 
		 edit( { attributes, setAttributes, focus, setFocus, className } ) {
			 const { getTeam, hasTeam, team_id, team_string, items, standings } = attributes;
 
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
 
			 function onSelectStandings( option ){
				 if( option === null ){
					 setAttributes({
						 standings: option
					 });
				 } else {
					 setAttributes({
						 standings: option
					 });
				 }
			 }
 
			 function handleFetchErrors( response ) {
				 if (!response.ok) {
					 console.log('fetch error, status: ' + response.statusText);
				 }
				 return response;
			 }
 
			 if ( sportsbench_globals.sport === 'soccer' || sportsbench_globals.sport === 'hockey' ) {
				 var itemOptions = [
					 { value: 'goals-for', label: 'Goals For' },
					 { value: 'goals-against', label: 'Goals Against' },
					 { value: 'goals-differential', label: 'Goal Differential' },
					 { value: 'home-record', label: 'Home Record' },
					 { value: 'away-record', label: 'Away Record' },
					 { value: 'division-record', label: 'Division Record' },
					 { value: 'conference-record', label: 'Conference Record' }
				 ];
			 } else if ( sportsbench_globals.sport === 'baseball' ) {
				 var itemOptions = [
					 { value: 'runs-for', label: 'Runs For' },
					 { value: 'runs-against', label: 'Runs Against' },
					 { value: 'run-differential', label: 'Run Differential' },
					 { value: 'home-record', label: 'Home Record' },
					 { value: 'away-record', label: 'Away Record' },
					 { value: 'division-record', label: 'Division Record' },
					 { value: 'conference-record', label: 'Conference Record' }
				 ];
			 } else {
				 var itemOptions = [
					 { value: 'points-for', label: 'Points For' },
					 { value: 'points-against', label: 'Points Against' },
					 { value: 'points-differential', label: 'Point Differential' },
					 { value: 'home-record', label: 'Home Record' },
					 { value: 'away-record', label: 'Away Record' },
					 { value: 'division-record', label: 'Division Record' },
					 { value: 'conference-record', label: 'Conference Record' }
				 ];
			 }
 
			 var standingsOptions = [
				 { value: 'sports_bench_standings_league', label: 'Combined League Standings' },
				 { value: 'sports_bench_standings_conference', label: 'Conference Standings' },
				 { value: 'sports_bench_standings_division', label: 'Division Standings' }
			 ];
 
			 const selectItems = (
				 <Select
					 onChange={ onSelectItems }
					 options={itemOptions}
					 multi={true}
					 removeSelected={false}
					 value={items}
				 />
			 );
 
			 const selectStandings = (
				 <Select
					 onChange={ onSelectStandings }
					 options={standingsOptions}
					 multi={true}
					 removeSelected={false}
					 value={standings}
				 />
			 );
 
			 const controls = (
				 <InspectorControls key="inspector">
					 <div class="blocks-base-control">
						 <label class="blocks-base-control_label">{__('Select Standings to Show')}</label>
						 { selectStandings }
						 <label class="blocks-base-control_label">{__('Select Standings Items to Show')}</label>
						 { selectItems }
					 </div>
				 </InspectorControls>
			 );
 
			 return [
				 controls,
				 <div className={className}>
					 <h2>{__('Sports Bench Standings')}</h2>
					 <p>{__('The standings  block isn\'t editable. You can select the items to display in the standings in the block attributes in the right-hand column.')}</p>
				 </div>
			 ];
		 },
 
		 save() {
			 // Rendering in PHP
			 return null;
		 },
	 }
 );
 