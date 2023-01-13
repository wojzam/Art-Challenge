<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Entry.php';

class EntryRepository extends Repository
{
    public function getEntry(int $id): ?Entry
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM entry WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $entry = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$entry) {
            return null;
        }

        return new Entry(
            $entry['title'], //TODO Entry doesn't have title
            $entry['image']
        );
    }

    public function addEntry(Entry $entry): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO entry (id_owner, id_challenge, image)
            VALUES (?, ?, ?)
        ');

        //TODO you should get this value from logged user session
        $id_owner = 1;
        $id_challenge = 1;

        $stmt->execute([
            $id_owner,
            $id_challenge,
            $entry->getImage()
        ]);
    }

    public function getEntries(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM entry JOIN challenge c on c.id = entry.id_challenge;
        ');
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($entries as $entry) {
            $result[] = new Entry(
                $entry['topic'],
                $entry['image']
            );
        }

        return $result;
    }
}