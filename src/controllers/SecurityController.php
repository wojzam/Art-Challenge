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

        foreach ($_POST as $value) {
            if ($this->isInvalid($value)) {
                return $this->render('login', ['error' => ['Received invalid request!']]);
            }
        }

        $user = $this->userRepository->getUser('email', $email);

        if (!$user) {
            return $this->render('login', ['error' => ['User with this email does not exist!']]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['error' => ['Wrong password!']]);
        }

        $this->sessionRepository->createUserSession($user->getId());

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/joinChallenge");
    }

    private function isInvalid(string $field): bool
    {
        return $field == null || $field == "" || strlen($field) > 64;
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

        foreach ($_POST as $value) {
            if ($this->isInvalid($value)) {
                return $this->render('signup', ['error' => ['Received invalid request!']]);
            }
        }

        if ($this->userRepository->userExists('username', $username)) {
            return $this->render('signup', ['error' => ['User with this username already exists!']]);
        }

        if ($this->userRepository->userExists('email', $email)) {
            return $this->render('signup', ['error' => ['User with this email already exists!']]);
        }

        if ($password !== $passwordRepeated) {
            return $this->render('signup', ['error' => ['Passwords do not match!']]);
        }

        $user = new User(0, $username, $email, password_hash($password, PASSWORD_BCRYPT));

        $this->userRepository->addUser($user);

        return $this->render('signup', ['info' => ['You\'ve been succesfully registrated']]);
    }

    public function logout()
    {
        $this->sessionRepository->endUserSession();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}");
    }
}