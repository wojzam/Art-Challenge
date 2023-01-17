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

    public function getExpiredChallengesTypes(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare("
            SELECT * FROM challenges_expired;
        ");
        $stmt->execute();
        $challenges = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($challenges as $challenge) {
            $result[] = $challenge['id_type'];
        }

        return $result;
    }

    public function startReadyChallengeOfType(int $type)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT start_ready_challenge(:type);
        ');
        $stmt->bindParam(':type', $type);
        $stmt->execute();
    }

    public function endAllFinishedChallenges()
    {
        $stmt = $this->database->connect()->prepare('
            SELECT end_finished_challenges();
        ');
        $stmt->execute();
    }
}