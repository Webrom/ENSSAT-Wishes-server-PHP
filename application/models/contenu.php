<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 27/05/15
 * Time: 17:14
 */

class Contenu extends CI_Model{

    public function getAllModuleTypes(){
        $this->db->select("type");
        $this->db->distinct();
        $this->db->from("contenu");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getModuleTeacher($data){
        $this->db->select("*");
        $this->db->from("contenu");
        $this->db->where("module",$data['module']);
        $this->db->where("enseignant",$data['teacher']);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getModuleByModule($data){
        $this->db->select("*");
        $this->db->from("contenu");
        $this->db->where("module",$data['module']);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getModuleByTeacher($data){
        $this->db->select("*");
        $this->db->from("contenu");
        $this->db->where("enseignant",$data['teacher']);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getHeuresPrises(){
        $this->db->SELECT ("hed");
        $this->db->from ("contenu");
        $this->db->where("enseignant",$this->session->userdata('username'));
        $query =  $this->db->get();
        $heures = 0;
        if ($query->num_rows>0) {
            $result = $query->result_array();
            foreach ($result as $heure) {
                $heures = $heures + $heure['hed'];
            }
        }
        return $heures;
    }

    public function getHeurePourUnContenu($module,$partie){
        $this->db->select('hed');
        $this->db->from('contenu');
        $this->db->where('module',$module);
        $this->db->where('partie',$partie);
        $query = $this->db->get();
        return $query->row()->hed;
    }

    public function addEnseignanttoContenu($module,$partie){
        $data = array(
            'enseignant' => $this->session->userdata('username')
        );
        //$this->db->set('enseignant',$this->session->userdata('username'));
        $this->db->where('module',$module);
        $this->db->where('partie',$partie);
        $query = $this->db->update('contenu',$data);
        return $query;
    }


    /**
     * Permet de savoir un contenu existe
     * @param $module
     * @param $partie
     * @return bool vrai si le module existe, faux sinon
     */
    public function ifContenuExist($module,$partie){
        $this->db->select('*');
        $this->db->from('contenu');
        $this->db->where('module',$module);
        $this->db->where('partie',$partie);
        $query = $this->db->get();
        if ($query->num_rows<1){
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Permet de savoir si un contenu a déjà un prof d'attribué
     * @param $module
     * @param $partie
     * @return bool
     */
    public function ifThereIsTeacher($module,$partie){
        $this->db->select('enseignant');
        $this->db->from('contenu');
        $this->db->where('module',$module);
        $this->db->where('partie',$partie);
        $query = $this->db->get();
        if ($query->row()->enseignant==null){
            return false;
        }
        else{
            return true;
        }
    }
}