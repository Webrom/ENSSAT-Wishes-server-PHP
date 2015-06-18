<?php

/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 27/05/15
 * Time: 15:20
 */

include 'SRV_Controller.php';

class modules extends SRV_Controller
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
            "enseignants2" => $this->users->getAllEnseignants(),
            "result" => $result,
            "moduleSelected" => ($infosmodule!=null)?$infosmodule['moduleSelected']:null,
            "teacherSelected" => ($infosmodule!=null)?$infosmodule['teacherSelected']:null,
            "allSemesters" => array("S1", "S2", "S3", "S4", "S5", "S6"),
            "allProm" => array("IMR1", "IMR2", "IMR3", "EII1", "EII2", "EII3", "TC", "LSI1", "LSI2", "LSI3", "OPT1", "OPT2", "OPT3", "commun IMR1 et EII2"),
            "semSelected" => ($infosmodule == null) ? "noSemester" : $infosmodule["semSelected"],
            "promSelected" => ($infosmodule == null) ? "noProm" : $infosmodule["promSelected"],
            "admin" => $this->session->userdata['admin'],
            "active" => "Modules",
            "checked" => ($infosmodule!=null)?$infosmodule['checked']:null,
            "success" => $infos['success'],
            "msg" => $infos['msg'],
            "myModules" => $this->contenu->getAllMyContenus($this->session->userdata('username')),
            "onglet" => ($onglet)?$onglet:$this->input->get('page'),
            "rechercheonglet" => $recherche
        );

        $dataPercentage = $this->getPercentage($this->session->userdata('username'));
        $data['pourcentage'] = $dataPercentage['pourcentage'];
        $data['heuresprises'] = $dataPercentage['heuresprises'];
        $data['heurestotales'] = $dataPercentage['heurestotales'];
        $data['avatar'] = $this->users->getAvatar($this->session->userdata('username'));


        $this->load->view('header', $data);
        $this->load->view('back/template/header');
        $this->load->view('back/modules/showmodules', $data);
        $this->load->view('footer');
    }

    /**
     * Recherche des modules
     */
    public function displayModuleContenus()
    {
        $data = array(
            "module" => $this->input->post('module'),
            "promotion" => $this->input->post("prom"),
            "semester" => $this->input->post("semester"),
            "teacher" => (!$this->input->post('checkboxSansEnseignant')) ? $this->input->post('teacher') : null
        );
        //La recherche peut etre divisée en : par promo ou par nom du module
        if ($this->input->post('searchType') == 'module') {
            $recherche = 'module';
        } else {
            $recherche = 'promo';
        }
        $result = $this->contenu->getContenus($data);
        $data = array(
            "moduleSelected" => $this->input->post('module'),
            "teacherSelected" => ($this->input->post('teacher')) ? $this->users->getUserDataByUsername($this->input->post('teacher')) : "no",
            "promSelected" => ($this->input->post("prom") != "noProm") ? $this->input->post("prom") : "noProm",
            "semSelected" => ($this->input->post("semester") != "noSemester") ? $this->input->post("semester") : "noSemester",
            "checked" => $this->input->post('checkboxSansEnseignant')
        );
        $initSession = array(
            "result" => $result
        );
        $this->session->set_userdata($initSession);
        $this->index($result, $data, null, "Recherche", $recherche);
    }

    /**
     * Inscription à un module, cette fonction vérifie si l'enseignant peut s'incrire
     * ou non au contenu.
     */
    public function inscriptionModule()
    {
        if ($this->input->get('module') && $this->input->get('partie')) {
            if ($this->contenu->ifContenuExist($this->input->get('module'), $this->input->get('partie'))) {
                if (!$this->contenu->ifThereIsTeacher($this->input->get('module'), $this->input->get('partie'))) {
                    $statutaire = $this->users->getStatutaire($this->session->userdata('username'));
                    $heuresdecharge = $this->decharge->getHoursDecharge($this->session->userdata('username'));
                    $heuresprises = $this->contenu->getHeuresPrises($this->session->userdata('username'));
                    $heureducontenu = $this->contenu->getHeurePourUnContenu($this->input->get('module'), $this->input->get('partie'));
                    if ($heuresdecharge==0 ||($statutaire - ($heuresprises + $heuresdecharge)) >= $heureducontenu) {
                        $result = $this->contenu->addEnseignanttoContenu($this->input->get('module'), $this->input->get('partie'),
                            $data = array(
                                'enseignant' => $this->session->userdata('username')
                            )
                        );
                        if ($result) {
                            $this->news->addNews($this->session->userdata('username'), "user",
                                "Inscription à un contenu"
                                , $this->input->get('module'),$this->input->get('partie'));
                            $info = array(
                                'success' => "alert-success",
                                'msg' => "Vous êtes maintenant inscrit à ce contenu."

                            );
                            //supprime le module selectionné de la variable session
                            //permet de laisser afficher le resultat de la recherche precedente
                            if(count($this->session->userdata('result'))>0){
                                $sessionArray =$this->session->userdata('result');
                                $this->session->unset_userdata('result');
                                array_splice($sessionArray,$this->input->get('key'),1);
                                $initSession = array(
                                    "result" => $sessionArray
                                );
                                $this->session->set_userdata($initSession);
                            }
                        } else {
                            $info = array(
                                'success' => "alert-danger",
                                'msg' => "Un problème (inconnu aussi au développeur de l'application) a eu lieu. Veuillez nous en excuser."
                            );
                        }
                    } else {
                        $info = array(
                            'success' => "alert-danger",
                            'msg' => "Désolé, mais il ne vous reste plus assez d'heures libres pour ce contenu."
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

        if($this->input->get('page')=='home'){
            $this->session->set_userdata($info);
            redirect('homeNews');
        }
        else {
            $this->index(null, null, $info, "Recherche");
        }
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
                "Désincsription d'un contenu"
                , $this->input->get('module'),$this->input->get('partie'));
        }
        $this->index(null, null, $info);
    }

    /**
     * Fonction pour afficher les modules en fonction des promotions
     */
    public function displayModuleByProm()
    {
        $result = array(
            'moduleByProm' => $this->modulesmodels->getModuleByProm("public", $this->input->post("prom"))
        );
        $this->index($result, null, null, "Recherche");
    }

    /**
     * Fonction pour aficher les modules en fonction des semestres
     */
    public function displayModuleBySemester()
    {
        $result = array(
            'moduleBySemester' => $this->modulesmodels->getModuleByProm("semestre", $this->input->post("prom"))
        );
        $this->index($result, null, null, "Recherche");
    }

    /**
     * Fonction export CSV
     * @param $data
     */
    public function exportCSV($data){
        $this->load->view('back/modules/exportCSV',$data);
    }

    /**
     * recuperation varaible session mymodules et transmission a la fonction export
     */
    public function exportCSVMyModules(){
        $this->exportCSV($data = array(
            "export" => unserialize($this->session->userdata('dataExportMyModules'))
        ));
    }

    /**
     * recuperation varaible session result et transmission a la fonction export
     */
    public function exportCSVResult(){
        $this->exportCSV($data = array(
            "export" => unserialize($this->session->userdata('dataExportResult'))
        ));
    }

    /**
     * @return bool
     * Fonction pour créer les graphiques modules
     */
    public function retreiveChartContenuModule(){
        if($this->input->get('gData')!=null) {
            $data = array(
                "module" => $this->input->get('gData'),
                "promotion" => "noProm",
                "semester" => "noSemester",
                "teacher" => "no"
            );
            $result = $this->contenu->getContenus($data);
            echo json_encode($result);
        }else
            return false;

    }

    /**
     * @return bool
     * Fonction pour créer les graphiques professeurs
     */
    public function retreiveChartTeacher(){
        if($this->input->get('gData')!=null) {
            $data = array(
                "teacher" => $this->input->get('gData'),
            );
            echo json_encode($this->contenu->getAllMyContenus($data['teacher']));
        }else
            return false;
    }

    /**
     * @return bool
     * Fonction pour créer les graphiques semestres
     */
    public function retreiveChartSemester(){
        if($this->input->get('gData')!="noSemester") {
            $data = array(
                "module" => "",
                "promotion" => "noProm",
                "semester" => $this->input->get('gData'),
                "teacher" => "no"
            );
            $result = $this->contenu->getContenus($data);
            echo json_encode($result);
        }else
            return false;
    }
}