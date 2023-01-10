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
        $this->render('settings');
    }

    public function changeUsername()
    {
        if (!$this->isPost()) {
            return $this->render('settings');
        }

        return $this->render('settings', ['messages' => ['Zmiana nazwy']]);
    }

    public function changePassword()
    {
        if (!$this->isPost()) {
            return $this->render('settings');
        }

        return $this->render('settings', ['messages' => ['Zmiana hasła']]);
    }

    public function deleteUser()
    {
        if (!$this->isPost()) {
            return $this->render('settings');
        }

        return $this->render('settings', ['messages' => ['Usuwanie']]);
    }

}