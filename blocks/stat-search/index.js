/**
 * Block dependencies
 */
 import icon from '../icon';
 //import './style.scss';
 
 /**
  * Internal block libraries
  */
 const { __ } = wp.i18n;
 const { registerBlockType } = wp.blocks;
 
 registerBlockType(
	 'sportsbench/stat-search', {
		 title: __('Sports Bench Stat Search'),
		 icon: icon,
		 category: 'sports-bench-blocks',
		 keywords: [ __( 'Sports' ), __( 'Bench' ), __( 'stats' ) ],
 
		 edit: props => {
		 return (
			 <div className={props.className}>
				 <h2>{__('Sports Bench Stat Search')}</h2>
				 <p>{__('The stat search block isn\'t editable. You can see what it looks like on the front end.')}</p>
			 </div>
		 );
		 },
 
		 save() {
			 // Rendering in PHP
			 return null;
		 },
	 }
 );
 