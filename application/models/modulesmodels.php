<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 27/05/15
 * Time: 15:38
 */

class modulesmodels extends CI_Model {
    public function getAllModules(){
        $this->db->select("ident,libelle");
        $this->db->from ("module");
        $query = $this->db->get();
        return $query->result_array();
    }


}