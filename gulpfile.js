const gulp = require('gulp');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const groupmq = require('gulp-group-css-media-queries');
const sassLint = require('gulp-sass-lint');
const eslint = require('gulp-eslint');
const bs = require('browser-sync');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const bourbon = require('bourbon').includePaths;
const uglifyes = require('uglify-es');
const composer = require('gulp-uglify/composer');
const uglify = composer(uglifyes, console);

const SASS_SOURCES = [
  './*.scss',
  'assets/css/sass/**/*.scss'
];

const JS_SOURCES = [
  'assets/js/*.js'
];

/**
 * Lint Sass
 */
gulp.task('lint:sass', () => {
  return gulp.src(SASS_SOURCES, { allowEmpty: true })
    .pipe(sassLint({
      'rules':{
        'nesting-depth': 0,
        'no-css-comments': 0
      }
    }))
    .pipe(plumber())
    .pipe(sassLint.format())
});

/**
 * Lint JS
 */
gulp.task('lint:js', () => {
  return gulp.src(JS_SOURCES)
    .pipe(eslint({
        rules: {
          camelcase: 1
        },
        globals: [
          'jQuery',
          '$'
        ],
        envs: [
          'es6',
          'browser'
        ]
    }))
    .pipe(eslint.formatEach('compact', process.stderr))
});

/**
 * Compile Sass files
 */
gulp.task('compile:sass', gulp.series('lint:sass', () => {
  return gulp.src(SASS_SOURCES, { base: './' })
    .pipe(plumber()) // Prevent termination on error
    .pipe(sass({
      indentType: 'tab',
      indentWidth: 1,
      includePaths: ['node_modules/susy/sass'].concat(bourbon),
      outputStyle: 'expanded', // Expanded so that our CSS is readable
    })).on('error', sass.logError)
    .pipe(postcss([
      autoprefixer({
        overrideBrowserslist: ['last 2 versions'],
        cascade: false,
      })
    ]))
    .pipe(groupmq()) // Group media queries!
    .pipe(gulp.dest('.')) // Output compiled files in the same dir as Sass sources
    .pipe(bs.stream())
})); // Stream to browserSync

/**
 * Compile JS files
 */
gulp.task('compile:js', function () {
  return gulp.src(JS_SOURCES)
    .pipe(concat('scripts.js'))
    .pipe(gulp.dest('./'))
    .pipe(rename( {
      basename: "scripts",
      suffix: '.min'
    }))
    .pipe(uglify())
    .pipe(gulp.dest('./'))
});

/**
 * Start up browserSync and watch Sass files for changes
 */
gulp.task('watch', gulp.series('compile:sass', () => {
  bs.init({
    proxy: 'http://127.0.0.1:8080',
    port: 5000
  });

  gulp.watch(SASS_SOURCES, gulp.series(['compile:sass', 'lint:sass']));
  gulp.watch(JS_SOURCES, gulp.series(['compile:js', 'lint:js']));
}));

/**
 * Default task executed by running `gulp`
 */
gulp.task('default', gulp.series('watch'));
