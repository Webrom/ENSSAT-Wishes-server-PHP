<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Toutes les requêtes dans la table Module se font ici
 */

class modulesmodels extends CI_Model {

    /**
     * Permet d'obtenir tous les modules présents dans la table
     * @return tableau contenant chaque module
     */
    public function getAllModules(){
        $this->db->select("ident,libelle,public");
        $this->db->from ("module");
        $query = $this->db->get();
        return $query->result_array();
    }

    //TODO : je pense que cette fonction devrait être dans le model contenu et non module
    public function addContenuToModule($contenu){
        $query = $this->db->insert('contenu',$contenu);
        if(!$query){
            $ret= array(
                "ErrorMessage" => $this->db->_error_message(),
                "ErrorNumber" => $this->db->_error_message()
            );
        }
        return ($query)?"good":$ret;
    }

    /**
     * Permet d'obtenir tous les identifiants des modules pour un semestre OU une promotion données
     * @param $promOrSemester  String, indique si on veut la requête pour un semestre ou une promo
     * @param $valueSent String, valeur à rechercher
     * @return tableau avec les identifiants des modules
     */
    public function getModuleByPromOrSemester($promOrSemester,$valueSent){
        $this->db->select("ident");
        $this->db->from("module");
        $this->db->where($promOrSemester,$valueSent);
        $query = $this->db->get();
        return $query->result_array();
    }


    /**Permet de supprimer plusieurs un ou plusieurs modules.
     * Commence par supprimer tous les contenus associés au module, puis supprime le module
     * @param $modules String, nom du module à supprimer
     */
    public function deleteModuleContenu($modules){
        foreach($modules as $module){
            $this->db->where('module',$module);
            $this->db->delete('contenu');
            $this->db->where('ident',$module);
            $this->db->delete('module');
        }
    }


    /**
     * Permet de créer un module
     * @param $module String, nom du module à ajouter
     * @return array|string, résultat de la requête
     */
    public function addModule($module){
        $query = $this->db->insert('module',$module);
        if(!$query){
            $ret= array(
                "ErrorMessage" => $this->db->_error_message(),
                "ErrorNumber" => $this->db->_error_message()
            );
        }
        return ($query)?"good":$ret;
    }
}