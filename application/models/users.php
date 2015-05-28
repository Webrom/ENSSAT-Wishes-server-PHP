<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Fonctions pour les connexions utilisateurs
 */

class Users extends CI_Model{


    /**
     * Permet de savoir si un utilisateur existe, et si oui si le mot de passe est le bon
     * @return bool Vrai si l'utilisateur et le mdp existe, sinon faux
     */
    public function verifyUser($name,$oldpass){
        $this->db->from('enseignant');
        $this->db->where('login',$name);
        $this->db->where('pwd',$oldpass);
        $query = $this->db->get();

        if ($query->num_rows==1){
            return true;
        }
        else{
            return false;
        }
    }

    public function getUserData(){
        $this->db->SELECT ("login,nom, prenom, statut, statutaire");
        $this->db->from ("enseignant");
        $this->db->where("login",$this->session->userdata('username'));
        $query =  $this->db->get();

        return $query->result_array();
    }

    public function getUserDataByUsername($username){
        $this->db->SELECT ("login,nom, prenom, statut, statutaire");
        $this->db->from ("enseignant");
        $this->db->where("login",$username);
        $query =  $this->db->get();

        return $query->result_array();
    }

    /**
     * Permet de savoir si un compte est actif ou inactif
     * @param $name
     * @return le contenu de 'actif' de la base
     */
    public function verifyActivity($name){
        $this->db->select('actif');
        $this->db->from('enseignant');
        $this->db->where('login',$name);
        $query = $this->db->get();
        return $query->row()->actif;
    }

    public function addUser($pwd="servicesENSSAT",$activity=0,$accepted=0){
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

        if ($query->num_rows==1){
            $x = 1;
            $pourwhile = 0;
            while ($pourwhile == 0){
                $this->db->select('login');
                $this->db->from('enseignant');
                $this->db->where('login',$test_login.$x);
                $querywhile = $this->db->get();
                if ($querywhile->num_rows<1){
                    $pourwhile = 1;
                    $test_login = $test_login.$x;
                }
                else{
                    $x++;
                }
            }
        }
        if ($this->input->post('status_select') == "autre"){
            $statut = $this->input->post('status_perso');
        }
        else{
            $statut = $this->input->post('status_select');
        }
        $this->db->set('login',$test_login);
        $this->db->set('pwd',$pwd);
        $this->db->set('nom',$this->input->post('name'));
        $this->db->set('prenom',$this->input->post('prenom'));
        $this->db->set('statut',$statut);
        $this->db->set('statutaire',$this->input->post('heures'));
        $this->db->set('actif',$activity);
        $this->db->set('administrateur',0);
        $this->db->set('accepted',$accepted);
        $this->db->insert('enseignant');
        return $test_login;
    }

    public function delUser($userLogin){
        //DELETE FROM `voeux`.`enseignant` WHERE `enseignant`.`login` = 'bvozel'
        $this->db->where('login', $userLogin);
        $this->db->delete('enseignant');
    }
    /*
     * fonction utilisee pour mettre a jour le password de l'utilisateur,
     * depuis sa page profil
     * @return rien du tout
     */
    public function changePassword($newPass){
        //$this->db->query('UPDATE enseignant SET pwd ="'.$newPass.'" WHERE login="'.$userName.'";');
        $data = array(
            'pwd' => $newPass,
        );
        $this->db->where('login', $this->session->userdata('username'));
        $this->db->update('enseignant', $data);
    }

    /*
     * retourne le statut d'un enseignant : 0 si inactif, 1 si actif
     * @return resultat de query
     */
    public function getStatus(){
        $this->db->select('statut');
        $this->db->distinct();
        $this->db->from('enseignant');
        $query = $this->db->get();
        return $query->result();
    }

    /*
     * retourne 1 si l'utilisateur courant est un administrateur du site
     */
    public function isAdmin($username){
        $this->db->select('administrateur');
        $this->db->from('enseignant');
        $this->db->where('login',$username);
        $query = $this->db->get();
        return $query->row()->administrateur;
    }

    public function getAllEnseignants(){
        $this->db->select('login, nom, prenom');
        $this->db->from('enseignant');
        $query=$this->db->get();
        return $query->result_array();
    }

    public function getHeures(){
        $this->db->select('statutaire');
        $this->db->from('enseignant');
        $this->db->where('login',$this->session->userdata('username'));
        $query = $this->db->get();
        return $query->row()->statutaire;
    }

    public function getAvatar(){
        $this->db->select('avatar');
        $this->db->from('enseignant');
        $this->db->where('login',$this->session->userdata('username'));
        $query = $this->db->get();
        return $query->row()->avatar;
    }
}