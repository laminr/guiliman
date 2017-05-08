'use strict';

var gulp = require('gulp');
var gulpif = require('gulp-if');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var livereload = require('gulp-livereload');

var config = require('../config');

gulp.task('js', function () {
    return gulp.src(config.scripts.source.web)
        .pipe(concat(config.scripts.concat.web))
        .pipe(gulpif(global.isProd, uglify()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(config.dist.files.js))
        .pipe(livereload());
});
