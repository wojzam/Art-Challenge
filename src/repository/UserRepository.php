<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
              SELECT * FROM "user" JOIN role r on r.id_role = "user".id_role WHERE email = :email;
        ');
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null; //TODO throw exception
        }

        return new User(
            $user['id_user'],
            $user['username'],
            $user['email'],
            $user['password'],
            $user['name']
        );
    }

    public function addUser(User $user)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO "user" (username, email, password, id_role)
            VALUES (?, ?, ?, ?)
        ');

        $stmt->execute([
            $user->getUsername(),
            $user->getEmail(),
            $user->getPassword(),
            $this->getRoleID($user->getRole())
        ]);
    }

    public function getRoleID(string $name): int
    {
        $stmt = $this->database->connect()->prepare(
            'SELECT id FROM role WHERE name = :name
        ');
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getUsers(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM "user" JOIN role r on r.id_role = "user".id_role ORDER BY username;
        ');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            $result[] = new User(
                $user['id_user'],
                $user['username'],
                $user['email'],
                $user['password'],
                $user['name']
            );
        }

        return $result;
    }

    public function userExists(string $column, string $value): bool
    {
        $query = "SELECT * FROM public.user WHERE {$column} = :value";
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();

        return boolval($stmt->fetch(PDO::FETCH_ASSOC));
    }
}