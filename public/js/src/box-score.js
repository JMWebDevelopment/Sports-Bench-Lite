class BoxScoreTabController {
	constructor(container) {
		this.container = document.querySelector(container);
		this.tablist = this.container.querySelector('[role=tablist]');
		this.tabs = this.container.querySelectorAll('[role=tab]');
		this.tabpanels = this.container.querySelectorAll('[role=tabpanel]');
		this.activeTab = this.container.querySelector('[role=tab][aria-selected=true]');
		console.log(this.activeTab);

		this._addEventListeners();
	}

	// Private function to set event listeners
	_addEventListeners() {
		for ( let tab of this.tabs ) {
			tab.addEventListener('click', e => {
				e.preventDefault();
				this.setActiveTab(tab.getAttribute('aria-controls'));
			} );
			tab.addEventListener('keyup', e => {
				if (e.keyCode == 13 || e.keyCode == 32) { // return or space
				e.preventDefault();
				this.setActiveTab(tab.getAttribute('aria-controls'));
				}
			} )
		}
		this.tablist.addEventListener('keyup', e => {
			switch (e.keyCode) {
				case 35: // end key
					e.preventDefault();
					this.setActiveTab(this.tabs[this.tabs.length - 1].getAttribute('aria-controls'));
					break;
				case 36: // home key
					e.preventDefault();
					this.setActiveTab(this.tabs[0].getAttribute('aria-controls'));
					break;
				case 37: // left arrow
					e.preventDefault();
					let previous = [...this.tabs].indexOf(this.activeTab) - 1;
					previous = previous >= 0 ? previous : this.tabs.length - 1;
					this.setActiveTab(this.tabs[previous].getAttribute('aria-controls'));
					break;
				case 39: // right arrow
					e.preventDefault();
					let next = [...this.tabs].indexOf(this.activeTab) + 1;
					next = next < this.tabs.length ? next : 0
					this.setActiveTab(this.tabs[next].getAttribute('aria-controls'));
					break;
			}
		})
	}

	// Public function to set the tab by id
	// This can be called by the developer too.
	setActiveTab(id) {
		for (let tab of this.tabs) {
		if (tab.getAttribute('aria-controls') == id) {
			tab.setAttribute('aria-selected', "true");
			tab.focus();
			this.activeTab = tab;
		} else {
			tab.setAttribute('aria-selected', "false");
		}
		}
		for (let tabpanel of this.tabpanels) {
		if (tabpanel.getAttribute('id') == id) {
			tabpanel.setAttribute('aria-expanded', "true");
		} else {
			tabpanel.setAttribute('aria-expanded', "false");
		}
		}
	}
	}

const boxScoreTabController = new BoxScoreTabController( '#box-score-events' );


jQuery( function( $ ) {

	let getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
		}
		return false;
	};

	let eventIds = [];

	const game_id = getUrlParameter( 'game_id' );

	window.setInterval( getGameEvents, 60000 );

	$( '.game-events:not(.runs-scored) .event-id' ).each( function () {
		let eventID = $( this ).text();
		eventIds.push( eventID );
	} );

	function getGameEvents() {
		$.post( {
			url: sbboxscore.url,
			data: {
				nonce: sbboxscore.nonce,
				action: 'sports_bench_box_score_ajax',
				game_id: game_id,
				event_ids: eventIds,
			},
			success: function ( response ) {
				eventIds = response.data[1];
				if ( response.data[0].length > 0 ) {
					$(response.data[0]).insertBefore( '.game-events tbody tr:first' ).fadeIn('fast');
				}

				if ( 'baseball' === sbboxscore.sport && response.data[2].length > 0 ) {
					$(response.data[2]).insertBefore( '.game-events.runs-scored tbody tr:first' ).fadeIn('fast');
				}
			},
			fail: function ( response ) {
				console.log( response );
			}
		});
	}

} );
