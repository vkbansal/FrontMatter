var gulp = require('gulp'),
    phpspec = require('gulp-phpspec'),
    notify = require('gulp-notify');

gulp.task('default', ['watch']);

gulp.task('watch', function(){
    gulp.watch('**/*.php', ['test']);
});

gulp.task('test', function(){
    return gulp.src('phpspec.yml.dist')
        .pipe(phpspec('', {notify: true, debug:true}))
        .on('error', function(){
            args = Array.prototype.slice.call(arguments);
            notify.onError({
                title: "Tests Failed",
                message : "One or more test have failed!",
                icon:    __dirname + '/node_modules/gulp-phpspec/assets/test-fail.png'
            }).apply(this, args);
            this.emit('end');
        })
        .pipe(notify({
            title: "Tests passed",
            message : "All tests passed!",
            icon:    __dirname + '/node_modules/gulp-phpspec/assets/test-pass.png'
        }));
});