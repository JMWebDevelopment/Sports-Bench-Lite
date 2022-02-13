/* eslint-env es6 */
'use strict';

/**
 * External dependencies
 */
import {src, dest} from 'gulp';
import pump from 'pump';

/**
 * Internal dependencies
 */
import {paths, gulpPlugins} from './constants';

/**
 * Optimize images.
 */
export default function publicImages(done) {
    pump([
        src(paths.publicImages.src),
        gulpPlugins.newer(paths.publicImages.dest),
        gulpPlugins.imagemin(),
        dest(paths.publicImages.dest),
    ], done);
}