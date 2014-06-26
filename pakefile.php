<?php
pake_desc('see README.md');
pake_task('default');
function run_default(){
    pake_echo('see README.md');
}

pake_desc('Setup html library');
pake_task('html_setup');
function run_html_setup(){
    pake_echo('run "bower install" and update public/vendor.');
    pake_remove_dir('bower_components');
    pake_sh('bower install');

    pake_remove_dir('public/vendor');
    pake_mkdirs('public/vendor');

    pake_mirror(pakeFinder::type('any')->name('*'), 'bower_components/codemirror/lib', 'public/vendor/codemirror');
    pake_mirror(pakeFinder::type('any')->name('php.js'), 'bower_components/codemirror/mode/php', 'public/vendor/codemirror');
    pake_mirror(pakeFinder::type('any')->name('htmlmixed.js'), 'bower_components/codemirror/mode/htmlmixed', 'public/vendor/codemirror');
    pake_mirror(pakeFinder::type('any')->name('xml.js'), 'bower_components/codemirror/mode/xml', 'public/vendor/codemirror');
    pake_mirror(pakeFinder::type('any')->name('javascript.js'), 'bower_components/codemirror/mode/javascript', 'public/vendor/codemirror');
    pake_mirror(pakeFinder::type('any')->name('css.js'), 'bower_components/codemirror/mode/css', 'public/vendor/codemirror');
    pake_mirror(pakeFinder::type('any')->name('clike.js'), 'bower_components/codemirror/mode/clike', 'public/vendor/codemirror');
    pake_mirror(pakeFinder::type('any')->name('matchbrackets.js'), 'bower_components/codemirror/addon/edit', 'public/vendor/codemirror');
    pake_mirror(pakeFinder::type('any')->name('*'), 'bower_components/bootstrap/dist', 'public/vendor/bootstrap');
    pake_mirror(pakeFinder::type('any')->name('jquery.min.*'), 'bower_components/jquery/dist', 'public/vendor/jquery');
}
