<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 15:35
 */

class homeNews extends CI_Controller {
    function __construct(){
        parent::__construct();
        //charger le modele users
        $this->load-> model('users');
        $this->load-> model('contenu');
        $this->load-> model('decharge');
    }
    
    public function index(){
        if(!$this->session->userdata('is_logged_in')){
            redirect('login');
        }else{
            $data = array(
                "admin" => $this->session->userdata['admin'],
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
            $this->load->view('footer');
        }
    }
}