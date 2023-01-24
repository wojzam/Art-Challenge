<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{

    public function userExists(string $column, string $value): bool
    {
        try {
            $user = $this->getUser($column, $value);
        } catch (Exception $exception) {
            return false;
        }

        return boolval($user);
    }

    /**
     * @throws Exception
     */
    public function getUser(string $column, string $value): ?User
    {
        $query = 'SELECT * FROM "user" JOIN role r on r.id_role = "user".id_role WHERE ' . $column . ' = :value LIMIT 1';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception("User not found with " . $column . " = " . $value);
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

    public function getRoleID(string $role_name): int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id_role FROM role WHERE name = :name
        ');
        $stmt->bindParam(':name', $role_name);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getRole(int $id_user): string
    {
        $stmt = $this->database->connect()->prepare('
            SELECT r.name FROM "user" JOIN role r on r.id_role = "user".id_role WHERE "user".id_user = :id_user
        ');
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function deleteUser(int $id_user)
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM "user" WHERE id_user = :id;
        ');
        $stmt->bindParam(':id', $id_user);
        $stmt->execute();
    }

    public function getAllUsers(): array
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

}