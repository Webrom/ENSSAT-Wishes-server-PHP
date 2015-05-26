<?php
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
        $this->load->view('front/login_form');
        $this->load->view('front/template/footer');
    }
}