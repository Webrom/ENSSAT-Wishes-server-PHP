<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */
include 'SRV_Controller.php';

class admin extends SRV_Controller
{

    function __construct()
    {
        parent::__construct();
        // verification d'usage avant de pouvoir utiliser le panel d'admin...
        if (!$this->session->userdata('is_logged_in') || $this->session->userdata['admin'] == "0") {
            redirect('login');
        } else {
            //si l'utilisateur est connecté ET administrateur du site, charger les modeles...
            $this->load->model('modulesmodels');
            $this->load->model('users');
            $this->load->model('contenu');
            $this->load->model('news');
            $this->load->model('decharge');
            $this->load->model('uploadmodel');
        }
    }

    /**
     * Permet de recuperer le contenu
     */
    public function setModuleContenusType()
    {
        echo json_encode($this->contenu->getTypeContenu($this->input->get('gData')));
    }

    /**
     * Modifie le contenu d'un module, modifie l'enseignant si ce dernier peut encore effectuer des heures,
     * idem lorsqu'on modifie les hed du contenu
     */
    public function modifyModuleContenu()
    {
        $data = array(
            "partie" => $this->input->post('modulePartieAjax'),
            "type" => $this->input->post('selectTypeAjax'),
            "hed" => $this->input->post('moduleHedAjax'),
            // S'il n'y a pas d'enseignant retourne null
            "enseignant" => ($this->input->post('selectTeacher') != "") ? $this->input->post('selectTeacher') : null,
        );
        $keys = array(
            "module" => $this->input->post('selectModuleShowContenu'),
            "partie" => $this->input->post('selectContenuModuleModification')
        );
        $hours = array(
            "teacherHours" => $this->users->getStatutaire($this->session->userdata('username')),
            "effectiveTeacherHours" => $this->contenu->getHeuresPrises($data['enseignant']),
            "decharge" => $this->decharge->getHoursDecharge($data['enseignant']),
            "hedContenu" => $this->contenu->getHeurePourUnContenu($keys['module'], $keys['partie'])
        );
        // Permet de savoir si l'enseignant était déja dans le module, utile pour le calcul de la décharge
        if ($data['enseignant'] == $this->contenu->getModuleTeacher(array(
                "module" => $keys['module'],
                "partie" => $keys['partie'],
                "teacher" => $data['enseignant']
            ))
        )
            $res = $hours['teacherHours'] - $hours['decharge'] + $hours['effectiveTeacherHours'] - $hours['hedContenu'];
        else
            $res = $hours['teacherHours'] - $hours['decharge'] - $hours['effectiveTeacherHours'];
        if ($hours['decharge']==0 || $res >= $data['hed'] || $data['enseignant'] == null) {
            $ret = $this->contenu->modifyModuleContenu($data, $keys);
            if ($ret == "good") {
                $this->news->addNews($this->session->userdata('username'), "contenu",
                    "Le contenu du module : " . $keys['module'] . " a été modifié.", $keys['module'] . " " . $keys['partie']);
                $this->index('Le contenu du module a été modifié.', "alert-success", "#modifyContenu");
            } else
                $this->index($ret['ErrorMessage'] . $ret['ErrorNumber'], 'alert-danger', '#modifyContenu');
        } else
            $this->index($data['enseignant'] . " n'a pas assé d'heure de disponible pour ce contenu", 'alert-danger', '#modifyContenu');
    }

    /**
     * gere l'affichage des vues
     * @param null $msg
     * @param null $success
     * @param null $active
     */
    public function index($msg = null, $success = null, $active = null)
    {
        //on est obligé d'envoyer des tableaux séparés pour pouvoir utiliser la liste des enseignants/modules/etc... plusieurs fois
        $data = array(
            "admin" => $this->session->userdata['admin'],
            "active" => "Administration",
            "enseignants" => $this->users->getAllEnseignants(),
            "enseignantsContenu" => $this->users->getAllEnseignants(), // obligé d'avoir en double car on a plusieurs boucles dans la vue
            "enseignantsModify" => $this->users->getAllEnseignants(),
            "enseignantsToAccept" => $this->users->getAllEnseignantsToAccept(),
            "enseignantsModifyModule" => $this->users->getAllEnseignants(),
            "semestres" => array("S1", "S2", "S3", "S4", "S5", "S6"),
            "publics" => array("IMR1", "IMR2", "IMR3", "EII1", "EII2", "EII3", "TC", "LSI1", "LSI2", "LSI3", "OPT1", "OPT2", "OPT3","commun IMR1 et EII2"),
            //"publics" => $this->modulesmodels->getAllPublic(),
            "modules" => $this->modulesmodels->getAllModules(),
            "msg" => $msg,
            "success" => $success,
            "status" => $status = $this->users->getStatus(),           // recupere les differents status
            "moduleTypes" => $this->contenu->getAllModuleTypes(),
            "enAttente" => $this->users->ifSomeoneWait(),
            "activeOnglet" => $active,
            "allnews" => $this->news->getGeneralesNews()
        );

        $dataPercentage = $this->getPercentage($this->session->userdata('username'));
        $data['pourcentage'] = $dataPercentage['pourcentage'];
        $data['heuresprises'] = $dataPercentage['heuresprises'];
        $data['heurestotales'] = $dataPercentage['heurestotales'];
        $data['avatar'] = $this->users->getAvatar($this->session->userdata('username'));


        $this->load->view('header', $data);
        $this->load->view('back/template/header');
        $this->load->view('back/admin/admin_panel', $data);
        $this->load->view('footer');
    }

    /**
     * Permet de recuperer le contenu d'un module grâce à son module et sa partie utilisée par une fonction ajax
     */
    public function setModuleContenus()
    {
        echo json_encode($this->contenu->getModuleContenusByPartieModule(
            $array = array(
                "partie" => $this->input->get('gData'),
                "module" => $this->input->get('bData')
            )
        ));
    }

    /**
     * fonction pour créer un utilisateur.
     * mot de passe par défaut : servicesENSSAT
     */
    public function addUser()
    {
        $login = $this->users->addUser("servicesENSSAT", $this->input->post("actif"),$this->input->post("admin"), "1",$this->input->post('prenom'),$this->input->post('name'),$this->input->post('heures'));
        $this->index("Utilisateur créé avec le login ".$login, "alert-success", "#addUser");
        $this->news->addNews($this->session->userdata('username'), "user", "L'utilisateur : " . $this->input->post('prenom') ." ". $this->input->post('name') . " a été ajouté.");
    }

    /**
     * Fonction pour accepter les utilisateurs via le pannel d'administration
     * Le echo est là pour renvoyer le résultat à la fonction Ajax
     */
    public function acceptUsers()
    {
        echo $this->users->acceptUsers($this->input->get('login'));
        $this->news->addNews($this->session->userdata('username'), "user", "L'utilisateur : " . $this->input->get('login') . " a été accepté.");
    }

    /**
     * Fonction pour refuser les utilisateurs via le pannel d'administration
     */
    public function refuseUsers()
    {
        echo $this->users->refuseUsers($this->input->get('login'));
    }

    /**
     * Fonction pour ajouter un module depuis le pannel admin
     */
    public function addModule()
    {
        $module = array(
            "ident" => substr($this->input->post('inputIdent'),0,10),
            "public" => $this->input->post('selectPublic'),
            "semestre" => $this->input->post('selectSemestre'),
            "libelle" => $this->input->post('inputLibelle'),
            "responsable" => ($this->input->post('selectResponsable') != NULL) ? $this->input->post('selectResponsable') : null
        );
        $res = $this->modulesmodels->addModule($module);
        if ($res == "good") {
            $this->index("Votre module a été rajouté.", "alert-success", "");
            $this->news->addNews($this->session->userdata('username'), "module",
                "Le module " . $this->input->post('inputIdent') . " vient d'être ajouté.",
                $module['ident']);
        } else {
            $this->index($res['ErrorMessage'] . " " . $res['ErrorNumber'], "alert-danger", "");
        }
    }

    /**
     * Fonction pour supprimer un module
     */
    public function deleteModule()
    {
        $modules = $this->input->post('module');
        if ($modules != null) {
            $this->modulesmodels->deleteModuleContenu($modules);
            $this->index("Le/les modules ont étés supprimés.", "alert-success", "#deleteModule");
            foreach ($modules as $MODULE) {
                $this->news->addNews($this->session->userdata('username'), "delete-module", "Le module " . $MODULE . " vient d'être supprimé.");
            }
        } else
            $this->index("Veuillez remplir correctement le formulaire", "alert-danger", "#deleteModule");
    }

    /**
     * Fonction pour suprimer un utilisateur
     */
    public function deleteUser()
    {
        $data = $this->input->post('enseignants');
        if ($data != null) {
            $this->news->deleteNewsForUsers($data);
            $this->modulesmodels->deleteResponsables($data);
            $this->decharge->removeTeachersDecharge($data);
            $this->contenu->removeTeacherforEachContenu($data);
            $this->uploadmodel->delAvatarUsers($data);
            $this->users->deleteUsers($data);
            $this->index("Le/les enseignant(s) ont étés supprimés.", "alert-success", "#deleteUsers");
        } else
            $this->index("Veuillez remplir correctement le formulaire", "alert-danger", "#deleteUsers");
    }

    /**
     * Recupération du contenu de chaque module.
     */
    public function getModuleContenus()
    {
        echo json_encode($this->contenu->getModuleContenus($this->input->get('gData')));
    }

    /**
     * Supprimer un des contenus du module.
     */
    public function deleteModuleContenu()
    {
        $array = array(
            "module" => $this->input->post('selectModuleShowContenu'),
            "partie" => $this->input->post('selectContenuModule')
        );
        if ($array['module'] != null && $array['partie'] != null) {
            $this->contenu->deleteContenuModule($array);
            $this->index("Les parties ont bien été supprimées.", "alert-success", "#deleteContenu");
            foreach ($this->input->post('selectContenuModule') as $contenuModule) {
                $this->news->addNews($this->session->userdata('username'), "delete-contenu", "Le contenu " . $contenuModule . " vient d'être supprimé du module : " . $array['module']);
            }
        } else
            $this->index("Veuillez remplir correctement les champs...", "alert-danger", "#deleteContenu");
    }

    /**
     * Ajouter un contenu à un module.
     */
    public function addContenuToModule()
    {
        $contenu = array(
            "module" => $this->input->post('selectModule'),
            "partie" => $this->input->post('moduleType'),
            "type" => $this->input->post('selectType'),
            "hed" => $this->input->post('moduleHed'),
            "enseignant" => null,
        );
        $res = $this->contenu->addContenuToModule($contenu);
        if ($res == "good") {
            $this->index("Votre contenu a été rajouté.", "alert-success", "#addContenu");
            $this->news->addNews($this->session->userdata('username'), "contenu",
                "Ajout d'une partie à un module", $contenu['module'], $contenu['partie']);
        } else
            $this->index($res['ErrorMessage'] . " " . $res['ErrorNumber'], "alert-danger", "#addContenu");
    }

    /**
     * Créer une news.
     */
    public function createNews()
    {
        if ($this->input->post('news')) {
            $result = $this->news->addNews($this->session->userdata('username'), "generale", $this->input->post('news'));
            if ($result) {
                $this->index("Votre news a étée rajoutée.", "alert-success", "#addNews");
            } else {
                $this->index("Il y a une erreur... C'est surement à cause de dev incompétents !",
                    "alert-danger", "#addNews");
            }
        } else {
            $this->index("Veuillez rentrer du texte...", "alert-danger", "#addNews");
        }
    }

    /**
     * Récupérer des informations sur les news afin de les afficher...
     */
    public function getInformationNews()
    {
        if ($this->input->get('DATE')) {
            echo $this->news->getInformation($this->input->get('DATE'));
        } else {
            echo "rien a afficher";
        }
    }

    /**
     * Supprimer une news.
     */
    public function removeNews()
    {
        if ($this->input->post('supprimer_news') != 'no') {
            if ($this->news->removeNews($this->input->post('supprimer_news'))) {
                $this->index("Supression OK", "alert-success", "#deleteNews");
            } else {
                $this->index("Erreur de supression", "alert-danger", "#deleteNews");
            }
        } else {
            $this->index("Erreur", "alert-danger");
        }
    }

    /**
     * Modifier une news.
     */
    public function modifyNews()
    {
        if ($this->input->post('modifier_news') != 'no') {
            if ($this->news->modifyNews($this->input->post('modifier_news'), $this->input->post('informationNewstoModify'))) {
                $this->index("Modification effectuée", "alert-success");
            } else {
                $this->index("Erreur lors de la modification. Veuillez retenter plus tard.", "alert-danger");
            }
        } else {
            $this->index("Erreur", "alert-danger");
        }
    }

    /**
     * Récupérer l'utilisateur qu'il faut modifier & ses informations.
     */
    public function getUserToModify()
    {
        if (!$this->decharge->getHoursDecharge($this->input->get('login'))) {
            echo json_encode($this->users->getUserDataByUsername($this->input->get('login')));
        } else {
            echo json_encode($this->users->getUserDataByUsernameJoinDecharge($this->input->get('login')));
        }
    }

    /**
     * Modifier l'utilisateur selectionné.
     */
    public function modifyUser()
    {
        $decharge = $this->input->post('dechargeModify');
        $enseignant = $this->input->post("enseignantsModify");
        $heuresprises = $this->contenu->getHeuresPrises($enseignant);

        if ($this->input->post('heuresModify') > $decharge && $this->input->post('heuresModify') > $heuresprises) {
            $statutaire = $this->input->post('heuresModify');
            if ($statutaire - $decharge > $heuresprises) {
                if ($decharge > 0) {
                    if ($this->decharge->isPresentInTable($enseignant)) {
                        $this->decharge->setDecharge($enseignant, $decharge);
                    } else {
                        $this->decharge->addNewDecharge($enseignant, $decharge);
                    }
                }
                if ($this->input->post('select_statutModify') != "autre") {
                    $statut = $this->input->post('select_statutModify');
                } else {
                    $statut = $this->input->post('status_perso');
                }
                if ($this->users->modifyUser(
                    $this->input->post("enseignantsModify"),
                    $this->input->post('heuresModify'),
                    $this->input->post('actifModify'),
                    $statut,
                    $this->input->post("select_admin"))
                )
                    $this->index("Modification effectuée", "alert-success", "#modifyUsers");
                else
                    $this->index("Modification pas effectuée, problème...", "alert-danger", "#modifyUsers");
            } else
                $this->index("Modification pas effectuée, trop de décharge tue la décharge...", "alert-danger", "#modifyUsers");
        }
        else{
            $this->index("Impossible de modifier le total d'heure. Vous avez choisi un total inférieur à la décharge et/ou inférieur au nombre d'heure déjà affecté.","alert-danger","#modifyUsers");
        }
    }

    /**
     * Recupere les informations d'un module pour ensuite l'afficher
     */
    public function modifyModuleAjax(){
       if($this->input->get('gData')!=null)
           echo json_encode($this->modulesmodels->getModule($this->input->get('gData')));
       else
           return false;
    }

    /**
     * Modifie un module : responsable et libellé
     */
    public function modifyModule()
    {
        $keys = array(
            "ident" => $this->input->post('selectModModule')
        );
        $data = array(
            "libelle" => $this->input->post('inputLibelle'),
            "responsable" => $this->input->post('selectResponsable')
        );
        $res = $this->modulesmodels->modifyModule($keys, $data);
        if ($res == "good")
            $this->index("Le module a bien été modifié", "alert-success", "#modifyModule");
        else
            $this->index("Un problème est survenu, veuillez réessayer ultérieurement.", "alert-danger", "#modifyModule");
    }

    /**
     * Permet de réinitialiser le mot de passe d'un enseignant
     */
    public
    function reinitMDP()
    {
        if ($this->users->changePassword("servicesENSSAT", $this->input->post('enseignantsInit'))) {
            $this->index("Mot de passe réinitialisé, il s'agit maintenant de servicesENSSAT", "alert-success", "#reinitUsers");
        } else {
            $this->index("Echec, c'est surement que vous êtes un petit malin qui essaye d'envoyer de fausses infos en post ;)", "alert-danger", "#reinitUsers");
        }
    }

}
