<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('userCollection', 'DefaultController');
Router::get('browseArt', 'DefaultController');
Router::get('joinChallenge', 'DefaultController');
Router::get('challenge', 'DefaultController');

Router::get('logout', 'SecurityController');
Router::post('login', 'SecurityController');
Router::post('signup', 'SecurityController');

Router::post('uploadEntry', 'EntryController');

Router::get('settings', 'UserController');
Router::post('changeUsername', 'UserController');
Router::post('changePassword', 'UserController');
Router::post('deleteUser', 'UserController');

Router::run($path);