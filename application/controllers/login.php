<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */

class Login extends CI_Controller{

    public function index()
    {
        $this->load->view('front/template/header');
        $this->load->view('front/login/login_form');
        $this->load->view('front/template/footer');
    }

    public function validate_credentials(){
        $username = ($this->input->post('username'))?$this->input->post('username'):null;
        $pwd = $this->input->post('password');

        var_dump($username,$pwd);
    }

    public function signUp(){
        $this->load->view('front/template/header');
        $this->load->view('front/login/signup_form');
        $this->load->view('front/template/footer');
    }
}