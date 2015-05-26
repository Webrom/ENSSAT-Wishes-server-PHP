<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 14:46
 */

class Users extends CI_Model{


    /**
     * Permet de savoir si un utilisateur existe, et si oui si le mot de passe est le bon
     * @return bool Vrai si l'utilisateur et le mdp existe, sinon faux
     */
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

    /**
     * Permet de savoir si un compte est actif ou inactif
     * @return le contenu de 'actif' de la base
     */
    public function verifyActivity(){
        $this->db->select('actif');
        $this->db->from('enseignant');
        $this->db->where('login',$this->input->post('username'));
        $query = $this->db->get();
        return $query->row()->actif;
    }

}