<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */

class admin extends CI_Controller{

    public function index(){
        $this->load->model(admin);

        $this->load->view('back/template/header');
        $this->load->view('back/admin/admin_panel');
        $this->load->view('back/template/footer');
    }
}