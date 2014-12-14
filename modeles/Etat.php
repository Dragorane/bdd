<?php

require_once 'modeles/model_base.php';

class Etat extends Model_Base {

    private $_id;
    private $_lib;

    public function __construct($id, $lib) {
        $this->_id = $id;
        $this->_lib = $lib;
    }

    public static function create($lib) {
        $query = "INSERT INTO Etat VALUES (Etat_seq.nextval,:lib)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        //formatage des variables et sécurité
        $lib_verif = stripslashes(htmlspecialchars($lib));
        oci_bind_by_name($stmt, ":lib", $lib_verif);
        oci_execute($stmt);
    }

}

?>