<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Entry.php';
require_once __DIR__ . '/../models/Challenge.php';

class ChallengeRepository extends Repository
{
    public function getCompletedChallenges(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare("
            SELECT * FROM challenge JOIN challenge_status s on s.id_status = challenge.id_status
                     WHERE s.name = 'completed'
                     ORDER BY challenge.start_date DESC;
        ");
        $stmt->execute();
        $challenges = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($challenges as $challenge) {
            $stmt = $this->database->connect()->prepare("
                SELECT * FROM entry WHERE id_challenge = {$challenge['id_challenge']}
            ");
            $stmt->execute();
            $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $result2 = [];

            foreach ($entries as $entry) {
                $result2[] = new Entry(
                    $entry['id_challenge'],
                    $entry['id_owner'],
                    $challenge['topic'],
                    $entry['image']
                );
            }

            $result[] = new Challenge(
                $challenge['topic'],
                $result2
            );
        }

        return $result;
    }

    public function getChallengesByTopic(string $topic): array
    {
        $result = [];

        $searchString = '%' . strtolower($topic) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM challenge WHERE LOWER(topic) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();
        $challenges = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($challenges as $challenge) {
            $stmt = $this->database->connect()->prepare('
                SELECT * FROM entry WHERE id_challenge = :id
            ');
            $stmt->bindParam(':id', $challenge['id_challenge'], PDO::PARAM_INT);
            $stmt->execute();
            $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $result2 = [];

            foreach ($entries as $entry) {
                $result2[] = new Entry(
                    $entry['id_challenge'],
                    $entry['id_owner'],
                    $challenge['topic'],
                    $entry['image']
                );
            }

            $result[] = new Challenge(
                $challenge['topic'],
                $result2
            );
        }

        return $result;
    }

    public function getCurrentChallenges(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare("
            SELECT * FROM challenge JOIN challenge_status s on s.id_status = challenge.id_status WHERE s.name = 'ongoing';
        ");
        $stmt->execute();
        $challenges = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($challenges as $challenge) {
            $result[] = new Challenge(
                $challenge['topic'],
                []
            );
        }

        return $result;
    }
}