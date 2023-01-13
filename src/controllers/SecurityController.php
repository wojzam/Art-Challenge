<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController
{

    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        // $user = $this->userRepository->getUser($email);

        session_start();
        $_SESSION['logged_in'] = true;
        setcookie('session_id', session_id(), time() + 86400);
        setcookie('username', $email, time() + 86400);
//
//        if (!$user) {
//            return $this->render('login', ['error' => ['User not found!']]);
//        }
//
//        if ($user->getEmail() !== $email) {
//            return $this->render('login', ['error' => ['User with this email not exist!']]);
//        }
//
//        if ($user->getPassword() !== $password) {
//            return $this->render('login', ['error' => ['Wrong password!']]);
//        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/userCollection");
    }

    public function signup()
    {
        if (!$this->isPost()) {
            return $this->render('signup');
        }

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordRepeated = $_POST['passwordRepeated'];

        if ($password !== $passwordRepeated) {
            return $this->render('signup', ['error' => ['Passwords do not match']]);
        }

        $user = new User($username, $email, password_hash($password, PASSWORD_BCRYPT), 1);

        $this->userRepository->addUser($user);

        return $this->render('signup', ['info' => ['You\'ve been succesfully registrated!']]);
    }

    public function logout()
    {
        //session_destroy();
        unset($_SESSION['logged_in']);
        setcookie('session_id', '', time() - 3600);
        setcookie('username', '', time() - 3600);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}");
    }
}