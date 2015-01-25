//npm install gulp-XXX --save-dev
var gulp = require('gulp'), 
	useref = require('gulp-useref'),
	filter = require('gulp-filter'),
	uglify = require('gulp-uglify'),
    minifyCss = require('gulp-minify-css'),
	plumber = require('gulp-plumber'),
	autoprefixer = require('gulp-autoprefixer'),
	sass = require('gulp-sass');


gulp.task('scss', function () {
    return gulp.src('scss/*.scss')
    	.pipe(plumber())
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gulp.dest('css'));
});

gulp.task('default', ['scss'], function () {
});

gulp.task('watch',['scss'], function() {
    gulp.watch('scss/*.scss', ['scss']);
});