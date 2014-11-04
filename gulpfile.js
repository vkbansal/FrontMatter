var path = require('path'),
    gulp = require('gulp'),
    phpunit = require('gulp-phpunit'),
    phpspec = require('gulp-phpspec'),
    notify = require('gulp-notify'),
    test = null,
    notice = {
        phpspec:{
            pass:{
                title: "PHPSpec",
                message: "All specs passed!"
            },
            fail:{
                title: "PHPSpec",
                message: "One or more specs failed!"
            },
        },
        phpunit:{
            pass:{
                title: "PHPUnit",
                message: "All tests passed!"
            },
            fail:{
                title: "PHPUnit",
                message: "One or more tests failed!"
            },
        }
    };



function notifyText(test, status){
    var obj = notice[test][status];
    obj.icon = path.join(process.cwd(), 'node_modules', 'gulp-'+ test, 'assets', 'test-' + status +'.png');
    return obj;
}

function handleErrors(){
    args = Array.prototype.slice.call(arguments);
    notify.onError(notifyText(test,'fail')).apply(this, args);
    this.emit('end');
}

gulp.task('default', ['phpspec', 'phpunit', 'watch']);

gulp.task('watch', function(){
    return gulp.watch('**/*.php', ['phpspec', 'phpunit']);
});

gulp.task('phpspec', function(){
    test = 'phpspec';
    return gulp.src('phpspec.yml.dist')
        .pipe(phpspec('', {notify: true, debug:true}))
        .on('error', handleErrors)
        .pipe(notify(notifyText(test, 'pass')));
});

gulp.task('phpunit', function(){
    test = 'phpunit';
    return gulp.src('phpunit.xml.dist')
        .pipe(phpunit('', {notify: true, debug:true}))
        .on('error', handleErrors)
        .pipe(notify(notifyText(test, 'pass')));
});

gulp.task('test', ['phpspec', 'phpunit']);
