<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');

Router::get('logout', 'SecurityController');
Router::post('login', 'SecurityController');
Router::post('signup', 'SecurityController');

Router::get('joinChallenge', 'ChallengeController');
Router::get('explore', 'ChallengeController');
Router::post('search', 'ChallengeController');

Router::get('userCollection', 'EntryController');
Router::post('uploadEntry', 'EntryController');

Router::get('settings', 'UserController');
Router::post('changeUsername', 'UserController');
Router::post('changePassword', 'UserController');
Router::post('deleteUser', 'UserController');

Router::get('adminDashboard', 'AdminController');

Router::run($path);