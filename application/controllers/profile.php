<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */

class profile extends CI_Controller{

    public function index($msg=null,$success=null){
        $this->load-> model('users');
        $userInfo = $this->users->getUserData();
        $data = array(
            "userInfos" => $userInfo,
            "success" => $success,
            "msg" => $msg
        );
        if(!$this->session->userdata('is_logged_in')){
            redirect('login');
        }else{
            $this->load->view('header');
            $this->load->view('back/template/header');
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
                $this->users->changePassword($newPass1,$this->session->userdata('username'));
                $this->index("Votre mot de passe a été changé","alert-success");
            }
            else{
                $this->index("Les nouveaux mots de passe ne correspondent pas ! ","alert-danger");
            }
        else{
            $this->index("Votre ancien mot de passe n'est pas bon ! ","alert-danger");
        }
    }


}
