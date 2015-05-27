<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 15:35
 */

class homeNews extends CI_Controller {
    public function index(){
        if(!$this->session->userdata('is_logged_in')){
            redirect('login');
        }else{
            $this->load->view('header');
            $this->load->view('back/template/header');
            $this->load->view('footer');
        }
    }
}