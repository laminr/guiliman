'use strict';

var config = require('../config');
var gulp = require('gulp');
var zip = require('gulp-zip');


gulp.task('zip', function () {
	return gulp.src(config.dist.files + '/**/*')
		.pipe(zip(config.dist.zipFile))
		.pipe(gulp.dest(config.dist.zipDir));
});
