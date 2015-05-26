<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */

class profile extends CI_Controller{

    public function index(){
        $this->load->view('front/template/header');
        $this->load->view('front/profile/profile_panel');
        $this->load->view('front/template/footer');
    }
}
