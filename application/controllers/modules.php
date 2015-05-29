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
        $this->load-> model('modulesmodels');
        $this->load-> model('users');
        $this->load-> model('contenu');
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
                'success' => $infos['success'],
                'msg' => $infos['msg']
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
            if ($this->input->get('module')&&$this->input->get('partie')){
                $this->load->model('users');
                $this->load->model('contenu');
                $statutaire = $this->users->getHeures();
                $heuresprises = $this->contenu->getHeuresPrises();
                $heureducontenu = $this->contenu->getHeurePourUnContenu($this->input->get('module'),$this->input->get('partie'));
                if (($statutaire-$heuresprises)>= $heureducontenu){
                    $result = $this->contenu->addEnseignanttoContenu($this->input->get('module'),$this->input->get('partie'));
                    if ($result) {
                        $info = array(
                            'success' => "alert-success",
                            'msg' => "Vous êtes maintenant inscrit à ce contenu"
                        );
                    }
                    else{
                        $info = array(
                            'success' => "alert-danger",
                            'msg' => "Un problème (inconnu aussi au développeur de l'application) a eu lieu. Veuillez nous en excuser."
                        );
                    }
                }
                else{
                    $info= array(
                        'success' => "alert-danger",
                        'msg' => "Désolé mais il ne vous reste plus assez d'heures libres pour ce contenu"
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
}