<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Fonctions pour les connexions utilisateurs
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

    public function addUser(){
        $test_login = strtolower(substr($this->input->post('prenom'),0,1));
        if (strlen($this->input->post('name'))>7){
            $taille = 7;
        }
        else{
            $taille = strlen($this->input->post('name'));
        }
        $test_login = $test_login.strtolower(substr($this->input->post('name'),0,$taille));
        $this->db->select('login');
        $this->db->from('enseignant');
        $this->db->where('login',$test_login);
        $query = $this->db->get();

        /*if ($query->num_rows==1){

        }
        else{
            $this->db->set()
        }*/
    }

    public function getStatus(){
        $this->db->select('statut');
        $this->db->distinct();
        $this->db->from('enseignant');
        $query = $this->db->get();
        return $query->result();
    }

    public function isAdmin(){
        $this->db->select('administrateur');
        $this->db->from('enseignant');
        $this->db->where('login',$this->session->userdata('username'));
        $query = $this->db->get();
        return $query->row()->administrateur;
    }
}