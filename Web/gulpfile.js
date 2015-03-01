var gulp 			= require('gulp'),
	concat 			= require('gulp-concat'),
	sass 			= require('gulp-sass'),
	autoprefixer	= require('gulp-autoprefixer'),
	plumber			= require('gulp-plumber'),
	minifyCss		= require('gulp-minify-css'),
	sourceMap		= require('gulp-sourcemaps'),
	imageMin		= require('gulp-imagemin'),
	clean			= require('gulp-clean'),
	uglify			= require('gulp-uglify');

var path = {
	scss	: 'assets/scss/',
	css		: 'assets/css/',
	images	: 'assets/images/',
	js		: 'assets/js/src/'
};

/*
 * Clean folder CSS
 */
gulp.task('cleanCss', function () {
	return gulp.src(path.css, {read: false})
		.pipe(clean());
});

/*
 * Compile Scss and concat/minify
 */
gulp.task('scss', function () {
	return gulp.src(path.scss+'/**/main.scss')
		.pipe(plumber())
		.pipe(sass())
		.pipe(autoprefixer())
		.pipe(concat('style.css'))
		.pipe(gulp.dest(path.css))
		.pipe(sourceMap.init())
		.pipe(minifyCss({keepSpecialComments: 0}))
		.pipe(concat('style.min.css'))
		.pipe(sourceMap.write())
		.pipe(gulp.dest(path.css));
});

gulp.task('scssadmin', function () {
    return gulp.src(path.scss+'/**/admin.scss')
        .pipe(plumber())
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(concat('admin.css'))
        .pipe(gulp.dest(path.css))
        .pipe(sourceMap.init())
        .pipe(minifyCss({keepSpecialComments: 0}))
        .pipe(concat('admin.min.css'))
        .pipe(sourceMap.write())
        .pipe(gulp.dest(path.css));
});

/*
 * Minify JS
 */
gulp.task('javascripts', function() {
	return gulp.src(path.js+'**/*')
		.pipe(uglify())
		.pipe(gulp.dest('assets/js/app'));
});

/*
 * Optim all images
 */
gulp.task('images', function () {
	return gulp.src(path.images+'/**/*')
		.pipe(imageMin())
		.pipe(gulp.dest(path.images));
})

/*
 * Watch Files
 */
gulp.task('watch',['scss', 'scssadmin'], function() {
	gulp.watch(path.scss+'/**/*', ['scss']);
	gulp.watch(path.scss+'/**/*', ['scssadmin']);
	gulp.watch(path.js+'/**/*', ['javascripts']);
});

/*
 * Default task (just gulp)
 */
gulp.task('default', ['scss', 'watch', 'scssadmin']);