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

    public function index($msg=null,$success=null){
        if(!$this->session->userdata('is_logged_in')){
            redirect('login');
        }else{
            $data = array(
                "admin" => $this->session->userdata['admin'],
                "active" => "Administration",
                "enseignants" => $this->users->getAllEnseignants(),
                "semestres" => array("S1","S2","S3","S4","S5","S6"),
                "publics" => $this->modulesmodels->getAllPublic(),
                "modules" => $this->modulesmodels->getAllModules(),
                "msg" => $msg,
                "success" => $success
            );
            $this->load->view('header',$data);
            $this->load->view('back/template/header');
            $this->load->view('back/admin/admin_panel',$data);
            $this->load->view('footer');
        }
    }

    public function addModule(){
        $res= $this->modulesmodels->addModule();
        if($res=="good")
            $this->index("Votre module a été rajouté.","alert-success");
        else
            $this->index($res['ErrorMessage']." ".$res['ErrorNumber'],"alert-danger");
    }

    public function deleteModule(){
        $this->modulesmodels->deleteModule();
        $this->index("Le/les modules ont été supprimé.","alert-success");
    }
}