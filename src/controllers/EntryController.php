<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Entry.php';
require_once __DIR__ . '/../repository/EntryRepository.php';

class EntryController extends AppController
{

    const MAX_FILE_SIZE = 1920 * 1920;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/img/uploads/';

    private $message = [];
    private $entryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->entryRepository = new EntryRepository();
    }

    public function userCollection()
    {
        $entries = $this->entryRepository->getEntries();
        $this->render('user-collection', ['entries' => $entries]);
    }

    public function uploadEntry()
    {
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );

            $entry = new Entry("title", $_FILES['file']['name']);
            $this->entryRepository->addEntry($entry);

            //TODO This could display uploaded image
            return $this->render('challenge', ['info' => ['File successfully uploaded']]);
        }
        //TODO There is a problem with messages
        return $this->render('challenge', ['error' => $this->message]);
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
