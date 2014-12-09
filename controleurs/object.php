<?php

require_once 'modeles/object.php';

class Controller_Object {

    public function __construct() {
        
    }

    public function objet_form() {
        include 'vues/objet_form.php';
    }

    public function objet() {
        $obj = Object::create($_GET['nom'], $_GET['desc'], $_GET['val']);
        include 'vues/objet.php';
    }

    public function objet_id($id) {
        $obj = Object::get_by_id($id);
        include 'vues/un_object.php';
    }

    public function all_object() {
        $array_obj = Object::get_all();
        include 'vues/all_object.php';
    }

}
