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

    public function get_id() {
        return $this->_id;
    }

    public function get_adr() {
        return $this->_adr;
    }

    public function get_date() {
        return $this->_date;
    }

    public function get_prix() {
        return $this->_prix;
    }

    public function get_iduti() {
        return $this->_id_uti;
    }

    public function get_idv() {
        return $this->_id_vendeur;
    }

    public static function get_prop_by_id($id) {
        $prop = null;
        if (is_numeric($id)) {
            $query = "select * from proposition where idPro=:id";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur select proposition" . oci_error($conn));
            oci_bind_by_name($stmt, ":id", $id);
            oci_execute($stmt);
            while ($row = oci_fetch_assoc($stmt)) {
                $prop = new propositions($row['IDPRO'], $row['ADRPROP'], $row['DATEPROP'], $row['PRIXPROP'], $row['IDUTI'], $row['IDUTI_VENDEUR']);
            }
        }
        return $prop;
    }

    public static function create($adr, $date, $prix, $iduti, $idutiv) {
        if ((is_numeric($iduti)) && (is_numeric($idutiv)) && (is_float(floatval($prix)))) {
            $query = "INSERT INTO Proposition VALUES (Proposition_seq.nextval,:adr_v,TO_DATE(:date_v, 'dd/mm/yyyy'),:prix_v,:id_v,:idv_v) RETURNING idPro INTO :idprop";
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

    public function ajout_service_proposition($serv, $date) {
        $query = "INSERT INTO proposition_services VALUES (:idserv_v,:idprop_v,TO_DATE(:date_v, 'dd/mm/yyyy'))";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition_service" . oci_error($conn));
        oci_bind_by_name($stmt, ":idprop_v", $this->_id);
        oci_bind_by_name($stmt, ":idserv_v", $serv->get_id());
        oci_bind_by_name($stmt, ":date_v", $date);
        oci_execute($stmt);
    }

    public static function propostion_vendeur($uti) {
        $query = "select * from proposition where idUti_vendeur=:idv";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition_bien" . oci_error($conn));
        oci_bind_by_name($stmt, ":idv", $uti->id());
        oci_execute($stmt);
        $tabprop = null;
        $i = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $tabprop[$i] = new propositions($row['IDPRO'], $row['ADRPROP'], $row['DATEPROP'], $row['PRIXPROP'], $row['IDUTI'], $row['IDUTI_VENDEUR']);
            $i = $i + 1;
        }
        return $tabprop;
    }

    public static function propostion_acheteur($uti) {
        $query = "select * from proposition where idUti=:id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition_bien" . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $uti->id());
        oci_execute($stmt);
        $tabprop = null;
        $i = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $tabprop[$i] = new propositions($row['IDPRO'], $row['ADRPROP'], $row['DATEPROP'], $row['PRIXPROP'], $row['IDUTI'], $row['IDUTI_VENDEUR']);
            $i = $i + 1;
        }
        return $tabprop;
    }

    public static function proposition_refuse($id) {
        $prop = propositions::get_prop_by_id($id);
        if ($prop == NULL) {
            echo "<div class='warnign'><p>Erreur, la proposition n'a pas été acceptée.</div>";
        } else {
            $archive = propositions::copie_proposition_archive($prop, 0);
            propositions::copie_prop_bien($prop, $archive);
            echo "pif";
            propositions::copie_prop_serv($prop, $archive);
            echo "paf";
            propositions::suppression_proposition($prop);
            echo "pouf";
        }
    }

    public static function proposition_accepte($id) {
        $prop = propositions::get_prop_by_id($id);
        if ($prop == NULL) {
            echo "<div class='warnign'><p>Erreur, la proposition n'a pas été acceptée.</div>";
        } else {
            $archive = propositions::copie_proposition_archive($prop, 1);
            echo "pif";
            propositions::copie_prop_bien($prop, $archive);
            echo "paf";
            propositions::copie_prop_serv($prop, $archive);
            echo "pouf";
            propositions::suppression_proposition($prop);
        }
    }

    public static function copie_proposition_archive($prop, $etat) {
        if (is_numeric($etat)) {
            $query = "INSERT INTO Archive VALUES (Archive_seq.nextval,:adr_v,TO_DATE(:date_v, 'dd/mm/yyyy'),:prix_v,:etat,:id_v,:idv_v) RETURNING idArch INTO :idprop";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition" . oci_error($conn));
            //formatage des variables et sécurité
            oci_bind_by_name($stmt, ":adr_v", $prop->get_adr());
            oci_bind_by_name($stmt, ":date_v", $prop->get_date());
            oci_bind_by_name($stmt, ":prix_v", $prop->get_prix());
            oci_bind_by_name($stmt, ":etat", $etat);
            oci_bind_by_name($stmt, ":id_v", $prop->get_iduti());
            oci_bind_by_name($stmt, ":idv_v", $prop->get_idv());
            oci_bind_by_name($stmt, ":idprop", $id);
            oci_execute($stmt);
            return $id;
        } else {
            return null;
        }
    }

    public static function copie_prop_bien($prop, $arch) {
        $query = "select * from proposition_biens where idPro=:idpro";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition" . oci_error($conn));
        oci_bind_by_name($stmt, ":idpro", $prop->get_id());
        oci_execute($stmt);
        $tabprop = null;
        $i = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $query = "INSERT INTO proposition_biens_archive VALUES (:arch,:bien)";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition" . oci_error($conn));
            //formatage des variables et sécurité
            oci_bind_by_name($stmt, ":arch", $arch);
            oci_bind_by_name($stmt, ":bien", $row['IDBIEN']);
            oci_execute($stmt);
        }
    }

    public static function copie_prop_serv($prop, $arch) {
        $query = "select * from proposition_services where idPro=:idpro";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition" . oci_error($conn));
        oci_bind_by_name($stmt, ":idpro", $prop->get_id());
        oci_execute($stmt);
        $tabprop = null;
        $i = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $query = "INSERT INTO proposition_services_archive VALUES (:arch,:serv)";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition" . oci_error($conn));
            //formatage des variables et sécurité
            oci_bind_by_name($stmt, ":arch", $arch);
            oci_bind_by_name($stmt, ":serv", $row['IDSERV']);
            oci_execute($stmt);
        }
    }

    public static function suppression_proposition($prop) {
        $query = "delete from proposition_services where idPro=:idpro";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition" . oci_error($conn));
        oci_bind_by_name($stmt, ":idpro", $prop->get_id());
        oci_execute($stmt);
        $query = "delete from proposition_biens where idPro=:idpro";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition" . oci_error($conn));
        oci_bind_by_name($stmt, ":idpro", $prop->get_id());
        oci_execute($stmt);
        $query = "delete from proposition where idPro=:idpro";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion proposition" . oci_error($conn));
        oci_bind_by_name($stmt, ":idpro", $prop->get_id());
        oci_execute($stmt);
    }

}

?>