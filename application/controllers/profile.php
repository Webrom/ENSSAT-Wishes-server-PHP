<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */

class profile extends CI_Controller{

    public function index(){
        $this->load-> model('users');
        $userInfo = $this->users->getUserData();
        $data = array(
            "userInfos" => $userInfo
        );
        if(!$this->session->userdata('is_logged_in')){
            redirect('login');
        }else{
            $this->load->model('users');
            $this->load->view('header');
            $this->load->view('back/template/header');
            if($this->users->isAdmin()=="1")
                $this->load->view('back/profile/admin_panel');
            else
                $this->load->view('back/profile/profile_panel',$data);
            $this->load->view('footer');
        }
    }
}
