<?php

require_once 'modeles/model_base.php';

class propositions extends Model_Base {

    private $_id;
    private $_adr;
    private $_date;
    private $_prix;
    private $_id_uti;
    private $_id_vendeur;

    public function __construct($id, $adr, $date, $prix, $iduti, $idutiv) {
        $this->_id = $id;
        $this->_adr = $adr;
        $this->_date = $date;
        $this->_prix = $prix;
        $this->_id_uti = $iduti;
        $this->_id_vendeur = $idutiv;
    }

    public static function create($adr, $date, $prix, $iduti, $idutiv) {
        $query = "INSERT INTO Proposition VALUES (Categorie_seq.nextval,:adr,:date,:prix,:id,:idv)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        //formatage des variables et sécurité
        $adr_verif = stripslashes(htmlspecialchars($adr));
        $date_verif = stripslashes(htmlspecialchars($date));
        $prix_verif = stripslashes(htmlspecialchars($prix));
        $iduti_verif = stripslashes(htmlspecialchars($iduti));
        $idutiv_verif = stripslashes(htmlspecialchars($idutiv));
        oci_bind_by_name($stmt, ":adr", $adr_verif);
        oci_bind_by_name($stmt, ":date", $date_verif);
        oci_bind_by_name($stmt, ":prix", $prix_verif);
        oci_bind_by_name($stmt, ":id", $iduti_verif);
        oci_bind_by_name($stmt, ":idv", $idutiv_verif);
        oci_execute($stmt);
    }

}

?>