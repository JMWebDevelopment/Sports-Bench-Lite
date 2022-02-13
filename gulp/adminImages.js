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
export default function adminImages(done) {
    pump([
        src(paths.adminImages.src),
        gulpPlugins.newer(paths.adminImages.dest),
        gulpPlugins.imagemin(),
        dest(paths.adminImages.dest),
    ], done);
}