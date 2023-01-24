<?php

class Entry
{
    private $id_challenge;
    private $id_owner;
    private $title;
    private $image;

    public function __construct(int $id_challenge, int $id_owner, string $title, string $image)
    {
        $this->id_challenge = $id_challenge;
        $this->id_owner = $id_owner;
        $this->title = $title;
        $this->image = $image;
    }

    public function getIdChallenge(): int
    {
        return $this->id_challenge;
    }

    public function setIdChallenge(int $id_challenge): void
    {
        $this->id_challenge = $id_challenge;
    }

    public function getIdOwner(): int
    {
        return $this->id_owner;
    }

    public function setIdOwner(int $id_owner): void
    {
        $this->id_owner = $id_owner;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

}