<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Entry.php';
require_once __DIR__ . '/../repository/EntryRepository.php';

class EntryController extends AppController
{
    const MAX_FILE_SIZE = 1920 * 1920;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/img/';
    protected $entryRepository;
    private $message = 'Unknown error';

    public function __construct()
    {
        parent::__construct();
        $this->entryRepository = new EntryRepository();
    }

    public function userCollection()
    {
        $id_user = $this->isAuthorized();
        $entries = $this->entryRepository->getUserEntries($id_user);
        $this->render('user-collection', ['entries' => $entries]);
    }

    public function uploadEntry()
    {
        $id_user = $this->isAuthorized();
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $random_file_name = 'uploads/' . uniqid() . '.' . $file_extension;
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $random_file_name
            );
            //TODO Title should be set
            $entry = new Entry(7, $id_user, "title", $random_file_name);
            $this->deleteConflictingEntries($entry);
            $this->entryRepository->addEntry($entry);

            return $this->render('join-challenge', ['info' => ['File successfully uploaded']]);
        }
        return $this->render('join-challenge', ['error' => [$this->message]]);
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message = 'File is too large for destination file system';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message = 'File type is not supported';
            return false;
        }
        return true;
    }

    private function deleteConflictingEntries(Entry $entry): void
    {
        $image = $this->entryRepository->getConflictingEntryImage($entry);
        $file = dirname(__DIR__) . self::UPLOAD_DIRECTORY . $image;
        if (file_exists($file)) {
            unlink($file);
        }
        $this->entryRepository->deleteConflictingEntries($entry);
    }
}
