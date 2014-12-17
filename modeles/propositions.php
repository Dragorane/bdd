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
        if ((is_numeric($iduti)) && (is_numeric($idutiv)) && (is_float(floatval($prix)))) {
            $query = "INSERT INTO Proposition VALUES (Proposition_seq.nextval,:adr_v,TO_DATE(:date_v, 'dd/mm/yyyy'),:prix_v,:id_v,:idv_v) RETURNING id INTO :idprop";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition" . oci_error($conn));
            //formatage des variables et sécurité
            $adr_verif = stripslashes(htmlspecialchars($adr));
            $prix_verif = stripslashes(htmlspecialchars($prix));
            $iduti_verif = stripslashes(htmlspecialchars($iduti));
            $idutiv_verif = stripslashes(htmlspecialchars($idutiv));
            oci_bind_by_name($stmt, ":adr_v", $adr_verif);
            oci_bind_by_name($stmt, ":date_v", $date);
            oci_bind_by_name($stmt, ":prix_v", $prix);
            oci_bind_by_name($stmt, ":id_v", $iduti);
            oci_bind_by_name($stmt, ":idv_v", $idutiv);
            oci_bind_by_name($stmt, ":idprop", $id);
            oci_execute($stmt);
            return new propositions($id, $adr_verif, $date, $prix, $iduti, $idutiv);
        } else {
            return null;
        }
    }

    public function ajout_bien_proposition($bien) {
        $query = "INSERT INTO proposition_biens VALUES (:idprop_v,:idbien_v)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition_bien" . oci_error($conn));
        oci_bind_by_name($stmt, ":idprop_v", $this->_id);
        oci_bind_by_name($stmt, ":idbien_v", $bien->get_id());
        oci_execute($stmt);
    }

}

?>