'use strict';

var gulp = require('gulp');
var runSequence = require('run-sequence');

var launch = function() {
	var sequence = ['js', 'css-web', 'css-admin'];

	if (!global.isProd) {
		sequence.push('watch');
	}
	runSequence(sequence);
};

gulp.task('dev', function (cb) {

	cb = cb || function () {};
	global.isProd = false;
	launch();
});

gulp.task('prod', function (cb) {

	cb = cb || function () {};
	global.isProd = true;

	launch();
});