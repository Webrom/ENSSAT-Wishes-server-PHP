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
                "active" => $active,
                "allnews" => $this->news->getGeneralesNews()
            );
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
                    $this->index('Le contenu du module a été modifié.',"alert-success","Contenu");
                else
                    $this->index($ret['ErrorMessage'].$ret['ErrorNumber'],'alert-danger','Contenu');
            }else
                $this->index($data['enseignant']." n'a pas assé d'heure de disponible pour ce contenu",'alert-danger','Contenu');
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
            $this->index("Utilisateur bien créé.", "alert-success","Utilisateurs");
        }
    }

    public function acceptUsers(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0" ){
            redirect('login');
        }else {
            echo $this->users->acceptUsers($this->input->get('login'));
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
            $res= $this->modulesmodels->addModule();
            if($res=="good")
                $this->index("Votre module a été rajouté.","alert-success","Modules");
            else
                $this->index($res['ErrorMessage']." ".$res['ErrorNumber'],"alert-danger","Module");
        }
    }

    public function deleteModule(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            $this->modulesmodels->deleteModule();
            $this->index("Le/les modules ont étés supprimés.", "alert-success","Module");
        }
    }

    public function deleteUser(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            $this->users->deleteUsers();
            $this->contenu->removeALotEnseignanttoContenu($this->input->post('enseignants'));
            $this->index("Le/les enseignants ont étés supprimés.", "alert-success","Utilisateurs");
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
            $this->contenu->deleteContenuModule();
            $this->index("Les parties ont bien été supprimées.","alert-success","Contenu");
        }
    }

    public function addContenuToModule(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            $res=$this->modulesmodels->addContenuToModule();
            if($res=="good")
                $this->index("Votre contenu a été rajouté.","alert-success","Contenu");
            else
                $this->index($res['ErrorMessage']." ".$res['ErrorNumber'],"alert-danger","Contenu");
        }
    }

    public function createNews(){
        if(!$this->session->userdata('is_logged_in') || $this->session->userdata['admin']=="0"){
            redirect('login');
        }else {
            if ($this->input->post('news')) {
                $result = $this->news->addNews($this->session->userdata('username'), "generale", $this->input->post('news'));
                if ($result) {
                    $this->index("Votre nouvelle a étée rajoutée.", "alert-success");
                } else {
                    $this->index("Il y a une erreur... C'est surement à cause de dev incompétents !", "alert-danger");
                }
            }
            else{
                $this->index("Veuillez rentrer du texte", "alert-danger");
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
                    $this->index("Supression OK", "alert-success");
                }
                else{
                    $this->index("Erreur de supression", "alert-danger");
                }
            }
            else{
                $this->index("Erreur", "alert-danger");
            }
        }
    }
}