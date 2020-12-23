const gulp = require('gulp'),
      gulpRename = require('gulp-rename'),
      gulpSass = require('gulp-sass'),
      gulpSassGlob = require('gulp-sass-glob');

const tasks = {
  watch: function(done) {
    //sass
    gulp.watch('./src/sass/**/*.scss', { events: 'change' }, tasks.sass );

    done();
  },

  sass: function() {
    return (
      gulp.src('./src/sass/index.scss')
          .pipe( gulpSassGlob() )
          .pipe(
            gulpSass({ outputStyle: 'expanded' }).on('error', gulpSass.logError)
          )
          .pipe( gulpRename('style.css') )
          .pipe( gulp.dest('./dist/css') )
    );
  },
};

//リソースからファイルを出力
exports.default = gulp.parallel( tasks.sass );

//監視
exports.watch = tasks.watch;