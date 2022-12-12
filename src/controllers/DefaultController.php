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

    public function joinChallenge()
    {
        $this->render('join-challenge');
    }
}