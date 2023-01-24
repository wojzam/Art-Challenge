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
        $this->render('join-challenge');
    }

    public function ongoingChallenges()
    {
        $id_user = $this->isAuthorized();

        header('Content-type: application/json');
        http_response_code(200);

        echo json_encode($this->challengeRepository->getOngoingChallenges($id_user));
    }

    public function explore()
    {
        $challenges = $this->challengeRepository->getCompletedChallenges();
        $this->render('explore', ['challenges' => $challenges]);
    }
}
