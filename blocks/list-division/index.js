/**
 * Block dependencies
 */
 import icon from '../icon';
 import SelectDivision from '../select-division';
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
	 'sportsbench/list-division', {
		 title: 'Sports Bench List Division',
		 icon: icon,
		 category: 'sports-bench-blocks',
		 keywords: [ __( 'Sports' ), __( 'Bench' ), __( 'division' ) ],
 
		 attributes: {
			 getTeam: {
				 type: 'boolean',
				 default: true,
			 },
			 hasTeam: {
				 type: 'boolean',
				 default: false,
			 },
			 division_id: {
				 type: 'int',
			 },
			 division_name: {
				 type: 'string',
			 },
			 divisions: {
				 type: 'array',
			 }
		 },
 
		 edit( { attributes, setAttributes, focus, setFocus, className } ) {
			 const { getTeam, hasTeam, division_id, division_name, divisions } = attributes;
 
			 function onSelectDivision( option ){
				 console.log('change team');
				 if( option === null ){
					 console.log(null);
					 onSelectDivision().then( function( options ) {
						 console.log(options);
						 setAttributes({
							 division_id: "",
							 division_name: "",
							 getTeam: false,
							 divisions: options
						 });
					 });
				 } else {
					 console.log('There is an option');
					 getDivisions().then( function( options ) {
						 console.log(options);
						 setAttributes({
							 division_id: option.value,
							 division_name: option.label,
							 getTeam: true,
							 divisions: options
						 });
					 });
				 }
			 }
 
			 function getDivisions(){
				 var url = '/wp-json/sportsbench/divisions/';
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
							 return {value: opt.division_id, label: opt.division_name}
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
 
			 var selectDivisionValue = { value: division_id, label: division_name }
			 const SelectDivisionList = (
				 <SelectDivision
					 onChange={ onSelectDivision }
					 restUrl="/wp-json/sportsbench/divisions/?division_name="
					 initial_value={ selectDivisionValue }
					 nonce={ sportsbench_globals.nonce }
				 />
			 );
 
 
			 const controls = (
				 <InspectorControls key="inspector">
					 <div class="blocks-base-control">
						 <label class="blocks-base-control_label">{__('Select a Division/Conference')}</label>
						 { SelectDivisionList }
					 </div>
				 </InspectorControls>
			 );
 
			 return [
				 controls,
				 <div className={className}>
					 <h2>{__('Sports Bench List Teams by Division')}</h2>
					 <p>{__('The list teams by division block isn\'t editable. You can select the division to show in the block attributes in the right-hand column of the editor.')}</p>
				 </div>
			 ];
		 },
 
		 save() {
			 // Rendering in PHP
			 return null;
		 },
	 }
 );
 