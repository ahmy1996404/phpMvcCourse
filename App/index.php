<?php
// white list routes
use System\Application;

$app = Application::getInstance();

$app->route->add('/', 'Main/Home@index', 'GET');

// /post/my-title-post/42424224
$app->route->add('/posts/:text/:id', 'Post/Post');

$app->route->add('/404', 'Error/NotFound');

$app->route->notFound('/404'); 