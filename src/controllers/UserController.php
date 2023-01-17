<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class UserController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function settings()
    {
        $this->isAuthorized();
        $this->render('settings');
    }

    public function user()
    {
        $id_user = $this->isAuthorized();
        try {
            $user = $this->userRepository->getUser('id_user', $id_user);
            $username = $user->getUsername();
            $role = $user->getRole();
            header('Content-type: application/json');
            http_response_code(200);
            echo json_encode(array("loggedIn" => true, "username" => $username, "role" => $role));
        } catch (Exception $exception) {
            http_response_code(404);
        }
    }

    public function changeUsername()
    {
        $this->isAuthorized();
        if (!$this->isPost()) {
            return $this->render('settings');
        }

        return $this->render('settings', ['info' => ['Zmiana nazwy']]);
    }

    public function changePassword()
    {
        $this->isAuthorized();
        if (!$this->isPost()) {
            return $this->render('settings');
        }

        return $this->render('settings', ['info' => ['Zmiana hasła']]);
    }

    public function deleteUser()
    {
        $this->isAuthorized();
        if (!$this->isPost()) {
            return $this->render('settings');
        }

        return $this->render('settings', ['info' => ['Usuwanie']]);
    }

}