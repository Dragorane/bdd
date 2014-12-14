<?php

//require_once 'modeles/.php';

class Controller_acheter {

    public function __construct() {
        
    }

    /* Page index */

    public function index() {
        include 'vues/principale.php';
    }
    public function acheterbien() {
        include 'vues/acheterbien.php';
    }
    public function acheterservice() {
        include 'vues/acheterservice.php';
    }

}
