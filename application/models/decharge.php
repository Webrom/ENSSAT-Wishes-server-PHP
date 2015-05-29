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
}