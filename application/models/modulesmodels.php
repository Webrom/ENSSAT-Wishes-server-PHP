<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 27/05/15
 * Time: 15:38
 */

class modulesmodels extends CI_Model {

    public function getAllModules(){
        $this->db->select("ident,libelle,public");
        $this->db->from ("module");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function addContenuToModule(){
        $contenu = array(
            "module" => $this->input->post('selectModule'),
            "partie" => $this->input->post('moduleType'),
            "type" =>  $this->input->post('selectType'),
            "hed" => $this->input->post('moduleHed'),
            "enseignant" => null,
        );
        $query = $this->db->insert('contenu',$contenu);
        if(!$query){
            $ret= array(
                "ErrorMessage" => $this->db->_error_message(),
                "ErrorNumber" => $this->db->_error_message()
            );
        }
        return ($query)?"good":$ret;
    }

    public function getAllPublic(){
        $this->db->select("public");
        $this->db->distinct();
        $this->db->from("module");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllMyModules(){
        $this->db->select("module,partie,type,hed");
        $this->db->from("contenu");
        $this->db->where("enseignant",$this->session->userdata('username'));
        $query = $this->db->get();

        if(!$query) {
            return null;
        }
        else {
            return $query->result_array();
        }
    }

    public function getModuleByPromOrSemester($promOrSemester,$valueSent){
        $this->db->select("ident");
        $this->db->from("module");
        $this->db->where($promOrSemester,$valueSent);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function deleteModuleContenu($modules){
        foreach($modules as $module){
            $this->db->where('module',$module);
            $this->db->delete('contenu');
            $this->db->where('ident',$module);
            $this->db->delete('module');
        }
    }

    public function addModule(){
        $module= array(
            "ident" => $this->input->post('inputIdent'),
            "public" => $this->input->post('selectPublic'),
            "semestre" => $this->input->post('selectSemestre'),
            "libelle" => $this->input->post('inputLibelle'),
            "responsable" => strlen($this->input->post('selectResponsable')!=0)?$this->input->post('selectResponsable'):null
        );
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