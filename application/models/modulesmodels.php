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

    public function getAllPublic(){
        $this->db->select("public");
        $this->db->distinct();
        $this->db->from("module");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function addModule(){
        /*$this->db->set('ident',$this->input->post('inputIdent'));
        $this->db->set('public',$this->input->post('selectPublic'));
        $this->db->set('semestre',$this->input->post('selectSemestre'));
        $this->db->set('libelle',$this->input->post('inputLibelle'));
        $this->db->set('responsable',$this->input->post('selectResponsable'));*/
        $module= array(
            "ident" => $this->input->post('inputIdent'),
            "public" => $this->input->post('selectPublic'),
            "semestre" => $this->input->post('selectSemestre'),
            "libelle" => $this->input->post('inputLibelle'),
            "responsable" => $this->input->post('selectResponsable')
        );
        $query = $this->db->insert('module',$module);
        var_dump($query);
    }
}