const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const postcss = require('gulp-postcss');
const rename = require('gulp-rename');
const terser = require('gulp-terser');
const gulpIf = require('gulp-if');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');

const isProduction = process.env.NODE_ENV === 'production';

const paths = {
    styles: {
        src: 'resources/scss/app.scss',
        dest: 'public/build/css',
    },
    scripts: {
        src: 'resources/js/app.js',
        dest: 'public/build/js',
    },
};

function styles() {
    return gulp
        .src(paths.styles.src, { sourcemaps: !isProduction })
        .pipe(gulpIf(!isProduction, sourcemaps.init()))
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(postcss(isProduction ? [autoprefixer(), cssnano()] : [autoprefixer()]))
        .pipe(rename('app.css'))
        .pipe(gulpIf(!isProduction, sourcemaps.write('.')))
        .pipe(gulp.dest(paths.styles.dest));
}

function scripts() {
    return gulp
        .src(paths.scripts.src, { sourcemaps: !isProduction })
        .pipe(gulpIf(isProduction, terser()))
        .pipe(rename('app.js'))
        .pipe(gulp.dest(paths.scripts.dest));
}

function watchFiles() {
    gulp.watch('resources/scss/**/*.scss', styles);
    gulp.watch('resources/js/**/*.js', scripts);
}

const build = gulp.series(gulp.parallel(styles, scripts));

exports.styles = styles;
exports.scripts = scripts;
exports.build = build;
exports.watch = gulp.series(build, watchFiles);
exports.default = build;
