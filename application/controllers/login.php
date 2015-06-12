<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */

include 'SRV_Controller.php';

class Login extends SRV_Controller
{

    /**
     * Fonction permettant de se déconnecter
     */
    function logout()
    {
        $this->session->unset_userdata('is_logged_in');
        $this->session->sess_destroy();
        $data = array(
            'success' => "alert-success",
            'msg' => "Vous avez bien été déconnecté."
        );
        $this->index($data);
    }

    /**
     * Page principale du controlleur login
     */
    public function index($data = null)
    {
        $this->load->model('users');
        // si l'utilisateur n'est pas connecté afficher panel de connexion
        if (!$this->session->userdata('is_logged_in')) {
            $this->load->view('header');
            $this->load->view('front/template/header');
            $this->load->view('front/login/login_form', $data);
            $this->load->view('front/template/footer_help');
            $this->load->view('footer');
        } else {
            // si l'utilisateur est déjà connecté, le renvoyer vers la page principale...
            if ($this->users->verifyActivity($this->session->userdata('username')) == "1") {
                redirect('homeNews');
            } else {
                $data = array(
                    'success' => "alert-danger",
                    'msg' => "Votre compte est inactif, veuillez contacter l'administrateur."
                );
                $this->load->view('header');
                $this->load->view('front/template/header');
                $this->load->view('front/login/login_form', $data);
                $this->load->view('front/template/footer_help');
                $this->load->view('footer');
            }
        }
    }

    /**
     * Fonction pour savoir si un utilisateur peut se connecter
     */
    public function validate_credentials()
    {
        $this->load->model('users');
        $query = $this->users->verifyUser($this->input->post("username"), $this->input->post("password"));

        if ($query) {
            $data = array(
                'username' => $this->input->post('username'),
                'is_logged_in' => true,
                'admin' => $this->users->isAdmin($this->input->post('username'))
            );
            $this->session->set_userdata($data);
            $actif = $this->users->verifyActivity($data['username']);

            if ($actif == "1") {
                redirect('homeNews');
            } else {
                $data = array(
                    'success' => "alert-danger",
                    'msg' => "Votre compte est inactif, veuillez contacter l'administrateur."
                );
            }
        } else {
            $data = array(
                'success' => "alert-danger",
                'msg' => "Ce couple login / pwd n'existe pas, merci de vérifier vos identifiants !"
            );
        }
        $this->index($data);
    }

    /**
     * Cette fonction du controleur permet d'afficher le formulaire d'inscription
     * Pour la liste des statuts des enseignants on demande au modèle d'intérroger la base
     */
    public function signUp()
    {
        $this->load->view('header');
        $this->load->view('front/template/header_signup');
        $this->load->model('users');
        $data = array(
            'status' => $this->users->getStatus()
        );
        $this->load->view('front/login/signup_form', $data);
        $this->load->view('front/template/footer_help');
        $this->load->view('footer');
    }

    /**
     * Fonction pour créer un utlilisateur
     */
    public function createUser()
    {
        $this->load->view('header');
        $this->load->view('front/template/header_signup');
        $this->load->model('users');
        $this->form_validation->set_rules('name', 'Name', 'required|alpha_dash');
        $this->form_validation->set_rules('prenom', 'Prenom', 'required|alpha_dash');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('heures', 'Heures', 'required|is_natural_no_zero');
        if ($this->input->post('status_select') == "autre") {
            $this->form_validation->set_rules('status_perso', 'status_perso', 'required|alpha_dash');
        }
        if ($this->form_validation->run() == FALSE) {
            $status = $this->users->getStatus();
            $data = array(
                'status' => $status,
                'success' => "alert-danger",
                'msg' => "Il y a une erreur dans votre formulaire, veuillez recommencer."
            );
            $this->load->view('front/login/signup_form', $data);
        } else {
            $login = $this->users->addUser($this->input->post('password'),$this->input->post("actif"),"0", "0",$this->input->post('prenom'),$this->input->post('name'),$this->input->post('heures'));
            $data = array(
                'success' => "alert-success",
                'msg' => "Inscription terminée. Votre login est " . $login . ", vous devez maintenant attendre la validation de votre compte par un administrateur."
            );
            $this->index($data);
        }
        $this->load->view('footer');
    }
}