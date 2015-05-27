<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 27/05/15
 * Time: 17:14
 */

class Contenu extends CI_Model{

    public function getHeuresPrises(){
        $this->db->SELECT ("hed");
        $this->db->from ("contenu");
        $this->db->where("enseignant",$this->session->userdata('username'));
        $query =  $this->db->get();
        $result = $query->result_array();
        $heures = 0;
        foreach ($result as $heure){
            $heures = $heures+$heure['hed'];
        }
        return $heures;
    }
}