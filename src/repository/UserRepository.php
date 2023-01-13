<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
              SELECT * FROM public.user WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null; //TODO throw exception
        }

        return new User(
            $user['username'],
            $user['email'],
            $user['password'],
            $user['role']
        );
    }

    public function addUser(User $user)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.user (username, email, password, id_role)
            VALUES (?, ?, ?, ?)
        ');

        $stmt->execute([
            $user->getUsername(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getRole()
        ]);
    }

    public function getUsers(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.user;
        ');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            $result[] = new User(
                $user['username'],
                $user['email'],
                $user['password'],
                $user['id_role']
            );
        }

        return $result;
    }
}