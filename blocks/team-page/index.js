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
	 'sportsbench/team-page', {
		 title: __('Sports Bench Team Page'),
		 icon: icon,
		 category: 'sports-bench-blocks',
		 keywords: [ __( 'Sports' ), __( 'Bench' ), __( 'team' ) ],
 
		 edit: props => {
		 return (
			 <div className={props.className}>
				 <h2>{__('Sports Bench Team Page')}</h2>
				 <p>{__('The team page block isn\'t editable. You can see what it looks like on the front end.')}</p>
			 </div>
		 );
		 },
 
		 save() {
			 // Rendering in PHP
			 return null;
		 },
	 }
 );
 