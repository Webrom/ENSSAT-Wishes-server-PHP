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
        $this->load-> model('news');
        $this->load-> model('decharge');
    }

    public function index($msg=null,$success=null,$active=null){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else{
            $data = array(
                "admin" => $this->session->userdata['admin'],
                "active" => "Administration",
                "enseignants" => $this->users->getAllEnseignants(),
                "enseignantsContenu" => $this->users->getAllEnseignants(),
                "enseignantsModify" => $this->users->getAllEnseignants(),
                "enseignantsToAccept" => $this->users->getAllEnseignantsToAccept(),
                "semestres" => array("S1","S2","S3","S4","S5","S6"),
                "publics" => $this->modulesmodels->getAllPublic(),
                "modules" => $this->modulesmodels->getAllModules(),
                "msg" => $msg,
                "success" => $success,
                "status" =>  $status = $this->users->getStatus(),
                "moduleTypes" => $this->contenu->getAllModuleTypes(),
                "enAttente" => $this->users->ifSomeoneWait(),
                "activeOnglet" => $active,
                "allnews" => $this->news->getGeneralesNews()
            );

            /* CALCUL POURCENTAGE HEURES PRISES */
            $heuresprises = $this->contenu->getHeuresPrises($this->session->userdata('username'));
            $heurestotales = $this->users->getHeures()-$this->decharge->getHoursDecharge($this->session->userdata('username'));
            $pourcentage = round(($heuresprises/$heurestotales)*100,0);
            $data['pourcentage'] = $pourcentage;
            $data['heuresprises'] = $heuresprises;
            $data['heurestotales'] = $heurestotales;
            /* FIN CALCUL */

            $this->load->view('header',$data);
            $this->load->view('back/template/header');
            $this->load->view('back/admin/admin_panel',$data);
            $this->load->view('footer');
        }
    }

    public function setModuleContenusType(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0" ){
            redirect('login');
        }else {
            echo json_encode($this->contenu->getTypeContenu());
        }
    }

    /**
     * Modifie le contenu d'un module, modifie l'enseignant si ce dernier peut encore effectuer des heures,
     * idem lorsqu'on modifie les hed du contenu
     */
    public function modifyModuleContenu(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0" ){
            redirect('login');
        }else {
            $data = array(
                "partie" => $this->input->post('modulePartieAjax'),
                "type" => $this->input->post('selectTypeAjax'),
                "hed" => $this->input->post('moduleHedAjax'),
                "enseignant" => ($this->input->post('selectTeacher')!="")?$this->input->post('selectTeacher'):null,
            );
            $keys = array(
                "module" => $this->input->post('selectModuleShowContenu'),
                "partie" => $this->input->post('selectContenuModuleModification')
            );
            $hours = array(
                "teacherHours" => $this->users->getHeures(),
                "effectiveTeacherHours" => $this->contenu->getHeuresPrises($data['enseignant']),
                "decharge" => $this->decharge->getHoursDecharge($data['enseignant']),
                "hedContenu" => $this->contenu->getHeurePourUnContenu($keys['module'],$keys['partie'])
            );
            //test heures
            if($data['enseignant']==$this->contenu->getModuleTeacher(array(
                    "module" => $keys['module'],
                    "teacher" => $data['enseignant']
                )))
                $res = $hours['teacherHours']-$hours['decharge']+$hours['effectiveTeacherHours']-$hours['hedContenu'];
            else
                $res = $hours['teacherHours']-$hours['decharge']+$hours['effectiveTeacherHours'];
            if($res>=$data['hed'] || $data['enseignant']==null){
                $ret =$this->contenu->modifyModuleContenu($data,$keys);
                if($ret=="good")
                    $this->index('Le contenu du module a été modifié.',"alert-success","#modifyContenu");
                else
                    $this->index($ret['ErrorMessage'].$ret['ErrorNumber'],'alert-danger','#modifyContenu');
            }else
                $this->index($data['enseignant']." n'a pas assé d'heure de disponible pour ce contenu",'alert-danger','#modifyContenu');
        }
    }

    public function setModuleContenus(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0" ){
            redirect('login');
        }else {
            echo json_encode($this->contenu->getModuleContenusByPartieModule());
        }
    }

    public function addUser(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0" ){
            redirect('login');
        }else {
            $this->users->addUser("servicesENSSAT", $this->input->post("actif"), "1");
            $this->index("Utilisateur bien créé.", "alert-success","#addUser");
            $this->news->addNews($this->session->userdata('username'),"user","L'utilisateur : ".$this->input->post('prenom').$this->input->post('name')." a été ajouté.");
        }
    }

    public function acceptUsers(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0" ){
            redirect('login');
        }else {
            echo $this->users->acceptUsers($this->input->get('login'));
            $this->news->addNews($this->session->userdata('username'),"user","L'utilisateur : ".$this->input->get('login')." a été accepté.");
        }
    }

    public function refuseUsers(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0" ){
            redirect('login');
        }else {
            echo $this->users->refuseUsers($this->input->get('login'));
        }
    }

    public function addModule(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0" ){
            redirect('login');
        }else{
            $module= array(
                "ident" => $this->input->post('inputIdent'),
                "public" => $this->input->post('selectPublic'),
                "semestre" => $this->input->post('selectSemestre'),
                "libelle" => $this->input->post('inputLibelle'),
                "responsable" => strlen($this->input->post('selectResponsable')!=0)?$this->input->post('selectResponsable'):null
            );
            $res= $this->modulesmodels->addModule($module);
            if($res=="good") {
                $this->index("Votre module a été rajouté.", "alert-success", "");
                $this->news->addNews($this->session->userdata('username'), "module",
                    "Le module " . $this->input->post('inputIdent') . " vient d'être ajouté.",$module['ident']);
            }
            else {
                $this->index($res['ErrorMessage'] . " " . $res['ErrorNumber'], "alert-danger", "");
            }
        }
    }

    public function deleteModule(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            $modules = $this->input->post('module');
            if($modules!=null){
                $this->modulesmodels->deleteModuleContenu($modules);
                $this->index("Le/les modules ont étés supprimés.", "alert-success","#deleteModule");
                foreach ($modules as $MODULE) {
                    $this->news->addNews($this->session->userdata('username'), "module", "Le module " . $MODULE . " vient d'être supprimé.");
                }
            }else
                $this->index("Veuillez remplir correctement le formulaire", "alert-danger","#deleteModule");
        }
    }

    public function deleteUser(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            $data = $this->input->post('enseignants');
            if($data!=null){
                $this->users->deleteUsers($data);
                $this->contenu->removeALotEnseignanttoContenu($data);
                $this->index("Le/les enseignants ont étés supprimés.", "alert-success","#deleteUsers");
            }else
                $this->index("Veuillez remplire correctement le formulaire", "alert-danger","#deleteUsers");
        }
    }

    public function getModuleContenus(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else
            echo json_encode($this->contenu->getModuleContenus());
    }

    public function deleteModuleContenu(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else{
            $array = array(
                "module" => $this->input->post('selectModuleShowContenu'),
                "partie" => $this->input->post('selectContenuModule')
            );
            if($array['module']!=null && $array['partie']!=null){
                $this->contenu->deleteContenuModule($array);
                $this->index("Les parties ont bien été supprimées.","alert-success","#deleteContenu");
                foreach ($this->input->post('selectContenuModule') as $coucou){
                    $this->news->addNews($this->session->userdata('username'),"contenu", "Le contenu " .$coucou." vient d'être supprimé du module : ".$array['module'],$array['module']);
                }
            }else
                $this->index("Veuillez remplir correctement les champs","alert-danger","#deleteContenu");

        }
    }

    public function addContenuToModule(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            $res=$this->modulesmodels->addContenuToModule();
            if($res=="good") {
                $this->index("Votre contenu a été rajouté.", "alert-success", "#addContenu");
                $this->news->addNews($this->session->userdata('username'), "contenu",
                    "Le contenu " . $this->input->post('moduleType') . " a été ajouté au module "
                    . $this->input->post('selectModule') . ".",$this->input->post('selectModule'));
            }
            else
                $this->index($res['ErrorMessage']." ".$res['ErrorNumber'],"alert-danger","#addContenu");
        }
    }

    public function createNews(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            if ($this->input->post('news')) {
                $result = $this->news->addNews($this->session->userdata('username'), "generale", $this->input->post('news'));
                if ($result) {
                    $this->index("Votre news a étée rajoutée.", "alert-success","#addNews");
                } else {
                    $this->index("Il y a une erreur... C'est surement à cause de dev incompétents !",
                        "alert-danger","#addNews");
                }
            }
            else{
                $this->index("Veuillez rentrer du texte", "alert-danger","#addNews");
            }
        }
    }

    public function getInformationNews(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            if($this->input->get('DATE')){
                echo $this->news->getInformation($this->input->get('DATE'));
            }
            else{
                echo "rien a afficher";
            }
        }
    }

    public function removeNews(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            if($this->input->post('supprimer_news')!='no'){
                if ($this->news->removeNews($this->input->post('supprimer_news'))){
                    $this->index("Supression OK", "alert-success","#deleteNews");
                }
                else{
                    $this->index("Erreur de supression", "alert-danger","#deleteNews");
                }
            }
            else{
                $this->index("Erreur", "alert-danger");
            }
        }
    }

    public function modifyNews(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            if($this->input->post('modifier_news')!='no'){
                if ($this->news->modifyNews($this->input->post('modifier_news'),$this->input->post('informationNewstoModify'))){
                    $this->index("Modification effectuée", "alert-success");
                }
                else{
                    $this->index("Erreur lors de la modification. Veuillez retenter plus tard.", "alert-danger");
                }
            }
            else{
                $this->index("Erreur", "alert-danger");
            }
        }
    }
    
    public function getUserToModify(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            if(!$this->decharge->getHoursDecharge($this->input->get('login'))) {
                echo json_encode($this->users->getUserDataByUsername($this->input->get('login')));
            }
            else{
                echo json_encode($this->users->getUserDataByUsernameJoinDecharge($this->input->get('login')));
            }
        }
    }

    public function modifyUser(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            if($this->input->post('dechargeModify')>0){
                $data = array(
                    'decharge' => $this->input->post('dechargeModify'),
                    'enseignant' =>$this->input->post("enseignantsModify")
                );
                $this->decharge->addNewDecharge($data);
            }
            if($this->users->modifyUser(
                $this->input->post("enseignantsModify"),
                $this->input->post('heuresModify'),
                $this->input->post('actifModify'),
                $this->input->post('select_statutModify')))

                $this->index("Modification effectuée", "alert-success","#modifyUsers");
            else
                $this->index("Modification pas effectuée, problème", "alert-danger","#modifyUsers");
        }
    }
}