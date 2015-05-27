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
        $this->load->view('front/template/header');
        $this->load->view('front/login/login_form',$data);
        $this->load->view('front/template/footer');
    }

    public function validate_credentials(){
        $this->load->model('users');
        $query = $this->users->verifyUser();
        if($query){
            $data = array(
                'username' => $this->input->post('username'),
                'is_logged_in' => true
            );
            $this->session->set_userdata($data);
            $actif = $this->users->verifyActivity();
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
        $this->load->view('front/template/header');
        $this->load->view('front/login/signup_form');
        $this->load->view('front/template/footer');
    }

    public function createUser(){
        echo 'azeaze';
    }
}