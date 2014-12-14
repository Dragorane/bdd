<?php

//require_once 'modeles/.php';

class Controller_vendre {

    public function __construct() {
        
    }

    /* Page index */

    public function index() {
        include 'vues/vendre/index.php';
    }

    public function vendrebien() {
        include 'vues/vendre/vendrebien.php';
    }

    public function vendreservice() {
        include 'vues/vendre/vendreservice.php';
    }

}
