<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */

class profile extends CI_Controller{

    public function index($uploadError=null,$msg=null,$success=null){
        //charger le modele users
        $this->load-> model('users');

        $data = array(
            "userInfos" => $this->users->getUserData(),
            "success" => $success,
            "msg" => $msg,
            "uploadError" => $uploadError,
            "admin" => $this->session->userdata["admin"],
            "avatar" => $this->users->getAvatar(),
            "active" => "Profil"
        );

        if(!$this->session->userdata('is_logged_in')){
            redirect('login');
        }else{
            $this->load->model('contenu');

            /* CALCUL POURCENTAGE HEURES PRISES */
            $heuresprises = $this->contenu->getHeuresPrises();
            $heurestotales = $this->users->getHeures();
            $pourcentage = round(($heuresprises/$heurestotales)*100,0);
            $data['pourcentage'] = $pourcentage;
            $data['heuresprises'] = $heuresprises;
            $data['heurestotales'] = $heurestotales;
            /* FIN CALCUL */

            $this->load->view('header',$data);
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

        if($this->users->verifyUser($this->session->userdata('username'),$oldPass)) {
            if ($newPass1 == $newPass2) {
                $this->users->changePassword($newPass1, $this->session->userdata('username'));
                $this->index(null,"Votre mot de passe a été changé","alert-success");
            } else {
                $this->index(null,"Les nouveaux mots de passe ne correspondent pas ! ","alert-danger");
            }
        }
        else{
            $this->index(null,"Votre ancien mot de passe n'est pas bon ! ","alert-danger");
        }
    }
}
