<?php

require_once 'AppController.php';

class DefaultController extends AppController
{

    public function index()
    {
        $this->render('home');
    }

    public function userCollection()
    {
        $this->render('user-collection');
    }

    public function browseArt()
    {
        $this->render('browse-art');
    }

    public function challenge()
    {
        $this->render('challenge');
    }

    public function joinChallenge()
    {
        $this->render('join-challenge');
    }
}