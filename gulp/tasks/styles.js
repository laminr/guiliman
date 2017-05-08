var gulp = require('gulp');
var gulpif = require('gulp-if');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var livereload = require('gulp-livereload');
const autoprefixer = require('gulp-autoprefixer');

var config = require('../config');

var processCss = function(configWatch, configConcat) {
    return gulp.src(configWatch)
        .pipe(sourcemaps.init())
        .pipe(gulpif(/[.]scss/, sass()))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(concat(configConcat))
        .pipe(gulpif(global.isProd, uglifycss()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(config.dist.files.css))
        .pipe(livereload());
};

gulp.task('css-web', function () {
    return processCss(config.styles.source.web, config.styles.concat.web);
});

gulp.task('css-admin', function () {
    return processCss(config.styles.source.admin, config.styles.concat.admin);
});
