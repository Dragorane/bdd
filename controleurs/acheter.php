<?php

//require_once 'modeles/.php';

class Controller_acheter {

    public function __construct() {
        
    }

    /* Page index */

    public function index() {
        include 'vues/acheter/index.php';
    }
    public function acheterbien() {
        include 'vues/acheter/acheterbien.php';
    }
    public function acheterservice() {
        include 'vues/acheter/acheterservice.php';
    }

}
