/* eslint-env es6 */
'use strict';

/**
 * External dependencies
 */
import {src, dest} from 'gulp';
import pump from 'pump';
import path from 'path';
import zip from 'gulp-zip';

/**
 * Internal dependencies
 */
import {prodThemePath, gulpPlugins} from './constants';
import {getThemeConfig} from './utils';

/**
 * Create the zip file
 */
export default function zipPlugin(done) {

    return pump(
        [
            src(
				[
					'**/*',
					'!node_modules/**',
					'!bin/**',
					'!.babelrc',
					'!.vscode/*',
					'!package.json',
					'!package-lock.json',
					'!webpack.config.js',
					'!.git-lab/*',
					'!.browserlistrc',
					'!.editorconfig',
					'!eslintignore',
					'!.gitignore',
					'!.travis.yml',
					'!composer.json',
					'!composer.lock',
					'!gulpfile.babel.js',
					'!phpcs.xml.dist',
					'!phpunit.xml.dist',
					'!config/**',
					'!gulp/**',
					'!tests/**',
					'!vendor/**',
					'!admin/css/src/**',
					'!admin/js/src/**',
					'!public/css/src/**',
					'!public/js/src/**',
					'!blocks/box-score/**',
					'!blocks/brackets/**',
					'!blocks/game/**',
					'!blocks/game-recap/**',
					'!blocks/list-division/**',
					'!blocks/player/**',
					'!blocks/player-page/**',
					'!blocks/rivalry/**',
					'!blocks/scoreboard/**',
					'!blocks/standings/**',
					'!blocks/stat-search/**',
					'!blocks/stats/**',
					'!blocks/team/**',
					'!blocks/team-page/**',
					'!blocks/team-schedule/**',
					'!blocks/icon.js',
					'!blocks/index.js',
					'!blocks/input.js',
					'!blocks/select-bracket.js',
					'!blocks/select-division.js',
					'!blocks/select-game.js',
					'!blocks/select-player.js',
					'!blocks/select-season.js',
					'!blocks/select-team.js',
				]
			),
            zip(`sports-bench.zip`),
            dest('./')
        ],
		done
	);
}
