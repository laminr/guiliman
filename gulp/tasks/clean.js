'use strict';

var config = require('../config');
var gulp = require('gulp');
var del = require('del');

gulp.task('clean-css-web', function (cb) {
	del([config.styles.concat.web], cb);
});

gulp.task('clean-css-admin', function (cb) {
	del([config.styles.concat.admin], cb);
});

gulp.task('clean-js', function (cb) {
	del([config.scripts.concat.web], cb);
});
