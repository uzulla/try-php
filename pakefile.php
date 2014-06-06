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

    pake_mirror(pakeFinder::type('any')->name('*'), 'bower_components/ace-builds/src-min', 'public/vendor/ace');
    pake_mirror(pakeFinder::type('any')->name('*'), 'bower_components/bootstrap/dist', 'public/vendor/bootstrap');
    pake_mirror(pakeFinder::type('any')->name('jquery.min.*'), 'bower_components/jquery/dist', 'public/vendor/jquery');
}
