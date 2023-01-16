<?php

require_once __DIR__ . '/../repository/ChallengeRepository.php';

class ChallengeController extends EntryController
{
    private $challengeRepository;

    public function __construct()
    {
        parent::__construct();
        $this->challengeRepository = new ChallengeRepository();
    }

    public function joinChallenge()
    {
        $this->isAuthorized();
        $challenges = $this->challengeRepository->getCurrentChallenges();
        $this->render('join-challenge', ['challenges' => $challenges]);
    }

    public function explore()
    {
        $challenges = $this->challengeRepository->getCompletedChallenges();
        $this->render('explore', ['challenges' => $challenges]);
    }
}
