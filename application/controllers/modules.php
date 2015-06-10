<?php

/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 27/05/15
 * Time: 15:20
 */
class modules extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_logged_in')) {
            redirect('login');
        } else {
            $this->load->model('modulesmodels');
            $this->load->model('users');
            $this->load->model('contenu');
            $this->load->model('news');
            $this->load->model('decharge');
        }
    }

    public function index($result = null, $infosmodule = null, $infos = null, $onglet = null, $recherche = null)
    {
        $data = array(
            "modules" => $this->modulesmodels->getAllModules(),
            "enseignants" => $this->users->getAllEnseignants(),
            "result" => $result,
            "module" => $infosmodule['module'],
            "teacher" => $infosmodule['teacher'],
            "allSemesters" => array("S1", "S2", "S3", "S4", "S5", "S6"),
            "allProm" => array("IMR1", "IMR2", "IMR3", "EII1", "EII2", "EII3", "TC", "LSI1", "LSI2", "LSI3", "OPT1", "OPT2", "OPT3", "commun IMR1 et EII2"),
            "semSelected" => ($infosmodule == null) ? "noSemester" : $infosmodule["semSelected"],
            "promSelected" => ($infosmodule == null) ? "noProm" : $infosmodule["promSelected"],
            "admin" => $this->session->userdata['admin'],
            "active" => "Modules",
            "checked" => $infosmodule['checked'],
            "success" => $infos['success'],
            "msg" => $infos['msg'],
            "myModules" => $this->contenu->getAllMyContenus($this->session->userdata('username')),
            "onglet" => $onglet,
            "rechercheonglet" => $recherche
        );

        // TODO tripplon !
        /* CALCUL POURCENTAGE HEURES PRISES */
        $heuresprises = $this->contenu->getHeuresPrises($this->session->userdata('username'));
        $heurestotales = $this->users->getStatutaire($this->session->userdata('username')) - $this->decharge->getHoursDecharge($this->session->userdata('username'));
        $pourcentage = round(($heuresprises / $heurestotales) * 100, 0);
        $data['pourcentage'] = $pourcentage;
        $data['heuresprises'] = $heuresprises;
        $data['heurestotales'] = $heurestotales;
        /* FIN CALCUL */

        $this->load->view('header', $data);
        $this->load->view('back/template/header');
        $this->load->view('back/modules/showmodules', $data);
        $this->load->view('footer');
    }

    public function displayModule()
    {
        $data = array(
            "module" => $this->input->post('module'),
            "promotion" => $this->input->post("prom"),
            "semester" => $this->input->post("semester"),
            "teacher" => (!$this->input->post('checkboxSansEnseignant')) ? $this->input->post('teacher') : null
        );
        if ($this->input->post('searchType') == 'module') {
            $result = $this->contenu->getContenuByModule($data);
            $recherche = 'module';
        } else {
            $result = $this->contenu->getContenuByPromo($data);
            $recherche = 'promo';
        }
        $data = array(
            "module" => $this->input->post('module'),
            "teacher" => ($this->input->post('teacher')) ? $this->users->getUserDataByUsername($this->input->post('teacher')) : "no",
            "promSelected" => ($this->input->post("prom") != "noProm") ? $this->input->post("prom") : "noProm",
            "semSelected" => ($this->input->post("semester") != "noSemester") ? $this->input->post("semester") : "noSemester",
            "checked" => $this->input->post('checkboxSansEnseignant')
        );
        if($this->input->post('checkboxExport')){
            $export = "Il y a plus qu'à exporter pelo moi j'y arrive pas"; //TODO
        }
        $this->index($result, $data, null, "Recherche", $recherche);
    }

    // TODO commenter cette fonction de la mort ........
    public function inscriptionModule()
    {
        if ($this->input->get('module') && $this->input->get('partie')) {
            if ($this->contenu->ifContenuExist($this->input->get('module'), $this->input->get('partie'))) {
                if (!$this->contenu->ifThereIsTeacher($this->input->get('module'), $this->input->get('partie'))) {
                    $statutaire = $this->users->getStatutaire($this->session->userdata('username'));
                    $heuresdecharge = $this->decharge->getHoursDecharge($this->session->userdata('username'));
                    $heuresprises = $this->contenu->getHeuresPrises($this->session->userdata('username'));
                    $heureducontenu = $this->contenu->getHeurePourUnContenu($this->input->get('module'), $this->input->get('partie'));
                    if (($statutaire - ($heuresprises + $heuresdecharge)) >= $heureducontenu) {
                        $result = $this->contenu->addEnseignanttoContenu($this->input->get('module'), $this->input->get('partie'),
                            $data = array(
                                'enseignant' => $this->session->userdata('username')
                            )
                        );
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
                } else {
                    $info = array(
                        'success' => "alert-danger",
                        'msg' => "Le module a déjà un prof !"
                    );
                }
            } else {
                $info = array(
                    'success' => "alert-danger",
                    'msg' => "Les informations sont érronées."
                );
            }
        } else {
            $info = array(
                'success' => "alert-danger",
                'msg' => "Il y a eu une erreur dans l'inscription au module."
            );
        }
        $this->news->addNews($this->session->userdata('username'), "user",
            "Inscription à un module"
            , $this->input->get('module'),$this->input->get('partie'));
        if($this->input->get('page')=='home')
            redirect('homeNews');
        $this->index(null, null, $info, "Recherche");
    }

    public function desinscriptionModule()
    {
        if (!$this->contenu->desinscriptionModule($this->input->get('module'), $this->input->get('partie'),$this->session->userdata('username'))) {
            $info = array(
                'success' => "alert-danger",
                'msg' => "Il y a eu une erreur dans la désinscription au module."
            );
        } else {
            $info = array(
                'success' => "alert-success",
                'msg' => "Vous êtes bien désinscrit de ce module."
            );
            $this->news->addNews($this->session->userdata('username'), "user",
                "Désincsription d'un module"
                , $this->input->get('module'),$this->input->get('partie'));
        }
        $this->index(null, null, $info);
    }

    public function displayModuleByProm()
    {
        $result = array(
            'moduleByProm' => $this->modulesmodels->getModuleByProm("public", $this->input->post("prom"))
        );
        $this->index($result, null, null, "Recherche");
    }

    public function displayModuleBySemester()
    {
        $result = array(
            'moduleBySemester' => $this->modulesmodels->getModuleByProm("semestre", $this->input->post("prom"))
        );
        $this->index($result, null, null, "Recherche");
    }
}