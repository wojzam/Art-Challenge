<?php

require_once 'AppController.php';

class DefaultController extends AppController
{

    public function index()
    {
        $this->render('home');
    }


    public function joinChallenge()
    {
        $this->render('join-challenge');
    }

    public function settings()
    {
        $this->render('settings');
    }
}