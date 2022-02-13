/**
 * Block dependencies
 */
 import icon from '../icon';
 import SelectBracket from '../select-bracket';
 //import './style.scss';
 import './editor.scss';
 
 /**
  * Internal block libraries
  */
 const { __ } = wp.i18n;
 const {
	 registerBlockType,
	 blockEditRender,
	 Spinner,
 } = wp.blocks;
 const {
	 InspectorControls
 } = wp.editor;
 
 //this is where block control componants go! a-ha!
 //const { ToggleControl, SelectControl } = InspectorControls;
 
 registerBlockType(
	 'sportsbench/bracket', {
		 title: 'Sports Bench Bracket',
		 icon: icon,
		 category: 'sports-bench-blocks',
		 keywords: [ __( 'Sports' ), __( 'Bench' ), __( 'bracket' ) ],
 
		 attributes: {
			 getTeam: {
				 type: 'boolean',
				 default: true,
			 },
			 hasTeam: {
				 type: 'boolean',
				 default: false,
			 },
			 bracket_id: {
				 type: 'int',
			 },
			 bracket_string: {
				 type: 'string',
			 },
			 brackets: {
				 type: 'array',
			 }
		 },
 
		 edit( { attributes, setAttributes, focus, setFocus, className } ) {
			 const { getTeam, hasTeam, bracket_id, bracket_string, brackets } = attributes;
 
			 function onSelectBracket( option ){
				 console.log('change team');
				 if( option === null ){
					 console.log(null);
					 onSelectBracket().then( function( options ) {
						 console.log(options);
						 setAttributes({
							 bracket_id: "",
							 bracket_string: "",
							 getTeam: false,
							 brackets: options
						 });
					 });
				 } else {
					 console.log('There is an option');
					 getBrackets().then( function( options ) {
						 console.log(options);
						 setAttributes({
							 bracket_id: option.value,
							 bracket_string: option.label,
							 getTeam: true,
							 brackets: options
						 });
					 });
				 }
			 }
 
			 function getBrackets(){
				 var url = '/wp-json/sportsbench/brackets/';
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
							 return {value: opt.bracket_id, label: opt.bracket_title}
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
 
			 var selectBracketValue = { value: bracket_id, label: bracket_string }
			 const selectBracket = (
				 <SelectBracket
					 onChange={ onSelectBracket }
					 restUrl="/wp-json/sportsbench/brackets/?bracket_title="
					 initial_value={ selectBracketValue }
					 nonce={ sportsbench_globals.nonce }
				 />
			 );
 
			 return [
				 <InspectorControls key="inspector">
					 <div class="blocks-base-control">
						 <label class="blocks-base-control_label">Select a Bracket</label>
						 { selectBracket }
					 </div>
				 </InspectorControls>,
				 <div className={className}>
					 <h2>{__('Sports Bench Bracket')}</h2>
					 <p>{__('The bracket block isn\'t editable. You can see what it looks like on the front end.')}</p>
				 </div>
			 ];
		 },
 
		 save() {
			 // Rendering in PHP
			 return null;
		 },
	 }
 );
 