<?php

Route::get('/', function()
{
    $allNamespaces = get_namespaces();
    $allClasses = get_namespaced_classes();

    Debugbar::info($allClasses);
    Debugbar::info($allNamespaces);

    $bean = R::dispense('test');
    $bean->title =  "this is a test";

    return View::make('index')->with(array('test_bean' => $bean));
});

Route::get('/test', function() {
    return app_path();
});
Route::get('/cwd', function() {
    return getcwd();
});

Route::get('/phpinfo', function() {
    Debugbar::disable();
    phpinfo();
});

Route::get('/nukedb', function() {
    R::nuke();

    return 'Database nuked';
});

Route::get('/class_exists/{name}', function($name) {
    return array('class_name' => $name, 'exists?' => class_exists($name));
});

Route::get('/get_classes', function() {
    return get_declared_classes();
});