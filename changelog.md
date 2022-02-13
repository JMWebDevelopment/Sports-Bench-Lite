# Changelog

All of the changes for Sports Bench are stored here.

## [2.1.1] - January 18, 2022
- Fixed the sports_bench_add_action function.
- Fixed the styling with the dashboard widgets.
- Added in the edit game, player and team links to the admin bar.

## [2.1.0] - December 13, 2021
- Added in a team history feature for team pages.
- Added in play-by-play for soccer games.

## [2.0.3] - October 19, 2021
- Added in delete_game function for the games screen.
- Added a min-width of 0px for scoreboard buttons to keep themes from messing up the styling.
- Hid the SQL date for the scoreboard page and widget.

## [2.0.2] - September 23, 2021
- Fixed issue with the updater.

## [2.0.1] - September 15, 2021
- Added an admin notice to enter in the license key if it hasn't already been done.

## [2.0] - September 14, 2021
- Rebuilt using an object oriented programming paradigm.
- Updated the design of the different admin screens the plugin creates and uses.
- Added in easier customization of the add/edit team, player and game screens.
- Updated the classes for teams, players, games, brackets and series.
- Added in classes for scoreboard, standings and stats.
- Added in sport-specific classes that can be used.
- Updated the JavaScript files to load in the footer.
- Accessibility fixes.

## [1.9.2] - December 7, 2020
- Fixed issue with team logos and team and player photos not being able to uploaded.

## [1.9.1] - October 20, 2020
- Fixed issue with the games admin page not being loaded.

## [1.9] - August 2, 2020
- Added a box score function, block, shortcode and option (for a page to host the box scores).
- Added a player bio field and displays it on the player's page.
- Created filters to change the name of conference and division titles.
- Added the ability to have custom files for the admin screen files through a theme's directory.
- Tested with WordPress 5.5

## [1.8] - January 5, 2020
- A11y fix: Added alt text for team logo and photo.
- Added batting and pitching order for baseball.
- Added team and player taxonomies for posts.
- Tested with WordPress 5.3.2.

## [1.7.2] - December 28, 2018
- Added a Polish translation.
- Fixed issue with rivalry block not showing the series score or recent games.
- Added check with has_blocks when loading scripts and styles for blocks.
- Fixed issue with player, game and game recap blocks' select dropdowns not working correctly.

## [1.7.1] - December 9, 2018
- Tested to work with WordPress 5.0 and Gutenberg.

## [1.7] - September 6, 2018
- Added team stats for team page.
- Added team and season filters for stat search.

## [1.6] - July 19, 2018
- Added the ability to export league data as a CSV.
- Added the ability to search for player stats on the front and back end of the website.
- Added the ability to list basketball referees for games.
- Fixed errors in Gutenberg blocks.
- Fixed issue with shortcodes not having the correct amount of arguments for certain filters.

## [1.5.2] - April 4, 2018
- Fixed error when trying to load Gutenberg blocks without the Gutenberg plugin.

## [1.5.1] - April 3, 2018
- Added Gutenberg blocks for brackets, games, game recaps, list division, players, player pages, stats, scoreboard, standings, team, team pages and team schedules.

## [1.5] - March 7, 2018
- Redesigned the admin elements in order to make it look up to today's web design standards.
- Removed default font styling to make the plugin match the current theme better.
- Added option to use the Josefin Sans font in the front-facing elements of the plugin.
- Added the ability to create a stylesheet in your theme that will override any Sports Bench styling.
- Made sure abbreviation guides were added if wanted.
- Other smaller fixes to make Sports Bench the best it can be.

## [1.4] - December 6, 2017
- Added support for rugby and volleyball.
- Added links to opposing teams from the team schedule.
- Hid game time if it's set to midnight. This helps for games with a TBA or TBD game time.
- Added a shortcode to list teams by division or conference.
- Added support for neutral site games.
- Added the ability to include a Google Map with game previews.
- Added an options endpoint for Sports Bench options.
- Added the ability to display a link to a page in the scoreboard, standings and stats widgets.
- Changed row class from "row" to "sports-bench-row" to eliminate conflicts with Bootstrap.
- Added a team schedule widget.
- Added the ability to add, create, update and delete items for brackets, divisions, games, game events, game stats, players, playoff series and teams with the WP REST API.
- Other fixes to make Sports Bench better.
- Tested with WordPress 4.9.

## [1.3] - September 6, 2017
- Changed some AJAX functions to use the WP REST API.
- Added rivalry, team page, player page and game recap shortcodes.
- Added Sports Bench Options page and removed the options from the Customizer.
- Added a CSV import function.

## [1.2.3] - August 3, 2017
- Fixed issue with date picker not showing up on add/edit player page.

## [1.2.2] - August 3, 2017
- Fixed issue with players not saving.
- Fixed issue with games not saving because of difference in initial sport in 'Add Game' and the database.

## [1.2.1] - June 21, 2017
- Added better functionality for WP REST API routes, including the ability to group stats by players.
- Fixed strip slashes issue with player's height.

## [1.2] - June 7, 2017
- Fixed error that shows up in the standings widget and standings dashboard widget when there are no teams in the database.
- Fixed issue with keepers not showing up in the right spot in the game recaps.
- Changed the style of the teams adn players admin listing and edit pages to match the style of the games admin pages.
- Added the ability to create playoff brackets.
- Added an active/inactive option for teams.
- Made "Free Agent" a team choice for players.
- Redesigned the games dashboard widget to match the style of the games listing page.
- Added shortcodes to show the scoreboard, standings or stats.
- Fixed other minor issues with the plugin.
- Tested to work with WordPress 4.8.

## [1.1] - January 7, 2017
- Added custom routes to the WP REST API for all tables.
- Added standings and games dashboard widgets.
- Changed the style of the game list page and add/edit game page to make adding game stats much easier.

## [1.0]
- Initial release to the world.
