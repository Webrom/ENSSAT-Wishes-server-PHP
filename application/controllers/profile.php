<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 26/05/15
 * Time: 12:52
 */

include 'SRV_Controller.php';

class profile extends SRV_Controller
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

        $dataPercentage = $this->getPercentage($this->session->userdata('username'));
        $data['pourcentage'] = $dataPercentage['pourcentage'];
        $data['heuresprises'] = $dataPercentage['heuresprises'];
        $data['heurestotales'] = $dataPercentage['heurestotales'];

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

    /**
     * Fonction pour modifier le statutaire de l'utilisateur courrant
     * A noter : l'utilisateur est une fois de plus considéré comme responsable: aucune vérification ne
     * sera faite sur le statutaire qu'il s'ajoute (exemple : possible de changer à 10000 heures.)
     */
    public function modifyStatutaire()
    {
        $newStatutaire = $this->input->post("inputStatutaire");
        if ($newStatutaire > $this->decharge->getHoursDecharge($this->session->userdata('username')) && $newStatutaire > $this->contenu->getHeuresPrises($this->session->userdata('username'))) {
            if ($this->users->setStatutaire($newStatutaire, $this->session->userdata('username'))) {
                $msg = "Votre statutaire a été modifié.";
                $msgbox = "alert-success";
            } else {
                $msg = "Votre statutaire n'est pas modifiable.";
                $msgbox = "alert-danger";
            }
        }
        else{
            $msg = "Impossible de modifier votre total d'heure. Vous avez choisi un total inférieur à votre décharge et/ou inférieur au nombre d'heure déjà affecté.";
            $msgbox = "alert-danger";
        }

        $this->index(null, $msg, $msgbox);
    }

    /**
     * Fonction pour modifer la décharge de l'utilisateur courant
     */
    public function modifyDecharge()
    {
        if ($this->decharge->isPresentInTable($this->session->userdata('username'))) {
            if ($this->input->post("inputDecharge") < $this->users->getStatutaire($this->session->userdata('username')) && $this->input->post("inputDecharge") <= $this->users->getStatutaire($this->session->userdata('username')) - $this->contenu->getHeuresPrises($this->session->userdata("username"))) {
                $this->decharge->setDecharge($this->session->userdata('username'), $this->input->post("inputDecharge"));
                $msg = "Votre decharge a été modifiée.";
                $msgbox = "alert-success";
            } else {
                $msg = "Trop de décharge tue la décharge... Merci d'indiquer un nombre raisonable.";
                $msgbox = "alert-danger";
            }
        } //On vérifie si la décharge est compatible
        else if ($this->input->post("inputDecharge") < $this->users->getStatutaire($this->session->userdata('username')) &&
            $this->input->post("inputDecharge") <= $this->users->getStatutaire($this->session->userdata('username')) - $this->contenu->getHeuresPrises($this->session->userdata("username"))
        ) {
            $this->decharge->addNewDecharge($this->session->userdata('username'), $this->input->post("inputDecharge"));
            $msg = "Votre decharge a été modifiée.";
            $msgbox = "alert-success";
        } else {
            $msg = "Trop de décharge tue la décharge... Merci d'indiquer un nombre raisonable.";
            $msgbox = "alert-danger";
        }
        $this->index(null, $msg, $msgbox);
    }
}
