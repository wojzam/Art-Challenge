<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('joinChallenge', 'DefaultController');
Router::get('settings', 'DefaultController');

Router::get('logout', 'SecurityController');
Router::post('login', 'SecurityController');
Router::post('signup', 'SecurityController');

Router::get('explore', 'EntryController');
Router::post('search', 'EntryController');
Router::get('userCollection', 'EntryController');
Router::post('uploadEntry', 'EntryController');

Router::post('changeUsername', 'UserController');
Router::post('changePassword', 'UserController');
Router::post('deleteUser', 'UserController');

Router::get('adminDashboard', 'AdminController');

Router::run($path);