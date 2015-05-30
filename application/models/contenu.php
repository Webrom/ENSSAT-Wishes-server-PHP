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

    public function getTypeContenu(){
        $this->db->select('partie');
        $this->db->from('contenu');
        $this->db->where('module',$this->input->get('gData'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getModuleContenus(){
        $this->db->select('*');
        $this->db->from("contenu");
        $this->db->where('module',$this->input->get('gData'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getModuleContenusByPartieModule(){
        $array = array(
            "partie" => $this->input->get('gData'),
            "module" => $this->input->get('bData')
        );
        $this->db->select('*');
        $this->db->from("contenu");
        $this->db->where($array);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function modifyModuleContenu($data,$keys){
        $where = 'module = "'.$keys['module'].'" AND partie = "'.$keys['partie'].'"';
        $query = $this->db->query($this->db->update_string('contenu',$data,$where));
        if(!$query){
            $ret= array(
                "ErrorMessage" => $this->db->_error_message(),
                "ErrorNumber" => $this->db->_error_message()
            );
        }else
            $ret = "good";
        return $ret;

    }

    public function deleteContenuModule(){
        $array = array(
            "module" => $this->input->post('selectModuleShowContenu'),
            "partie" => $this->input->post('selectContenuModule')
        );
        foreach($array['partie'] as $partie){
            $this->db->where('partie',$partie);
            $query = $this->db->delete('contenu');
        }
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

    /**
     * @return int nombre d'heure qu'un professeur a
     */
    public function getHeuresPrises($teacher){
        $this->db->SELECT ("hed");
        $this->db->from ("contenu");
        $this->db->where("enseignant",$teacher);
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

    public function removeALotEnseignanttoContenu($tableau_enseignants){
        foreach($tableau_enseignants as $enseignants) {
            $data = array(
                'enseignant' => null
            );
            $this->db->where('enseignant', $enseignants);
            $this->db->update('contenu',$data);
        }
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

    public function desinscriptionModule($module,$partie){
        $data = array(
            'enseignant' => null
        );
        //$this->db->set('enseignant',$this->session->userdata('username'));
        $this->db->where('module',$module);
        $this->db->where('partie',$partie);
        $this->db->where('enseignant',$this->session->userdata('username'));
        $query = $this->db->update('contenu',$data);
        return $query;
    }
}