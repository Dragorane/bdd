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

    public static function create($titre, $comm, $note, $idcrea, $iduti, $idserv, $idbien) {
        $query = "INSERT INTO Evaluation VALUES (Evaluation_seq.nextval,:titreEval,:commEval,:note,:idUtiCrea,:idUtiEva,:idServ,:idBien)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion utilisateur" . oci_error($conn));
        //formatage des variables et sécurité
        $titre_verif = stripslashes(htmlspecialchars($titre));
        $comm_verif = stripslashes(htmlspecialchars($comm));
        $note_verif = stripslashes(htmlspecialchars($note));
        $idcrea_verif = stripslashes(htmlspecialchars($idcrea));
        $iduti_verif = stripslashes(htmlspecialchars($iduti));
        $idserv_verif = stripslashes(htmlspecialchars($idserv));
        $idbien_verif = stripslashes(htmlspecialchars($idbien));
        oci_bind_by_name($stmt, ":titreEval", $titre_verif);
        oci_bind_by_name($stmt, ":commEval", $comm_verif);
        oci_bind_by_name($stmt, ":note", $note_verif);
        oci_bind_by_name($stmt, ":idUtiCrea", $idcrea_verif);
        oci_bind_by_name($stmt, ":idUtiEva", $iduti_verif);
        oci_bind_by_name($stmt, ":idServ", $idserv_verif);
        oci_bind_by_name($stmt, ":idBien", $idbien_verif);
        oci_execute($stmt);
    }

}

?>