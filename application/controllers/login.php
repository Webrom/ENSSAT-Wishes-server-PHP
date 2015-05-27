<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */

class Login extends CI_Controller{

    public function index($data=null)
    {
        if(!$this->session->userdata('is_logged_in')){
            $this->load->view('header');
            $this->load->view('front/template/header');
            $this->load->view('front/login/login_form',$data);
            $this->load->view('front/template/footer_help');
            $this->load->view('footer');
        }else{
            if($this->users->verifyActivity($this->session->userdata('username'))=="1"){
                redirect('homeNews');
            }else{
                $data= array(
                    'msg' => "Votre compte est inactif, veuillez contacter l'administrateur"
                );
                $this->load->view('header');
                $this->load->view('front/template/header');
                $this->load->view('front/login/login_form',$data);
                $this->load->view('front/template/footer_help');
                $this->load->view('footer');
            }
        }

    }

    function logout()
    {
        $this->session->unset_userdata('is_logged_in');
        $data = array(
            'msg' => "Vous avez bien été déconnecté."
        );
        $this->index($data);
    }

    public function validate_credentials(){
        $this->load-> model('users');
        $query = $this->users->verifyUser();

        if($query){

            $data = array(
                'username' => $this->input->post('username'),
                'is_logged_in' => true
            );
            $this->session->set_userdata($data);
            $actif = $this->users->verifyActivity($data['username']);
            if($actif=="1"){
                redirect('homeNews');
            }
            else{
                $data= array(
                    'msg' => "Votre compte est inactif, veuillez contacter l'administrateur"
                );
                $this->index($data);
            }
        }else{
            $data= array(
                'msg' => "Ce compte n'existe pas, merci de vérifier vos identifiants"
            );
            $this->index($data);
        }
    }

    public function signUp(){
        $this->load->view('header');
        $this->load->view('front/template/header_signup');
        $this->load->model('users');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('prenom', 'Prenom', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('heures', 'Heures', 'required');
        if ($this->form_validation->run() == FALSE) {
            $status = $this->users->getStatus();
            $data = array(
                "status" => $status
            );
            $this->load->view('front/login/signup_form', $data);
        }
        else {
            echo "cest bon";
        }
        $this->load->view('footer');
    }

    public function createUser(){
        $this->load->view('header');
        $this->load->view('front/template/header_signup');
        $this->load->model('users');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('prenom', 'Prenom', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('heures', 'Heures', 'required');
        if ($this->form_validation->run() == FALSE) {
            $status = $this->users->getStatus();
            $data = array(
                "status" => $status,
                "msg" => "Il y a une erreur dans votre formulaire, veuillez recommencer."
            );
            $this->load->view('front/login/signup_form', $data);
        }
        else {
            echo "formulaire ok";
        }
        $this->load->view('footer');
    }
}