( function() {
    tinymce.create( 'tinymce.plugins.sportsbench', {
        init: function( ed, url ) {

            ed.addCommand( 'mcesportsbench', function() {
                ed.windowManager.open( {
// call content via admin-ajax, no need to know the full plugin path
                    file: ajaxurl + '?action=sportsbench_tinymce',
                    width: 500 + ed.getLang('sportsbench.delta_width', 0),
                    height: 210 + ed.getLang('sportsbench.delta_height', 0),
                    inline: 1
                }, {
                    plugin_url: url // Plugin absolute URL
                } );
            } );

            var imageURL = url.replace( '/js', '' );
// Register example button
            ed.addButton( 'sportsbench', {
                title: 'Sports Bench Shortcodes',
                cmd: 'mcesportsbench',
                image: imageURL + '/images/SB-Logo-White.png'
            } );

// Add a node change handler, selects the button in the UI when a image is selected
            ed.onNodeChange.add( function( ed, cm, n ) {
                cm.setActive( 'sportsbench', n.nodeName == 'IMG' );
            } );
        },
        getInfo: function() {
            return {
                longname: 'sportsbench',
                author: 'Jacob Martella',
                authorurl: 'http://www.jacobmartella.com/',
                infourl: 'http://www.jacobmartella.com/wordpress/wordpress-themes/sports-bench',
                version: "1.0"
            };
        }
    } );

// Register plugin
    tinymce.PluginManager.add('sportsbench', tinymce.plugins.sportsbench);
} )();
