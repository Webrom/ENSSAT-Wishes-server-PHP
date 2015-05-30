<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 30/05/15
 * Time: 02:23
 */

class News extends CI_Model{

    public function addNews ($login,$type,$information){
        $this->db->set('DATE','NOW()',false);
        $this->db->set('TYPE',$type);
        $this->db->set('INFORMATION',$information);
        $this->db->set('ENSEIGNANT',$login);
        return $this->db->insert('news');
    }

    public function getGeneralesNews(){
        $this->db->select('DATE,INFORMATION');
        $this->db->from('news');
        $this->db->where('TYPE','generale');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getInformation($date){
        $this->db->select('INFORMATION');
        $this->db->from('news');
        $this->db->where('DATE',$date);
        $query = $this->db->get();
        return $query->row()->INFORMATION;
    }

    public function removeNews($date){
        $this->db->where('DATE', $date);
        return $this->db->delete('news');
    }
}