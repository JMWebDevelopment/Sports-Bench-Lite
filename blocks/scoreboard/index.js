/**
 * Internal dependencies
 */
import icon from '../icon';

/**
  * Internal block libraries
*/
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType(
	'sportsbench/scoreboard', {
		title: __( 'Sports Bench Scoreboard' ),
		icon: icon,
		category: 'sports-bench-blocks',
		keywords: [ __( 'Sports' ), __( 'Bench' ), __( 'scoreboard' ) ],

		edit: props => {
			return (
				<div className={props.className}>
					<h2>{__('Sports Bench Scoreboard')}</h2>
					<p>{__('The scoreboard block isn\'t editable. You can see what it looks like on the front end.')}</p>
				</div>
			);
		},

		save() {
			// Rendering in PHP
			return null;
		},
	}
);
