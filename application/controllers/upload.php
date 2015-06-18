<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include 'SRV_Controller.php';

class Upload extends SRV_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('is_logged_in')) {
            redirect('login');
        } else {
            $this->load->helper(array('form', 'url'));
            $this->load->model('users');
            $this->load->model('uploadmodel');
            $this->load->model('contenu');
            $this->load->model('decharge');
        }
    }

    function index($data)
    {
        $dataPercentage = $this->getPercentage($this->session->userdata('username'));
        $data['pourcentage'] = $dataPercentage['pourcentage'];
        $data['heuresprises'] = $dataPercentage['heuresprises'];
        $data['heurestotales'] = $dataPercentage['heurestotales'];
        $data['avatar'] = $this->users->getAvatar($this->session->userdata('username'));


        $this->load->view('header');
        $this->load->view('back/template/header', $data);
        $this->load->view('back/upload/upload', $data);
        $this->load->view('footer');
    }

    /**
     * Permet l'upload d'images pour le profil utilisateur
     * NOTE : les valeurs d'upload max seront à reconfigurer si le site est mis en production.
     * Pour des soucis de simplicités, il n'y a pas de limites décentes, toutes les images vont s'uploader...!
     */
    function do_upload()
    {
        $config['upload_path'] = getcwd() . '/uploads/';
        $config['allowed_types'] = 'jpg|jpeg';
        $config['max_size'] = '10000000000000';
        $config['max_width'] = '8000';
        $config['max_width'] = '8000';
        $config['max_height'] = '8000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $data = array(
                "error" => "Une erreur est survenue durant le téléchargement de votre image de profil. Veuillez rééssayer. Erreur : " . $this->upload->display_errors()
            );
        } else {
            $data = array(
                "error" => "Image uploadée"
            );
            $upload_data = $this->upload->data();
            $this->uploadmodel->changeAvatar($upload_data, $this->session->userdata('username'));
        }
        $this->index($data);
    }

    /**
     * Permet de supprimer l'image de l'utilisateur et de revenir à l'image par défaut.
     */
    public function remove()
    {
        $data = array(
            "error" => "Image supprimée"
        );
        $this->uploadmodel->delAvatar($this->session->userdata('username'));
        $this->index($data);
    }
}

?>