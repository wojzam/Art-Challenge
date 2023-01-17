<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/ChallengeRepository.php';

class AdminController extends AppController
{
    private $userRepository;
    private $challengeRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->challengeRepository = new ChallengeRepository();
    }

    public function admin()
    {
        $this->isAdmin();
        $this->renderDashboard();
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

    private function renderDashboard()
    {
        $users = $this->userRepository->getAllUsers();
        $this->render('admin-dashboard', ['users' => $users]);
    }

    public function deleteUser($id_user)
    {
        $this->isAdmin();
        $this->userRepository->deleteUser($id_user);
        http_response_code(200);
    }

    public function refreshChallenges()
    {
        $this->isAdmin();
        $expiredTypes = $this->challengeRepository->getExpiredChallengesTypes();

        foreach ($expiredTypes as $type) {
            $this->challengeRepository->startReadyChallengeOfType($type);
        }
        $this->challengeRepository->endAllFinishedChallenges();

        $this->renderDashboard();
    }
}