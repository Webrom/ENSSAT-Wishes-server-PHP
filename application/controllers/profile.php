<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */
class profile extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_logged_in')) {
            redirect('login');
        } else {
            $this->load->model('users');
            $this->load->model('contenu');
            $this->load->model('decharge');
        }
    }

    /**
     * @param null $uploadError
     * @param null $msg
     * @param null $success
     */
    public function index($uploadError = null, $msg = null, $success = null)
    {
        $data = array(
            "userInfos" => $this->users->getUserDataByUsername($this->session->userdata('username')),
            "success" => $success,
            "msg" => $msg,
            "uploadError" => $uploadError,
            "admin" => $this->session->userdata["admin"],
            "avatar" => $this->users->getAvatar($this->session->userdata('username')),
            "active" => "Profil",
            "decharge" => $this->decharge->getHoursDecharge($this->session->userdata('username'))
        );
        // TODO CINQUIEME FOIS QU'ON VOIS CETTE FOCNTION !!
        /* CALCUL POURCENTAGE HEURES PRISES */
        $heuresprises = $this->contenu->getHeuresPrises($this->session->userdata('username'));
        $heurestotales = $this->users->getHeures($this->session->userdata('username')) - $this->decharge->getHoursDecharge($this->session->userdata('username'));
        $pourcentage = round(($heuresprises / $heurestotales) * 100, 0);
        $data['pourcentage'] = $pourcentage;
        $data['heuresprises'] = $heuresprises;
        $data['heurestotales'] = $heurestotales;
        /* FIN CALCUL */

        $this->load->view('header', $data);
        $this->load->view('back/template/header');
        $this->load->view('back/profile/profile_panel', $data);
        $this->load->view('footer');
    }

    /**
     * Changement password, avec des vérifications :
     *   Si l'ancien password entré est le bon,
     *     Si les deux nouveaux password coincident et sont non nuls
     *       alors changer pwd
     *     sinon renvoyer message d'erreur
     *   sinon renvoyer message d'erreur
     */
    public function changePass()
    {
        $oldPass = $this->input->post("oldPass");
        $newPass1 = $this->input->post("newPass1");
        $newPass2 = $this->input->post("newPass2");

        if ($this->users->verifyUser($this->session->userdata('username'), $oldPass)) {
            if ($newPass1 == $newPass2) {
                if ($newPass1 != '') {
                    $this->users->changePassword($newPass1, $this->session->userdata('username'));
                    $this->index(null, "Votre mot de passe a été changé", "alert-success");
                } else {
                    $this->index(null, "Merci de donner un nouveau mot de passe non vide !", "alert-danger");
                }
            } else {
                $this->index(null, "Les nouveaux mots de passe ne correspondent pas ! ", "alert-danger");
            }
        } else {
            $this->index(null, "Votre ancien mot de passe n'est pas bon ! ", "alert-danger");
        }
    }


    public function modifyDecharge()
    {
        if ($this->decharge->isPresentInTable($this->session->userdata('username'))) {
            if ($this->input->post("inputDecharge") < $this->users->getHeures($this->session->userdata('username')) && $this->input->post("inputDecharge") <= $this->users->getHeures($this->session->userdata('username')) - $this->contenu->getHeuresPrises($this->session->userdata("username"))) {
                $this->decharge->setDecharge($this->session->userdata('username'), $this->input->post("inputDecharge"));
                $msg = "Votre decharge a été modifiée";
                $msgbox = "alert-success";
            } else {
                $msg = "Trop de décharge tue la décharge... Merci d'indiquer un nombre raisonable";
                $msgbox = "alert-danger";
            }
        } //On vérifie si la décharge est compatible
        else if ($this->input->post("inputDecharge") < $this->users->getHeures($this->session->userdata('username')) &&
            $this->input->post("inputDecharge") <= $this->users->getHeures($this->session->userdata('username')) - $this->contenu->getHeuresPrises($this->session->userdata("username"))
        ) {
            $this->decharge->addNewDecharge($this->session->userdata('username'), $this->input->post("inputDecharge"));
            $msg = "Votre decharge a été modifiée";
            $msgbox = "alert-success";
        } else {
            $msg = "Trop de décharge tue la décharge... Merci d'indiquer un nombre raisonable";
            $msgbox = "alert-danger";
        }
        $this->index(null, $msg, $msgbox);
    }
}
