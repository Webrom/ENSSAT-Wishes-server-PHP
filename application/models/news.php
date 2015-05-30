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
}