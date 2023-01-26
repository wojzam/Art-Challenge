<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Entry.php';
require_once __DIR__ . '/../models/Challenge.php';

class EntryRepository extends Repository
{
    public function addEntry(Entry $entry): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO entry (id_owner, id_challenge, image)
            VALUES (?, ?, ?)
        ');

        $stmt->execute([
            $entry->getIdOwner(),
            $entry->getIdChallenge(),
            $entry->getImage()
        ]);
    }

    public function getConflictingEntryImage(Entry $entry): ?string
    {
        $id_owner = $entry->getIdOwner();
        $id_challenge = $entry->getIdChallenge();
        $stmt = $this->database->connect()->prepare('
            SELECT entry.image FROM entry WHERE id_owner = :id_owner AND id_challenge = :id_challenge
        ');
        $stmt->bindParam(':id_owner', $id_owner, PDO::PARAM_INT);
        $stmt->bindParam(':id_challenge', $id_challenge, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function deleteConflictingEntries(Entry $entry): void
    {
        $id_owner = $entry->getIdOwner();
        $id_challenge = $entry->getIdChallenge();
        $stmt = $this->database->connect()->prepare('
            DELETE FROM entry WHERE id_owner = :id_owner AND id_challenge = :id_challenge;
        ');
        $stmt->bindParam(':id_owner', $id_owner, PDO::PARAM_INT);
        $stmt->bindParam(':id_challenge', $id_challenge, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getUserEntries(int $id_user): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM entry JOIN challenge c on c.id_challenge = entry.id_challenge
                     WHERE entry.id_owner = :id
                     ORDER BY c.start_date DESC;
        ');
        $stmt->bindParam(':id', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($entries as $entry) {
            $result[] = new Entry(
                $entry['id_challenge'],
                $entry['id_owner'],
                $entry['topic'],
                $entry['image']
            );
        }

        return $result;
    }
}