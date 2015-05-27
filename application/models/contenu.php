<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 27/05/15
 * Time: 17:14
 */

class Contenu extends CI_Model{

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
}