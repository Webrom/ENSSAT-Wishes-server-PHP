<?php
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 27/05/15
 * Time: 15:20
 */

class modules extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('modulesmodels');
        $this->load->model('users');
        $this->load->model('contenu');
        $this->load->model('decharge');
    }

    public function index($result=null,$infosmodule=null,$infos=null){
        if(!$this->session->userdata('is_logged_in')){
            redirect('login');
        }else{
            $this->load->model('users');
            $data = array(
                "modules" => $this->modulesmodels->getAllModules(),
                "enseignants" => $this->users->getAllEnseignants(),
                "result" => $result,
                "module" => $infosmodule['module'],
                "teacher" => $infosmodule['teacher'],
                "admin" => $this->session->userdata['admin'],
                "active" => "Rechercher",
                "checked" => $infosmodule['checked'],
                "success" => $infos['success'],
                "msg" => $infos['msg'],
                "myModules" => $this->modulesmodels->getAllMyModules()
            );
            $this->load->view('header',$data);
            $this->load->view('back/template/header');
            $this->load->view('back/modules/showmodules',$data);
            $this->load->view('footer');
        }
    }

    public function displayModule(){
        if(!$this->session->userdata('is_logged_in')){
            redirect('login');
        }else{
                $data = array(
                    "module" => $this->input->post('module'),
                    "teacher" => (!$this->input->post('checkboxSansEnseignant'))?$this->input->post('teacher'):null
                );
                if ($data['module'] != "" && $data['teacher'] != "no") {
                    $result = $this->contenu->getModuleTeacher($data);

                } elseif ($data['module'] != "") {
                    $result = $this->contenu->getModuleByModule($data);
                } else {
                    $result = $this->contenu->getModuleByTeacher($data);

                }
            $data=array(
                "module" => $this->input->post('module'),
                "teacher" =>  ($this->input->post('teacher'))?$this->users->getUserDataByUsername($this->input->post('teacher')):"no",
                "checked" => $this->input->post('checkboxSansEnseignant')
            );
            $this->index($result,$data);
        }
    }

    public function inscriptionModule(){
        if(!$this->session->userdata('is_logged_in')){
            redirect('login');
        }else{
            if ($this->input->get('module')&&$this->input->get('partie')) {
                if ($this->contenu->ifContenuExist($this->input->get('module'), $this->input->get('partie'))) {
                    if (!$this->contenu->ifThereIsTeacher($this->input->get('module'), $this->input->get('partie'))) {
                        $statutaire = $this->users->getHeures();
                        $heuresdecharge = $this->decharge->getHoursDecharge($this->session->userdata('username'));
                        $heuresprises = $this->contenu->getHeuresPrises($this->session->userdata('username'));
                        $heureducontenu = $this->contenu->getHeurePourUnContenu($this->input->get('module'), $this->input->get('partie'));
                        if (($statutaire - ($heuresprises+$heuresdecharge)) >= $heureducontenu) {
                            $result = $this->contenu->addEnseignanttoContenu($this->input->get('module'), $this->input->get('partie'));
                            if ($result) {
                                $info = array(
                                    'success' => "alert-success",
                                    'msg' => "Vous êtes maintenant inscrit à ce contenu"
                                );
                            } else {
                                $info = array(
                                    'success' => "alert-danger",
                                    'msg' => "Un problème (inconnu aussi au développeur de l'application) a eu lieu. Veuillez nous en excuser."
                                );
                            }
                        } else {
                            $info = array(
                                'success' => "alert-danger",
                                'msg' => "Désolé mais il ne vous reste plus assez d'heures libres pour ce contenu"
                            );
                        }
                    }
                    else{
                        $info = array(
                            'success' => "alert-danger",
                            'msg' => "Le module a déjà un prof !"
                        );
                    }
                }
                else{
                    $info = array(
                        'success' => "alert-danger",
                        'msg' => "Les informations sont érronées."
                    );
                }
            }
            else{
                $info= array(
                    'success' => "alert-danger",
                    'msg' => "Il y a eu une erreur dans l'inscription au module."
                );
            }
            $this->index(null,null,$info);
        }
    }
    public function desinscriptionModule(){
        if(!$this->contenu->desinscriptionModule($this->input->get('module'), $this->input->get('partie'))) {
            $info = array(
                'success' => "alert-danger",
                'msg' => "Il y a eu une erreur dans la desinscription au module."
            );
        }
        else{
            $info = array(
                'success' => "alert-success",
                'msg' => "Vous êtes bien désinscrit de ce module."
            );
        }
        $this->index(null,null,$info);
    }
}