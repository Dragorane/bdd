<?php

require_once 'modeles/model_base.php';

class biens extends Model_Base {

    private $_id;
    private $_lib;
    private $_desc;
    private $_prix;
    private $_nbPlaces;
    private $_vendu;
    private $_iduti;
    private $_idcateg;

    public function __construct($id, $lib, $desc, $prix, $nbplaces, $vendu, $iduti, $categ) {
        $this->_id = $id;
        $this->_lib = $lib;
        $this->_desc = $desc;
        $this->_prix = $prix;
        $this->_nbplaces = $nbplaces;
        $this->_vendu = $vendu;
        $this->_iduti = $iduti;
        $this->_idcateg = $categ;
    }

    public static function create($lib, $desc, $prix, $nbplaces, $vendu, $iduti, $categ) {
        $query = "INSERT INTO Biens VALUES (Utilisateurs_seq.nextval,:pseudo,:mdp,:pnom,:nom,:adr,:email,:posix,:posiy,:tel,:photo,0,1)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion utilisateur" . oci_error($conn));
        //formatage des variables et sécurité
        $lib_verif = stripslashes(htmlspecialchars($lib));
        $desc_verif = stripslashes(htmlspecialchars($desc));
        $prix_verif = stripslashes(htmlspecialchars($prix));
        $nbplaces_verif = stripslashes(htmlspecialchars($nbplaces));
        $vendu_verif = stripslashes(htmlspecialchars($vendu));
        $iduti_verif = stripslashes(htmlspecialchars($iduti));
        $categ_verif = stripslashes(htmlspecialchars($categ));
        oci_bind_by_name($stmt, ":lib", $lib_verif);
        oci_bind_by_name($stmt, ":desc", $desc_verif);
        oci_bind_by_name($stmt, "prix", $prix_verif);
        oci_bind_by_name($stmt, ":nblaces", $nbplaces_verif);
        oci_bind_by_name($stmt, ":vendu", $vendu_verif);
        oci_bind_by_name($stmt, ":iduti", $iduti_verif);
        oci_bind_by_name($stmt, ":categ", $categ_verif);
        oci_execute($stmt);
    }

}

?>