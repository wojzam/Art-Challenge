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

    public function search()
    {
//        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
//
//        if ($contentType === "application/json") {
//            $content = trim(file_get_contents("php://input"));
//            $decoded = json_decode($content, true);
//
//            header('Content-type: application/json');
//            http_response_code(200);
//
//            echo json_encode($this->challengeRepository->getChallengesByTopic($decoded['search']));
//        }
    }
}
