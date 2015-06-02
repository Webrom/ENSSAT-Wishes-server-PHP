<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 29/05/15
 * Time: 22:35
 */

class Decharge extends CI_Model{

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

    public function isPresentInTable(){
        $this->db->select('decharge');
        $this->db->from('decharge');
        $this->db->where('enseignant',$this->session->userdata('username'));
        $query = $this->db->get();
        if ($query->num_rows==1){
            return "1";
        }
        else{
            return "0";
        }
    }

    public function setDecharge(){
        $data = array(
            'decharge' => $this->input->post("inputDecharge")
        );
        $this->db->where("enseignant",$this->session->userdata('username'));
        $this->db->update('decharge',$data);
    }

    public function addNewDecharge($data){
        $this->db->insert('decharge', $data);
    }
}