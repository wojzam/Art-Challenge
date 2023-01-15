<?php

class Challenge
{
    private $topic;

    private $entries;

    public function __construct($topic, array $entries)
    {
        $this->topic = $topic;
        $this->entries = $entries;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function setTopic($topic): void
    {
        $this->topic = $topic;
    }

    public function getEntries(): array
    {
        return $this->entries;
    }

    public function setEntries(array $entries): void
    {
        $this->entries = $entries;
    }
}