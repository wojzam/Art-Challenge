<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Entry.php';
require_once __DIR__ . '/../repository/EntryRepository.php';
require_once __DIR__ . '/../repository/ChallengeRepository.php';

class EntryController extends AppController
{
    const MAX_FILE_SIZE = 1920 * 1920;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/img/';

    private $message = [];
    private $entryRepository;
    private $challengeRepository;

    public function __construct()
    {
        parent::__construct();
        $this->entryRepository = new EntryRepository();
        $this->challengeRepository = new ChallengeRepository();
    }

    public function explore()
    {
        $challenges = $this->challengeRepository->getChallenges();
        $this->render('explore', ['challenges' => $challenges]);
    }

    public function userCollection()
    {
        $id_user = $this->isAuthorized();
        $entries = $this->entryRepository->getUserEntries($id_user);
        $this->render('user-collection', ['entries' => $entries]);
    }

    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->challengeRepository->getChallengesByTopic($decoded['search']));
        }
    }

    public function uploadEntry()
    {
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $random_file_name = 'uploads/' . uniqid() . '.' . $file_extension;
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $random_file_name
            );
            //TODO Title should be set
            $entry = new Entry("title", $random_file_name);
            $this->entryRepository->addEntry($entry);

            return $this->render('join-challenge', ['info' => ['File successfully uploaded']]);
        }
        return $this->render('join-challenge', ['error' => $this->message]);
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported';
            return false;
        }
        return true;
    }
}
