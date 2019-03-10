<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    // $router->get('/Video/index', 'VideoController@index');
    // $router->get('/Video/list', 'VideoController@video_list');
    // $router->get('/Video/list/{id}/edit', 'VideoController@edit');
    // $router->any('/Video/list/{id}', 'VideoController@video_edit');
    $router->resource('videos', VideoController::class);
    $router->resource('articles', ArticleController::class);

});
