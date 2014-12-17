<?php

require_once 'modeles/model_base.php';

class evaluations extends Model_Base {

    private $_idE;
    private $_titre;
    private $_comm;
    private $_note;
    private $_idCrea;
    private $_iduti;
    private $_idserv;
    private $_idbien;

    public function __construct($ide, $titre, $comm, $note, $idcrea, $iduti, $idserv, $idbien) {
        $this->_idE = $ide;
        $this->_titre = $titre;
        $this->_comm = $comm;
        $this->_note = $note;
        $this->_idCrea = $idcrea;
        $this->_iduti = $iduti;
        $this->_idserv = $idserv;
        $this->_idbien = $idbien;
    }

    public function get_titre() {
        return $this->_titre;
    }

    public function get_comm() {
        return $this->_comm;
    }

    public function get_note() {
        return $this->_note;
    }

    public function get_iduti() {
        return $this->_iduti;
    }

    public static function create($titre, $comm, $note, $idcrea, $iduti, $idserv, $idbien) {
        if ((is_numeric($idcrea)) && (is_numeric($note))) {
            if ($iduti != NULL) {
                $query = "INSERT INTO Evaluation (IdEval, titreEval, commEval, note, idUtiCrea, idUtiEva) VALUES (Evaluation_seq.nextval,:titreEval,:commEval,:note,:idUtiCrea,:idUtiEva)";
            } else {
                if ($idbien != NULL) {
                    $query = "INSERT INTO Evaluation (IdEval, titreEval, commEval, note, idUtiCrea, idBien) VALUES (Evaluation_seq.nextval,:titreEval,:commEval,:note,:idUtiCrea,:idBien)";
                } else {
                    $query = "INSERT INTO Evaluation (IdEval, titreEval, commEval, note, idUtiCrea, idServ) VALUES (Evaluation_seq.nextval,:titreEval,:commEval,:note,:idUtiCrea,:idServ)";
                }
            }
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion utilisateur" . oci_error($conn));
//formatage des variables et sécurité
            $titre_verif = stripslashes(htmlspecialchars($titre));
            $comm_verif = stripslashes(htmlspecialchars($comm));
            oci_bind_by_name($stmt, ":titreEval", $titre_verif);
            oci_bind_by_name($stmt, ":commEval", $comm_verif);
            oci_bind_by_name($stmt, ":note", $note);
            oci_bind_by_name($stmt, ":idUtiCrea", $idcrea);
            if ($iduti != NULL) {
                oci_bind_by_name($stmt, ":idUtiEva", $iduti);
            } else {
                if ($idbien != NULL) {
                    oci_bind_by_name($stmt, ":idBien", $idbien);
                } else {
                    oci_bind_by_name($stmt, ":idServ", $idserv);
                }
            }
            oci_execute($stmt);
        } else {
            echo "<div class='warning'><p>Erreur, données corrompues.</p></div>";
        }
    }

    public static function nouvelle_eval_uti($titre, $comm, $note, $idcrea, $iduti) {
        $eval = evaluations::create($titre, $comm, $note, $idcrea, $iduti, NULL, NULL);
    }

    public static function nouvelle_eval_bien($titre, $comm, $note, $idcrea, $idserv) {
        $eval = evaluations::create($titre, $comm, $note, $idcrea, NULL, $idserv, NULL);
    }

    public static function nouvelle_eval_service($titre, $comm, $note, $idcrea, $idbien) {
        $eval = evaluations::create($titre, $comm, $note, $idcrea, NULL, NULL, $idbien);
    }

    public static function moy_eval_uti($pseudo) {
        $uti = Utilisateur::get_by_pseudo($pseudo);
        $moy = 2.5;
        if ($uti != NULL) {
            $query = "select avg(note) as moy from evaluation where idUtiEva=" . $uti->id();
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur moyenne evaluation" . oci_error($conn));
            oci_execute($stmt);
            while ($row = oci_fetch_assoc($stmt)) {
                $moy = $row['MOY'];
            }
        }
        return $moy;
    }

    public static function tabeval_uti($pseudo) {
        $uti = Utilisateur::get_by_pseudo($pseudo);
        $tabeval = null;
        if ($uti != NULL) {
            $query = "select IdEval, titreEval, commEval, note, idUtiCrea, idUtiEva, idServ, idBien from evaluation where idUtiEva=" . $uti->id();
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
            oci_execute($stmt);
            $i = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                $tabeval[$i] = new evaluations($row['IDEVAL'], $row['TITREEVAL'], $row['COMMEVAL'], $row['NOTE'], $row['IDUTICREA'], $row['IDUTIEVA'], $row['IDSERV'], $row['IDBIEN']);
                $i = $i + 1;
            }
            return $tabeval;
        }
    }

    public static function tabeval_bien($id) {
        $bien = biens::get_bien_by_id($id);
        $tabeval = null;
        if ($bien != NULL) {
            $query = "select IdEval, titreEval, commEval, note, idUtiCrea, idUtiEva, idServ, idBien from evaluation where idUtiEva=" . $bien->get_id();
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
            oci_execute($stmt);
            $i = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                $tabeval[$i] = new evaluations($row['IDEVAL'], $row['TITREEVAL'], $row['COMMEVAL'], $row['NOTE'], $row['IDUTICREA'], $row['IDUTIEVA'], $row['IDSERV'], $row['IDBIEN']);
                $i = $i + 1;
            }
            return $tabeval;
        }
    }

    public static function tabeval_service($id) {
        $serv = services::get_serv_by_id($id);
        $tabeval = null;
        if ($bien != NULL) {
            $query = "select IdEval, titreEval, commEval, note, idUtiCrea, idUtiEva, idServ, idBien from evaluation where idUtiEva=" . $serv->get_id();
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
            oci_execute($stmt);
            $i = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                $tabeval[$i] = new evaluations($row['IDEVAL'], $row['TITREEVAL'], $row['COMMEVAL'], $row['NOTE'], $row['IDUTICREA'], $row['IDUTIEVA'], $row['IDSERV'], $row['IDBIEN']);
                $i = $i + 1;
            }
            return $tabeval;
        }
    }

}

?>