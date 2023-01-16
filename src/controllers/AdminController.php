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
        $this->isAdmin();
        $users = $this->userRepository->getAllUsers();
        $this->render('admin-dashboard', ['users' => $users]);
    }

    public function isAdmin(): int
    {
        $id_user = $this->isAuthorized();
        if ($this->userRepository->getRole($id_user) !== "admin") {
            http_response_code(401);
            exit;
        }
        return $id_user;
    }

    public function deleteUser()
    {
        $this->isAdmin();
        //TODO POST id_user to delete
        $id_user = 0;
        $this->userRepository->deleteUser($id_user);

        $users = $this->userRepository->getAllUsers();
        $this->render('admin-dashboard', ['users' => $users]);
    }
}