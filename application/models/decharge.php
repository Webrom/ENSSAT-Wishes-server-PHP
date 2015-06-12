<?php
/**
 * Toutes les requêtes dans la table Décharge se font ici
 */

class Decharge extends CI_Model{

    /**
     * Permet d'obtenir le nombre d'heure de décharge d'un enseignant
     * @param $enseignant String, le login d'un enseignant
     * @return int, nombre d'heure(s) de décharge
     */
    public function getHoursDecharge($enseignant){
        $this->db->select('decharge');
        $this->db->from('decharge');
        $this->db->where('enseignant',$enseignant);
        $query = $this->db->get();
        if ($query->num_rows==1){
            return $query->row()->decharge;
        }
        else{
            return "0";
        }
    }

    /**
     * Permet de savoir si un enseignant est présent dans la table des décharges
     * @param $user String, login de l'enseignant
     * @return boolean, 0 si il n'est pas présent, 1 sinon
     */
    public function isPresentInTable($user){
        $this->db->select('decharge');
        $this->db->from('decharge');
        $this->db->where('enseignant',$user);
        $query = $this->db->get();
        if ($query->num_rows==1){
            return "1";
        }
        else{
            return "0";
        }
    }

    /**
     * Permet de modifier la décharge d'un enseignant
     * @param $user String, login de l'enseignant
     * @param $decharge int, le nouveau nombre d'heures de décharge
     */
    public function setDecharge($user,$decharge){
        $data = array(
            'decharge' => $decharge
        );
        $this->db->where("enseignant",$user);
        $this->db->update('decharge',$data);
    }

    /**
     * Permet de créer une décharge pour un enseignant
     * @param $enseignant String, login de l'enseignant
     * @param $decharge int, le nouveau nombre d'heures de décharge
     */
    public function addNewDecharge($enseignant,$decharge){
        $data = array(
            'decharge' => $decharge,
            'enseignant' =>$enseignant
        );
        $this->db->insert('decharge', $data);
    }


    /**
     * Permet de supprimer la décharge de un/plusieurs enseignant(s)
     * @param $tableau_enseignants
     */
    public function removeTeachersDecharge($tableau_enseignants){
        foreach($tableau_enseignants as $enseignants){
            $this->db->where('enseignant', $enseignants);
            $this->db->delete('decharge');
        }
    }
}