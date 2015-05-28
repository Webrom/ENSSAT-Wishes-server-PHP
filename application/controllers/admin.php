<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */

class admin extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load-> model('modulesmodels');
        $this->load-> model('users');
        $this->load-> model('contenu');
    }

    public function index(){
        if(!$this->session->userdata('is_logged_in')){
            redirect('login');
        }else{
            $data = array(
                "admin" => $this->session->userdata['admin'],
                "active" => "Administration"
            );
            $this->load->view('header',$data);
            $this->load->view('back/template/header');
            $this->load->view('back/admin/admin_panel',$data);
            $this->load->view('footer');
        }
    }
}