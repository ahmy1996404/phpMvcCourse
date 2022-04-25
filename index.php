<?php
require __DIR__ . '/vendor/System/Application.php';
require __DIR__ . '/vendor/System/File.php';

use System\File;
use System\Application;

$file = new File(__DIR__);

$app = new Application($file);
use App\Controllers\Users\Users;
new Users;
