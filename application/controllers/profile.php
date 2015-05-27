<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */

class profile extends CI_Controller{

    public function index($msg=null){
        $this->load-> model('users');
        $userInfo = $this->users->getUserData();
        $data = array(
            "userInfos" => $userInfo,
            "msg" => $msg
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

    public function changePass(){
        $this->load-> model('users');
        $oldPass  = $this->input->post("oldPass");
        $newPass1 = $this->input->post("newPass1");
        $newPass2 = $this->input->post("newPass2");

        if($this->users->verifyUser($this->session->userdata('username'),$oldPass))
            if($newPass1==$newPass2){
                changePassword($newPass1,$this->session->userdata('username'));
            }
            else{
                $this->index("Les mots de passe ne correspondent pas ! ");
            }
        else{

        }
    }
}
