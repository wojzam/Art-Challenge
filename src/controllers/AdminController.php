<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class AdminController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function adminDashboard()
    {
        $users = $this->userRepository->getUsers();
        $this->render('admin-dashboard', ['users' => $users]);
    }

}