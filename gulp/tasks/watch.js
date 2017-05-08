'use strict';

var gulp = require('gulp');

var config = require('../config');

gulp.task('watch', function () {

	gulp.watch(config.styles.source.web, 	['clean-css-web', 'css-web']);
	gulp.watch(config.styles.source.admin, 	['clean-css-admin', 'css-admin']);

	gulp.watch(config.scripts.source.web,	 ['clean-js', 'js']);

});