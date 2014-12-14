<?php

require_once 'modeles/model_base.php';

class categories extends Model_Base {

    private $_id;
    private $_lib;
    private $_type;
    private $_cat_pere;

    public function __construct($id, $lib, $type, $cat_pere) {
        $this->_id = $id;
        $this->_lib = $lib;
        $this->_type = $type;
        $this->_cat_pere = $cat_pere;
    }

    public static function create($lib, $type, $cat_pere) {
        $query = "INSERT INTO Categorie VALUES (Categorie_seq.nextval,:lib,:type,:catpere)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        //formatage des variables et sécurité
        $lib_verif = stripslashes(htmlspecialchars($lib));
        $type_verif = stripslashes(htmlspecialchars($type));
        $cat_pere_verif = stripslashes(htmlspecialchars($cat_pere));
        oci_bind_by_name($stmt, ":lib", $lib_verif);
        oci_bind_by_name($stmt, ":type", $type_verif);
        oci_bind_by_name($stmt, ":catpere", $cat_pere_verif);
        oci_execute($stmt);
    }
    
    public static function initcat(){
        create("Informatique Logiciels",1 , null);
        create("PC fixe",1 , 2);
        create("PC portable",1 , 2);
        create("Ecrans",1 , 2);
        create("Claviers",1 , 2);
        create("Souris",1 , 2);
        create("Enceintes",1 , 2);
        create("Mémoires / RAM",1 , 2);
    }

}

?>