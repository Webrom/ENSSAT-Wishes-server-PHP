<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 14:46
 */

class Users extends CI_Model{

    public function verifyUser(){
        $this->db->from('enseignant');
        $this->db->where('login',$this->input->post('username'));
        $this->db->where('pwd',$this->input->post('password'));
        $query = $this->db->get();

        if ($query->num_rows==1){
            return true;
        }
        else{
            return false;
        }
    }

}